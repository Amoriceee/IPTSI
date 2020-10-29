@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/ledgers.css') }}" rel="stylesheet">
<link href="{{ asset('css/table-style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <section>
    <form method="POST" action="" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="select-box">
        <select id="client_list" class="select-client" name="client_id" onchange="this.form.submit()">
          <option value="all" selected="selected" disabled>Select A Ledger</option>
          @foreach($clientList as $client)
            <option value="{{ $client->id }}" <?php if($request->client_id == $client->id) echo 'selected="selected"'; ?>>{{ $client->client_name }}</option>
          @endforeach
        </select>
      </div>
    </form>
  </section>
  @if($request->has('client_id'))
  @php
  $credit_inv = 0;
  $credit_ledg = 0;
  $debit_ledg = 0;
  @endphp
  @foreach($clientInvoices as $pro)
    @php
    $wt = 0;
    $gt = 0;
    @endphp
    @foreach($pro->pipeinv as $pi)
    <?php $wt += ($pi->pipes->min_weight * $pi->quantity); ?>
    <?php $gt += Round(($pi->pipes->base_price * (($pi->rate + 100) / 100) * 20 * $pi->quantity) + ($pi->pipes->min_weight * $pi->quantity) * 0.25, 0); ?>
    <?php $credit_inv += Round(($pi->pipes->base_price * (($pi->rate + 100) / 100) * 20 * $pi->quantity) + ($pi->pipes->min_weight * $pi->quantity) * 0.25, 0); ?>
    @endforeach
  @endforeach
  @foreach($clientLedgers as $led)
  @if($led->cd == 'Credit')
  <?php $credit_ledg += $led->amount; ?>
  @else
  <?php $debit_ledg += $led->amount; ?>
  @endif
  @endforeach
  <section>
    <div class="production-results">
      <div class="table4">
        <div class="row header">
          <div class="cell">Credit</div>
          <div class="cell">Debit</div>
          <div class="cell">Balance</div>
        </div>
        <div class="row">
          <div class="cell" data-title="">{{number_format($credit_inv + $credit_ledg)}}</div>
          <div class="cell" data-title="">{{number_format($debit_ledg)}}</div>
          <div class="cell" data-title="">{{number_format($credit_inv + $credit_ledg - $debit_ledg)}}</div>
        </div>
      </div>
    </div>
  </section>
  <section>
    <div class="production-results">
      <div class="table3">
        <div class="row header">
          <div class="cell">Invoice ID</div>
          <div class="cell">Invoice Date</div>
          <div class="cell">Weight</div>
          <div class="cell">Grand Total</div>
          <div class="cell">Status</div>
          <div class="cell"></div>
        </div>
        @foreach($clientInvoices as $pro)
          <div class="row">
            <div class="cell" data-title="ID">{{ $pro->id }}</div>
            <div class="cell" data-title="Invoice Date">{{ date('d-m-Y', strtotime($pro->invoice_date)) }}</div>
            <div class="cell" data-title="Weight">{{number_format($wt)}}kg</div>
            <div class="cell" data-title="Grand Total">{{number_format($gt)}}</div>
            @if($pro->authorised == 0 && $pro->loaded == 0)
            <div class="cell re" data-title="Status">Pending</div>
            @elseif($pro->authorised == 1 && $pro->loaded == 0)
            <div class="cell or" data-title="Status">Loading</div>
            @else
            <div class="cell gr" data-title="Status">Completed</div>
            @endif
            <div class="cell" data-title=""></div>
          </div>
        @endforeach
        <div class="row header">
          <div class="cell">Payment ID</div>
          <div class="cell">Ledger Date</div>
          <div class="cell">Payment Type</div>
          <div class="cell">Credit/Debit</div>
          <div class="cell">Recieved By</div>
          <div class="cell"></div>
        </div>
        @foreach($clientLedgers as $led)
        <div class="row">
          <div class="cell" data-title="ID">{{ $led->id }}</div>
          <div class="cell" data-title="ID">{{ date('d-m-Y', strtotime($led->payment_date)) }}</div>
          <div class="cell" data-title="Amount">{{ number_format($led->amount) }}</div>
          <div class="cell" data-title="Type">{{ $led->payment_type }} | {{ $led->cd }}</div>
          <div class="cell" data-title="CD">{{ $led->users->name }}<br>{{ $led->created_at }}</div>
          <div class="cell" data-title="x">x</div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <section>
    <form method="POST" action="/ledgers/new" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="search-box">
        <div class="block-item">
          <input type="hidden" name="client_id" value="{{ $request->client_id }}"/>
          <input type="date" name="ledger_date" class="form-control input-lg add-item" value="<?php echo date("Y-m-d");?>"/>
        </div>
        <div class="block-item">
          <input type="text" name="ledger_amount" class="form-control input-lg add-item" placeholder="Amount" autocomplete="off"/>
        </div>
        <div class="block-item">
            <select class="add-item" name="ledger_payment">
              <option selected="true" disabled="disabled">Payment Type</option>
              <option value="Cash">Cash</option>
              <option value="Cheque">Cheque</option>
              <option value="Bank Transfer">Bank Transfer</option>
            </select>
        </div>
        <div class="block-item">
            <select class="add-item" name="ledger_type">
              <option selected="true" value="Debit">Debit</option>
              <option value="Credit">Credit</option>
            </select>
        </div>
        <div class="block-item">
          <button type="submit" name="add_submit" class="form-control input-lg add-item">APPLY</button>
        </div>
      </div>
    </form>
  </section>
  @endif
</div>
@endsection
