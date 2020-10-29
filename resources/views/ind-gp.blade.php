@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/gatepass.css') }}" rel="stylesheet">
<link href="{{ asset('css/table-style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  @php
  $tt = 0;
  @endphp
  @foreach($indInvoice->pipeinv as $pi)
    <?php $tt += ($pi->pipes->min_weight * $pi->quantity); ?>
  @endforeach
  <section id="client-info">
    <div class="table">
      <div class="row header">
        <div class="cell">Client Name</div>
        <div class="cell">Shop Name</div>
        <div class="cell">Invoice Date</div>
        <div class="cell">Delivery Date</div>
        <div class="cell">Estimated Weight</div>
      </div>
      <div class="row">
        <div class="cell" data-title="Client Name">{{ $client->client_name }}</div>
        <div class="cell" data-title="Shop Name">{{ $client->shop_name }}</div>
        <div class="cell" data-title="Invoice Date">{{ $indInvoice->invoice_date }}</div>
        <div class="cell" data-title="Delivery Date">{{ $indInvoice->delivery_date }}</div>
        <div class="cell" data-title="Estimated Weight">{{ number_format($tt) }}kg</div>
      </div>
    </div>
  </section>
  @if($indInvoice->loaded == 0)
  <section id="complete">
    <form method="POST" action="" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="search-box">
        <div class="block-item">
          <input type="number" name="net_weight" id="net_weight" class="form-control input-lg add-item" placeholder="Net Weight" autocomplete="off"/>
        </div>
        <div class="block-item">
          <input type="text" name="vehicle_reg" id="vehicle_reg" class="form-control input-lg add-item" placeholder="Vehicle #" autocomplete="off"/>
        </div>
        <div class="block-item">
          <input type="phone" name="phone_number" id="phone_number" class="form-control input-lg add-item" placeholder="Driver Phone #" autocomplete="off"/>
        </div>
        <div class="block-item">
          <button type="submit" name="submit" id="submit" class="form-control input-lg add-item">SEND SMS</button>
        </div>
      </div>
    </form>
  </section>
  @endif
  <section id="gp-info">
    <div class="table2">
      <div class="row header">
        <div class="cell">Vehicle Reg</div>
        <div class="cell">Net Weight</div>
        <div class="cell">Driver No</div>
        <div class="cell">DT</div>
        @if($indInvoice->loaded == 0)
        <div class="cell"></div>
        @endif
      </div>
      @foreach($gp as $g)
      <div class="row">
        <div class="cell" data-title="Vehicle Reg">{{ $g->vehicle_reg }}</div>
        <div class="cell" data-title="Net Weight">{{ $g->net_weight }}kg</div>
        <div class="cell" data-title="Driver #">{{ $g->phone }}</div>
        <div class="cell" data-title="Driver #">{{ $g->created_at }}</div>
        @if($indInvoice->loaded == 0)
        <div class="cell" data-title="Driver #"><a href="/gatepass/del/{{ $g->id }}" type="submit" class="btn final-sub dark-but" name="del-entry">x</a></div>
        @endif
      </div>
      @endforeach
    </div>
    <div>
      @if($indInvoice->loaded == 0)
        <a href="/gatepass/togComplete/{{ $indInvoice->id }}" type="submit" class="btn final-sub" name="reset-form">Complete</a>
      @else
        @if(Auth::user()->role == "Admin")
          <a href="/gatepass/togComplete/{{ $indInvoice->id }}" type="submit" class="btn final-sub dark-but" name="reset-form">Reset</a>
        @endif
      @endif
    </div>
  </section>
</div>
@endsection
