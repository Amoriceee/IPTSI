<?php

namespace App\Http\Controllers;

use App\Pipe;
use App\PipeProduction;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Input;

class PipeController extends Controller
{
  public function sort(Request $request) {

    if ($request->has('search_submit')) {

      if ($request->has('search_date')) {
        $date = Carbon::parse($request->search_date);
      } else {
        $date = Carbon::today();
      }
      //Todays Production
      $production = PipeProduction::whereDate('production_date', $date)->get();
      //Monthly Production
      $monthly_production = PipeProduction::whereBetween('production_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();

      return view('production', ['production' => $production, 'monthly_production' => $monthly_production, 'date' => $date]);

    } else {
      $request->validate([
       'production_date' => 'required|date',
       'pipe_description' => 'required|string',
       'pipe_swg' => 'required|min:2',
       'pipe_qty' => 'required|min:1',
     ]);

     $newProduction = new PipeProduction();

     $pd_swg = $request->input('pipe_swg');
     $pd_des = $request->input('pipe_description');

     $newProduction->pipe_id = DB::table('pipes')->where('pipe_description', $pd_des)->where('swg', $pd_swg)->pluck('id')->first();
     $newProduction->quantity = $request->input('pipe_qty');
     $newProduction->production_date = $request->input('production_date');
     $newProduction->user_id = \Auth::user()->id;
     $newProduction->save();

     return redirect()->back();
    }

  }

  public function index(Request $request)
  {
    if ($request->has('search_date')) {
      $date = Carbon::parse($request->search_date);
    } else {
      $date = Carbon::today();
    }
    //Todays Production
    $production = PipeProduction::whereDate('production_date', $date)->get();
    //Monthly Production
    $monthly_production = PipeProduction::whereBetween('production_date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->get();
    return view('production', ['production' => $production, 'monthly_production' => $monthly_production, 'date' => $date]);
  }

   function addProduction(Request $request) {

     $request->validate([
      'production_date' => 'required|date',
      'pipe_description' => 'required|string',
      'pipe_swg' => 'required|min:2',
      'pipe_qty' => 'required|min:1',
    ]);

    $newProduction = new PipeProduction();

    $pd_swg = $request->input('pipe_swg');
    $pd_des = $request->input('pipe_description');

    $newProduction->pipe_id = DB::table('pipes')->where('pipe_description', $pd_des)->where('swg', $pd_swg)->pluck('id')->first();
    $newProduction->quantity = $request->input('pipe_qty');
    $newProduction->production_date = $request->input('production_date');
    $newProduction->user_id = \Auth::user()->id;
    $newProduction->save();

    return redirect()->back();

   }

   function delProduction($id) {

    DB::delete('delete from pipe_productions where id = ?',[$id]);

    return redirect()->back();

   }

   function fetch(Request $request)
   {
     if($request->get('query'))
     {
       $query = $request->get('query');
       $data = Pipe::where('pipe_description', 'LIKE', "%{$query}%")->where('swg', '=', 16)->get();

       $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
       foreach($data as $row)
       {
         $output .= '
         <li><a href="#">'.$row->pipe_description.'</a></li>
         ';
       }
       $output .= '</ul>';
       echo $output;
     }
   }


}
