@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/home.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome {{ Auth::user()->name }}!</div>
                <div class="card-body">
                  <a href="stock" class="menu-button">
                    <img class="pp" src="img/stock.png" alt="stock">
                    <h2>STOCK</h2>
                  </a>
                  @if(Auth::user()->role == "Admin" || Auth::user()->role == "Sales")
                  <a href="invoices" class="menu-button">
                    <img class="pp" src="img/check-mark.svg" alt="check-mark">
                    <h2>INVOICES</h2>
                  </a>
                  @endif
                  @if(Auth::user()->role == "Admin" || Auth::user()->role == "Production")
                  <a href="production" class="menu-button">
                    <img class="pp" src="img/tubes.svg" alt="tubes">
                    <h2>PRODUCTION</h2>
                  </a>
                  @endif
                  @if(Auth::user()->role == "Admin" || Auth::user()->role == "Gate")
                  <a href="gatepass" class="menu-button">
                    <img class="pp" src="img/new_gate.svg" alt="gatepass">
                    <h2>GATE PASS</h2>
                  </a>
                  @endif
                  @if(Auth::user()->role == "Admin")
                  <a href="ledgers" class="menu-button">
                    <img class="pp" src="img/invoice.svg" alt="tubes">
                    <h2>LEDGERS</h2>
                  </a>
                  <a href="reports" class="menu-button">
                    <img class="pp" src="img/reports.svg" alt="reports">
                    <h2>REPORTS</h2>
                  </a>
                  @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
