<?php

namespace App\Http\Controllers;

use App\Gatepass;
use App\Invoice;
use App\PipeInvoice;
use App\Clients;
use App\Pipe;
use App\Ledgers;
use DB;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LedgersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clientList = Clients::all();

        return view('ledgers', ['clientList' => $clientList, 'request' => $request]);
    }

    public function ledgerLoad(Request $request)
    {

      $clientList = Clients::all();
      $clientInvoices = Invoice::where('client_id', '=', $request->client_id)->orderBy('invoice_date', 'DESC')->orderBy('id', 'DESC')->get();
      $clientLedgers = Ledgers::where('client_id', '=', $request->client_id)->orderBy('payment_date', 'DESC')->orderBy('id', 'DESC')->get();
      //dd($clientLedgers);
      return view('ledgers', ['clientList' => $clientList, 'clientInvoices' => $clientInvoices, 'clientLedgers' => $clientLedgers, 'request' => $request]);

    }

    public function addLedger(Request $request)
    {
      $request->validate([
       'client_id' => 'required',
       'ledger_date' => 'required|date',
       'ledger_amount' => 'required|integer',
       'ledger_payment' => 'required',
       'ledger_type' => 'required',
     ]);

      $ledger = new Ledgers();
      $ledger->client_id = $request->client_id;
      $ledger->payment_date = $request->ledger_date;
      $ledger->amount = $request->ledger_amount;
      $ledger->payment_type = $request->ledger_payment;
      $ledger->cd = $request->ledger_type;
      $ledger->recieved_by = \Auth::user()->id;
      $ledger->save();

    return $this->ledgerLoad($request);
  }

}
