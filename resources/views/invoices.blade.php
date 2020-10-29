@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/invoices.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <section id="new">
    <a href="/invoices/create">
      <div class="create-button">
        CREATE NEW INVOICE
      </div>
    </a>
  </section>
  <section id="cards">
    <div class="inv-cards">
      <div class="inv-card">
        <h2>PENDING</h2>
        <h3>{{ $invoicePending }}</h3>
      </div>
      <div class="inv-card">
        <h2>LOADING</h2>
        <h3>{{ $invoiceLoading }}</h3>
      </div>
      <div class="inv-card">
        <h2>COMPLETED</h2>
        <h3>{{ $invoiceCompleted }}</h3>
      </div>
    </div>
  </section>
  <section>
    <form method="POST" action="" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="select-box">
        <select id="client_list" class="select-client" name="client_id" onchange="this.form.submit()">
          <option value="all" <?php if(isset($_POST['client_id']) && $_POST['client_id'] == "all") echo 'selected="selected"';?>>All Invoices</option>
          @foreach($clientList as $client)
          <option value="{{ $client->id }}" <?php if(isset($_POST['client_id']) && $_POST['client_id'] == $client->id) echo 'selected="selected"';?>>{{ $client->client_name }}</option>
          @endforeach
        </select>
      </div>
    </form>
    @foreach($invoiceList as $invoice)
    @php
    $tt = 0;
    @endphp
    <div class="invoice-card">
      <div class="cl cl-1">
        <h2>{{ $invoice->clients->client_name }}</h2>
        <h3>{{ $invoice->invoice_date }}</h3>
      </div>
      <div class="cl cl-2">
        <h2>WEIGHT</h2>
        @foreach($invoice->pipeinv as $pi)
          <?php $tt += ($pi->pipes->min_weight * $pi->quantity); ?>
        @endforeach
        <h3>{{number_format($tt)}} kg</h3>
      </div>
      <div class="cl cl-3">
        <h2>STATUS</h2>
        @if($invoice->authorised == 0 && $invoice->loaded == 0)
        <h3 class="re">Pending</h3>
        @elseif($invoice->authorised == 1 && $invoice->loaded == 0)
        <h3 class="or">Loading</h3>
        @else
        <h3 class="gr">Completed</h3>
        @endif
      </div>
      <div class="cl cl-4">
        <a href="/invoices/{{ $invoice->id }}">
          <h3>&#8658;</h3>
        </a>
      </div>
    </div>
    @endforeach
    {!! $invoiceList->render() !!}
  </seciton>
</div>
@endsection
