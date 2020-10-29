@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/production.css') }}" rel="stylesheet">
<link href="{{ asset('css/table-style.css') }}" rel="stylesheet">
<link href="{{ asset('css/all.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@endsection

@section('content')
<div class="container">
  <section id="production-new">
    <form method="POST" action="" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="search-box">
        <div class="block-item">
          <div class="inline-item">
            <input type="date" name="production_date" id="production_date" class="form-control input-lg add-item" value="<?php echo date("Y-m-d");?>"/>
          </div>
        </div>
        <div class="block-item">
          <input type="text" name="pipe_description" id="pipe_description" class="form-control input-lg add-item" placeholder="Pipe Name" autocomplete="off"/>
          <div id="pdList">
          </div>
          {{ csrf_field() }}
        </div>
        <div class="block-item">
          <div class="inline-item">
            <select class="add-item" name="pipe_swg" id="pipe_swg">
              <option selected="true" disabled="disabled">SWG</option>
              <option value="16">16</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
            </select>
            <input type="text" name="pipe_qty" id="pipe_qty" class="form-control input-lg add-item" placeholder="Qty" autocomplete="off"/>
          </div>
        </div>
        <div class="block-item">
          <div class="inline-item">
            <button type="submit" name="add_submit" id="add_sumbit" class="form-control input-lg add-item">ADD PRODUCTION</button>
          </div>
        </div>
      </div>
    </form>
  </section>
  <section id="production-results">
    <div class="production-results">
      <div class="search">
        <form class="search-date-form" method="POST" action="" enctype="multipart/form-data">
          {{ csrf_field() }}
          <input type="date" name="search_date" id="search_date" class="form-control input-lg search-item" value="{{ $date->format('Y-m-d') }}"/>
          <button type="submit" name="search_submit" id="search_sumbit" class="form-control input-lg search-submit"><i class="fas fa-search"></i></button>
        </form>
      </div>
      <div class="results_view">
        <div class="table">
          <div class="row header">
            <div class="cell">Quantity</div>
            <div class="cell">Description</div>
            <div class="cell">SWG</div>
            <div class="cell">Production Date</div>
            <div class="cell">Submitted By</div>
            <div class="cell"></div>
          </div>
          @foreach($production as $pro)
          <div class="row">
            <div class="cell" data-title="qty">{{ $pro->quantity }}</div>
            <div class="cell" data-title="id">{{ $pro->pipes->pipe_description }} </div>
            <div class="cell" data-title="id">{{ $pro->pipes->swg }} </div>
            <div class="cell" data-title="pd">{{ $pro->production_date }}</div>
            <div class="cell" data-title="en">{{ $pro->user->name }} {{ $pro->created_at }}</div>
            <div class="cell" data-title="del"><a href="/production/del/{{ $pro->id }}" onclick="return confirm('Are you sure?')">x</a></div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
  <section id="production-results">
    <div class="production-results">
      <div class="search">
        <h2>{{ $date->format('M') }} Production</h2>
      </div>
      <div class="results_view">
        <div class="table">
          <div class="row header">
            <div class="cell">Quantity</div>
            <div class="cell">Description</div>
            <div class="cell">SWG</div>
            <div class="cell">Production Date</div>
            <div class="cell">Submitted By</div>
          </div>
          @foreach($monthly_production as $pro)
          <div class="row">
            <div class="cell" data-title="qty">{{ $pro->quantity }}</div>
            <div class="cell" data-title="id">{{ $pro->pipes->pipe_description }} </div>
            <div class="cell" data-title="id">{{ $pro->pipes->swg }} </div>
            <div class="cell" data-title="pd">{{ $pro->production_date }}</div>
            <div class="cell" data-title="en">{{ $pro->user->name }} {{ $pro->created_at }}</div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </section>
</div>

<script>
$(document).ready(function(){

  $('#pipe_description').keyup(function(){
    var query = $(this).val();
    if(query != '')
    {
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:"{{ route('production.fetch') }}",
        method:"POST",
        data:{query:query, _token:_token},
        success:function(data){
          $('#pdList').fadeIn();
          $('#pdList').html(data);
        }
      });
    }
  });

  $(document).on('click', 'li', function(){
    $('#pipe_description').val($(this).text());
    $('#pdList').fadeOut();
  });

});
</script>
@endsection
