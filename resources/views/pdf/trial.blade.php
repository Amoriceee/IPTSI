<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
* {
  font-family:'Motnserrat',sans-serif;
  font-size: 12px;
}
.client-table {
  width: 90%;
  margin: 0 auto;
  text-align: center;
  border-collapse: collapse;
}
.client-table th, .client-table td  {
  border-right: 1px solid black;
}
.client-table th:last-child, .client-table td:last-child  {
  border-right: none;
}
.client-table tr th {
  width: 25%;
  font-size: 14px;
  color: #7691ab;
}

#logo {
  width:300px;
  position: absolute;
  left: 200px;
}
.pipe-table {
  width: 98%;
  margin: 0 auto;
  text-align: center;
  border-collapse: collapse;
  background-color: white;
  overflow: hidden;
  border-radius: 3px;
}
.pipe-table tr {
  line-height: 10px;
  height: 10px;
}
.page-break-a {
  page-break-after: always;
}
.pipe-table th, .pipe-table td {
  padding: 10px;
}
.pipe-table th {
  background-color: #7691ab;
  color: white;
}
.pipe-table td {
  border-bottom: 1px solid #7691ab;
}
.width40 {
  width: 35%;
}
.width40 td {
  width: 50%;
}
.final {
  font-weight: bolder;
}
header {
  position: fixed;
  top: -60px;
  left: 0px;
  right: 0px;
  height: 50px;
  /** Extra personal styles **/
  background-color: #03a9f4;
  color: white;
  text-align: center;
  line-height: 35px;
}
.i-table th {
  text-align: right;
}
.i-table {
  position: absolute;
  top: 80px;
  right: 140px;
}
</style>
<body>
  <div id="PAGE1" class="page-break-a">
    <div class="head">
      <img id="logo" src="img/board.png" alt="" />
      <table class="i-table">
        <tr>
          <th>Invoice No:</th>
          <td>{{$indInvoice->id}}</td>
        </tr>
        <tr>
          <th>Invoice Date:</th>
          <td>{{$indInvoice->invoice_date}}</td>
        </tr>
      </table>
    </div>
    <div style="position:absolute; top:200px;">
      <table class="client-table">
        <tr>
          <th>Name</th>
          <th>Shop Name</th>
          <th>Location</th>
          <th>Phone</th>
        </tr>
        <tr>
          <td>{{$client->client_name}}</td>
          <td>{{$client->shop_name}}</td>
          <td>{{$client->shop_location}}</td>
          <td>{{$client->phone}}</td>
        </tr>
      </table>
      <table class="pipe-table" style="margin-top:40px;">
        <tr>
          <th>QTY</th>
          <th>DESCRIPTION</th>
          <th>SWG</th>
          <th>RATE</th>
          <th>LINE TOTAL</th>
          <th>WEIGHT</th>
        </tr>
        @foreach($invoicePipe1 as $ip)
        <tr class="page-b">
          <td>{{$ip->quantity}}</td>
          <td>{{$ip->pipes->pipe_description}}</td>
          <td>{{$ip->pipes->swg}}</td>
          <td>{{$ip->rate}}</td>
          <td>{{ number_format(round($ip->pipes->base_price * (($ip->rate + 100) / 100) * 20 * $ip->quantity, 0)) }}</td>
          <td>{{ number_format(round($ip->pipes->min_weight * $ip->quantity, 0)) }}</td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
  @if(!$invoicePipe2->isEmpty())
  <div id="PAGE2" class="page-break-a">
    <div class="head">
      <img id="logo" src="img/board.png" alt="" />
    </div>
    <div style="position:absolute; top:160px;">
      <table class="pipe-table" style="margin-top:40px;">
        <tr>
          <th>QTY</th>
          <th>DESCRIPTION</th>
          <th>SWG</th>
          <th>RATE</th>
          <th>LINE TOTAL</th>
          <th>WEIGHT</th>
        </tr>
        {{ $invoicePipe2 }}
        @foreach($invoicePipe2 as $ip)
        <tr class="page-b">
          <td>{{$ip->quantity}}</td>
          <td>{{$ip->pipes->pipe_description}}</td>
          <td>{{$ip->pipes->swg}}</td>
          <td>{{$ip->rate}}</td>
          <td>{{ number_format(round($ip->pipes->base_price * (($ip->rate + 100) / 100) * 20 * $ip->quantity, 0)) }}</td>
          <td>{{ number_format(round($ip->pipes->min_weight * $ip->quantity, 0)) }}</td>
        </tr>
        @endforeach
      </table>
    </div>
  </div>
  @endif
  <div id="PAGE3">
    <div class="head">
      <img id="logo" src="img/board.png" alt="" />
    </div>
    <div style="position:absolute; top:200px;">
      <table class="pipe-table width40">
        <tr>
          <td style="text-align:right">No Pipes:</td>
          <td style="text-align:left">{{ number_format(round($no_pipes,0)) }}</td>
        </tr>
        <tr>
          <td style="text-align:right">Weight:</td>
          <td style="text-align:left">{{ number_format(round($min_weight,0)) }} kg</td>
        </tr>
        <tr>
          <td style="text-align:right">Sub Total:</td>
          <td style="text-align:left">{{ number_format(round($sub_total,0)) }}</td>
        </tr>
        <tr>
          <td style="text-align:right">Loading Charges:</td>
          <td style="text-align:left">{{ number_format(round($loading_charges,0)) }}</td>
        </tr>
        <tr class="final">
          <td style="text-align:right">Grand Total:</td>
          <td style="text-align:left">{{ number_format($grand_total) }}</td>
        </tr>
      </table>
    </div>
  </div>
</body>

</html>
