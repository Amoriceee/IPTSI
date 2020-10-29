<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\PipeInvoice;
use App\Clients;
use App\Pipe;
use DB;
use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
  * Show the application dashboard.
  *
  * @return \Illuminate\Contracts\Support\Renderable
  */
  public function index()
  {
    return view('home');
  }

  public function stockIndex(){


    $fStocks = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0
    ORDER BY swg asc, pipe_description desc
    "));

    return view('stock', ['fStocks' => $fStocks]);

  }

  public function stockPDF(){

    $stock16 = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0 AND swg = 16
    ORDER BY swg asc, pipe_description desc
    "));

    $stock18 = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0 AND swg = 18
    ORDER BY swg asc, pipe_description desc
    "));

    $stock19 = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0 AND swg = 19
    ORDER BY swg asc, pipe_description desc
    "));

    $stock20 = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0 AND swg = 20
    ORDER BY swg asc, pipe_description desc
    "));

    $stock21 = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0 AND swg = 21
    ORDER BY swg asc, pipe_description desc
    "));

    $stock22 = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0 AND swg = 22
    ORDER BY swg asc, pipe_description desc
    "));

    $stock23 = DB::select(DB::raw("
    SELECT *, coalesce(a.quantity, 0)-coalesce(b.quantity, 0) as diff
    FROM
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_productions
    GROUP BY pipe_id) a
    LEFT JOIN
    (SELECT pipe_id, sum(quantity) as quantity
    FROM pipe_invoices
    GROUP BY pipe_id) b
    on a.pipe_id = b.pipe_id
    LEFT JOIN pipes
    on a.pipe_id = pipes.id
    WHERE coalesce(a.quantity, 0)-coalesce(b.quantity, 0) != 0 AND swg = 23
    ORDER BY swg asc, pipe_description desc
    "));


     $pdf = PDF::loadView('pdf.stock', compact('stock16', 'stock18', 'stock19', 'stock20','stock21', 'stock22', 'stock23'));
     return $pdf->stream();

  }

}
