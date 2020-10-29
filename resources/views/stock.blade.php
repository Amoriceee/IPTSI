@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
<link href="{{ asset('css/table-style.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
  <a class="" href="/stock/pdf">PDF</a>
    <div class="mt">
      <div class="table2">
        <div class="row header">
          <div class="cell"></div>
          <div class="cell"></div>
          <div class="cell">Stock</div>
        </div>
        @foreach($fStocks as $fStock)
        <div class="row">
          <div class="cell" data-title="">{{ $fStock->pipe_description }}</div>
          <div class="cell" data-title="">{{ $fStock->swg }}</div>
          <div class="cell" data-title="">{{ number_format($fStock->diff) }}</div>
        </div>
        @endforeach
      </div>
    </div>
</div>
@endsection
