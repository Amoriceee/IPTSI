<?php

namespace App\Http\Controllers;

use App\Gatepass;
use App\Invoice;
use App\PipeInvoice;
use App\Clients;
use App\Pipe;
use DB;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;

class GatepassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $invoiceList = Invoice::where('authorised', '=', 1)->where('loaded', '=', 0)->orderBy('invoice_date', 'DESC')->paginate(8);

        return view('gp', ['invoiceList' => $invoiceList]);
    }

    public function indexload(Request $request, $id)
    {

        $invoiceID = $id;
        $indInvoice = Invoice::where('id', '=', $invoiceID)->get()->first();
        $clientId = Invoice::where('id', '=', $invoiceID)->pluck('client_id')->first();
        $client = Clients::where('id', '=', $clientId)->get()->first();
        $gp = Gatepass::where('invoice_id', '=', $invoiceID)->get();

        return view('ind-gp', ['client' => $client, 'indInvoice' => $indInvoice, 'gp' => $gp]);
    }

    public function sendSMS(Request $request, $id)
    {

      //VALIDATE
      $request->validate([
       'net_weight' => 'required|integer',
       'vehicle_reg' => 'required|string',
       'phone_number' => 'required|min:7',
     ]);

     //CLIENT
     $invoiceID = $id;
     $clientId = Invoice::where('id', '=', $invoiceID)->pluck('client_id')->first();
     $clientPhone = Clients::where('id', '=', $clientId)->pluck('phone')->first();

      //SAVE
      $gp = new Gatepass();
      $gp->invoice_id = $invoiceID;
      $gp->net_weight = $request->net_weight;
      $gp->vehicle_reg = $request->vehicle_reg;
      $gp->phone = $request->phone_number;
      $gp->save();

      //SEND SMS
      $username = "923110000589";///Your Username
      $password = "iamyeshua26";///Your Password
      $mobile = $clientPhone;///Recepient Mobile Number
      $sender = "IPTSI";
      $message = $request->vehicle_reg . ' has left IPTSI with ' . $request->net_weight . 'kg. Driver No: ' . $request->phone_number;

      ////sending sms
      $post = "sender=".urlencode($sender)."&mobile=".urlencode($mobile)."&type=unicode&message=".urlencode($message)."";
      $url = "https://sendpk.com/api/sms.php?username=$username&password=$password";
      $ch = curl_init();
      $timeout = 30; // set to zero for no timeout
      curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');
      curl_setopt($ch, CURLOPT_URL,$url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
      $result = curl_exec($ch);

      return redirect()->back();

    }

    public function togComplete(Request $request, $id)
    {

     //INVOICE
     $invoiceID = $id;
     $indInvoice = Invoice::where('id', '=', $invoiceID)->get()->first();
     $indInvoice->loaded = !$indInvoice->loaded;
     $indInvoice->save();

     return redirect()->back();

    }

    public function delGp($id)
    {

     DB::table('gatepasses')->where('id', $id)->delete();
     return redirect()->back();

    }

}
