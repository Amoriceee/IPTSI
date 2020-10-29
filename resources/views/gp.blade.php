@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/gatepass.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <section>
    @foreach($invoiceList as $invoice)
    @php
    $tt = 0;
    @endphp
    <div class="invoice-card">
      @foreach($invoice->pipeinv as $pi)
        <?php $tt += ($pi->pipes->min_weight * $pi->quantity); ?>
      @endforeach
      <div class="cl cl-1">
        <h2>{{ $invoice->clients->client_name }}</h2>
        <h3>{{ number_format($tt) }} kg</h3>
      </div>
      <div class="cl cl-2">
        <h2>Expected Delivery Date</h2>
        <h3>{{ $invoice->delivery_date }}</h3>
      </div>
      <div class="cl cl-4">
        <a href="/gatepass/{{ $invoice->id }}">
          <h3>&#8658;</h3>
        </a>
      </div>
    </div>
    @endforeach
    {!! $invoiceList->render() !!}
  </seciton>
</div>
@endsection
