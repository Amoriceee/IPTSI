<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\PipeInvoice;
use App\Clients;
use App\Pipe;
use DB;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->has('client_id') && $request->client_id != 'all'){

          $clientList = Clients::all();
          $invoiceList = Invoice::where('client_id', '=', $request->client_id)->where('loaded', '=', 0)->orderBy('invoice_date', 'DESC')->paginate(8);
          $invoicePending = Invoice::where('client_id', '=', $request->client_id)->where('authorised', '=', 0)->where('loaded', '=', 0)->count();
          $invoiceLoading = Invoice::where('client_id', '=', $request->client_id)->where('authorised', '=', 1)->where('loaded', '=', 0)->count();
          $invoiceCompleted = Invoice::where('client_id', '=', $request->client_id)->where('authorised', '=', 1)->where('loaded', '=', 1)->count();

          return view('invoices', ['clientList' => $clientList, 'invoiceList' => $invoiceList, 'invoicePending' => $invoicePending, 'invoiceLoading' => $invoiceLoading, 'invoiceCompleted' => $invoiceCompleted]);

        } else {
          $clientList = Clients::all();
          $invoiceList = Invoice::where('loaded', '=', 0)->orderBy('invoice_date', 'DESC')->paginate(8);
          $invoicePending = Invoice::where('authorised', '=', 0)->where('loaded', '=', 0)->count();
          $invoiceLoading = Invoice::where('authorised', '=', 1)->where('loaded', '=', 0)->count();
          $invoiceCompleted = Invoice::where('authorised', '=', 1)->where('loaded', '=', 1)->count();

          return view('invoices', ['clientList' => $clientList, 'invoiceList' => $invoiceList, 'invoicePending' => $invoicePending, 'invoiceLoading' => $invoiceLoading, 'invoiceCompleted' => $invoiceCompleted]);
        }

    }

    public function indindex(Request $request)
    {
      $clientList = Clients::all();

      return view('ind-invoices', ['clientList' => $clientList]);

    }

    public function indindexload(Request $request, $id)
    {
      $invoiceID = $id;
      $indInvoice = Invoice::where('id', '=', $invoiceID)->get()->first();
      $invoicePipe = PipeInvoice::where('invoice_id', '=', $invoiceID)->get();
      $clientId = Invoice::where('id', '=', $invoiceID)->pluck('client_id')->first();
      $client = Clients::where('id', '=', $clientId)->get()->first();

      return view('ind-invoices-load', ['client' => $client, 'indInvoice' => $indInvoice, 'invoicePipe' => $invoicePipe]);

    }

    public function togauth(Request $request, $id)
    {

      $indInvoice = Invoice::where('id', '=', $id)->get()->first();
      $indInvoice->authorised = !$indInvoice->authorised;
      $indInvoice->save();

      return redirect()->back();

    }

    public function printPDF(Request $request, $id)
    {
       $invoiceID = $id;
       $indInvoice = Invoice::where('id', '=', $invoiceID)->get()->first();
       $invoicePipe1 = PipeInvoice::where('invoice_id', '=', $invoiceID)->orderBy('id', 'ASC')->offset(0)->limit(22)->get();
       $invoicePipe2 = PipeInvoice::where('invoice_id', '=', $invoiceID)->orderBy('id', 'ASC')->offset(22)->limit(22)->get();
       $clientId = Invoice::where('id', '=', $invoiceID)->pluck('client_id')->first();
       $client = Clients::where('id', '=', $clientId)->get()->first();

       $sub_total = 0;
       $loading_charges = 0;
       $no_pipes = 0;
       $min_weight = 0;

       foreach($invoicePipe1 as $ip){
         $sub_total = $sub_total + round($ip->pipes->base_price * (($ip->rate + 100) / 100) * 20 * $ip->quantity, 0);
         $loading_charges = $loading_charges + (round($ip->pipes->min_weight * $ip->quantity, 0) * 0.25);
         $no_pipes = $no_pipes + $ip->quantity;
         $min_weight = $min_weight + round($ip->pipes->min_weight * $ip->quantity, 0);
       }
       foreach($invoicePipe2 as $ip){
         $sub_total = $sub_total + round($ip->pipes->base_price * (($ip->rate + 100) / 100) * 20 * $ip->quantity, 0);
         $loading_charges = $loading_charges + (round($ip->pipes->min_weight * $ip->quantity, 0) * 0.25);
         $no_pipes = $no_pipes + $ip->quantity;
         $min_weight = $min_weight + round($ip->pipes->min_weight * $ip->quantity, 0);
       }

       $grand_total = $sub_total + $loading_charges;

        $pdf = PDF::loadView('pdf.trial', compact('indInvoice', 'invoicePipe1', 'invoicePipe2', 'client', 'loading_charges' , 'sub_total', 'grand_total', 'no_pipes', 'min_weight'));
        return $pdf->stream();
    }

    public function destroyInvoicePipes($id)
    {
      DB::table('pipe_invoices')->where('invoice_id', $id)->delete();
      return redirect()->back();
    }

    public function savePost(Request $request)
    {
      $request->validate([
       'client_id' => 'required',
       'invoice_date' => 'required|date',
       'delivery_date' => 'required|date',
       'pipe_description.*' => 'required',
       'pipe_swg.*' => 'required',
       'pipe_qty.*' => 'required',
       'pipe_rate.*' => 'required'
     ]);

     $client_id = $request->client_id;
     $invoice_date = $request->invoice_date;
     $delivery_date = $request->delivery_date;
     $user_id = \Auth::user()->id;

     //InvoiceModel
     $InvoiceModel = new Invoice();
     $InvoiceModel->client_id = $client_id;
     $InvoiceModel->user_id = $user_id;
     $InvoiceModel->invoice_date = $invoice_date;
     $InvoiceModel->delivery_date = $delivery_date;
     $InvoiceModel->save();

     //InvoicePipeModel
     foreach($request->pipe_description as $key => $value) {
       $InvoicePipeModel = new PipeInvoice();
       $InvoicePipeModel->invoice_id = $InvoiceModel->id;
       $InvoicePipeModel->pipe_id = DB::table('pipes')->where('pipe_description', $request->pipe_description[$key])->where('swg', $request->pipe_swg[$key])->pluck('id')->first();
       $InvoicePipeModel->quantity = $request->pipe_qty[$key];
       $InvoicePipeModel->rate = $request->pipe_rate[$key];
       $InvoicePipeModel->save();
     }

     return redirect()->route('invoice.id', [$InvoiceModel->id]);

    }

    public function invoiceSort(Request $request, $id) {

      if($request->has('save-form')) {

          $request->validate([
            'pipe_description.*' => 'required',
            'pipe_swg.*' => 'required',
            'pipe_qty.*' => 'required',
            'pipe_rate.*' => 'required'
         ]);

         DB::table('pipe_invoices')->where('invoice_id', $id)->delete();
         //InvoicePipeModel
         foreach($request->pipe_description as $key => $value) {
           $InvoicePipeModel = new PipeInvoice();
           $InvoicePipeModel->invoice_id = $id;
           $InvoicePipeModel->pipe_id = DB::table('pipes')->where('pipe_description', $request->pipe_description[$key])->where('swg', $request->pipe_swg[$key])->pluck('id')->first();
           $InvoicePipeModel->quantity = $request->pipe_qty[$key];
           $InvoicePipeModel->rate = $request->pipe_rate[$key];
           $InvoicePipeModel->save();
         }

        return redirect()->route('invoice.id', $id);


      }

    }

    public function destroyAll(Request $request, $id) {

      DB::table('pipe_invoices')->where('invoice_id', $id)->delete();
      DB::table('invoices')->where('id', $id)->delete();

      return redirect()->route('invoice.main');

    }
}
