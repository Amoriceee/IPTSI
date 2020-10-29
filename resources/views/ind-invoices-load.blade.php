@extends('layouts.app')

@section('styling')
<link href="{{ asset('css/all.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link href="{{ asset('css/ind-invoices.css') }}" rel="stylesheet">
<script src="{{ asset('js/feed.js' ) }}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div>
  <section id="new-invoice-client">
    <form id="new-invoice" method="POST" action="" enctype="multipart/form-data">
      {{ csrf_field() }}
      <div class="block-item">
        @if($indInvoice->authorised == 0)
        <a class="btn final-sub auth-but dark">UNAUTHORISED</a>
          @if(Auth::user()->role == "Admin")
            <a href="/invoices/togauth/{{ $indInvoice->id }}" type="submit" class="ml10" name="auth-form"><i class="fas fa-sync-alt dark"></i></a>
          @endif
        @else
        <a class="btn final-sub auth-but light">AUTHORISED</a>
          @if(Auth::user()->role == "Admin")
            <a href="/invoices/togauth/{{ $indInvoice->id }}" type="submit" class="ml10" name="auth-form"><i class="fas fa-sync-alt light"></i></a>
          @endif
        @endif
      </div>
      <div class="select-box">
        <select id="client_list" class="select-client" name="client_id" disabled>
          <option selected="selected" value="{{ $client->id }}">{{ $client->client_name }}</option>
        </select>
      </div>
      <div class="block-item">
        <h3>INVOICE:</h3>
        <input type="date" name="invoice_date" id="invoice_date" class="form-control input-lg date-item" value="{{ $indInvoice->invoice_date }}" disabled/>
      </div>
      <div id="due_block" class="block-item">
        <h3>DELIVERY:</h3>
        <input type="date" name="delivery_date" id="delivery_date" class="form-control input-lg date-item" value="{{ $indInvoice->delivery_date }}"/>
      </div>
      @foreach($invoicePipe as $ip)
      <div class="block-item-nm" id="append-block">
        <input type="text" name="pipe_qty[]" id="pipe_qty" class="form-control input-lg add-item" placeholder="Qty" autocomplete="off" value="{{ $ip->quantity }}"/>
        <div>
          <input type="text" name="pipe_description[]" id="pipe_description" class="form-control input-lg add-item pipe_description" placeholder="Pipe Name" autocomplete="off" value="{{ $ip->pipes->pipe_description }}"/>
          <div id="pdList" class="pdList"></div>
        </div>
        <select class="add-item" name="pipe_swg[]" id="pipe_swg">
          <option disabled="disabled">SWG</option>
          <option value="16" {{$ip->pipes->swg == 16  ? 'selected' : ''}}>16</option>
          <option value="18" {{$ip->pipes->swg == 18  ? 'selected' : ''}}>18</option>
          <option value="19" {{$ip->pipes->swg == 19  ? 'selected' : ''}}>19</option>
          <option value="20" {{$ip->pipes->swg == 20  ? 'selected' : ''}}>20</option>
          <option value="21" {{$ip->pipes->swg == 21  ? 'selected' : ''}}>21</option>
          <option value="22" {{$ip->pipes->swg == 22  ? 'selected' : ''}}>22</option>
          <option value="23" {{$ip->pipes->swg == 23  ? 'selected' : ''}}>23</option>
        </select>
        <input type="number" maxlength="2" name="pipe_rate[]" id="pipe_rate" class="form-control input-lg add-item" placeholder="%" autocomplete="off" value="{{ $ip->rate }}"/>
        <div class="ppl">{{ number_format(round($ip->pipes->base_price * (($ip->rate + 100) / 100) * 20 * $ip->quantity, 0)) }}</div>
        <div class="linetotal">{{ number_format(round($ip->pipes->min_weight * $ip->quantity, 0)) }}</div>
        <div>
          <button class="btn btn-danger deleteRow">x</button>
        </div>
      </div>
      @endforeach
    </form>
    <div>
      <button type="button" id="addRow" class="btn btn-info addRow">+</button>
    </div>
    <div>
      @if($errors->any())
          {!! implode('', $errors->all('<div>:message</div>')) !!}
      @endif
    </div>
    <div class="sub-totals">
      <table>
        <tr>
          <th>
            Sub Total:
          </th>
          <th id="st">
            0
          </th>
        </tr>
        <tr>
          <th>
            Loading Charges:
          </th>
          <th id="lc">
            0
          </th>
        </tr>
        <tr>
          <th>
            Grand Total:
          </th>
          <th id="gt">
            0
          </th>
        </tr>
      </table>
    </div>
    <div>
      <input type="submit" class="btn final-sub" form="new-invoice" name="save-form" value="SAVE">
      <a href="/invoices/pdf/{{ $indInvoice->id }}" type="submit" class="btn final-sub" name="pdf-form">PDF</a>
      <a href="/invoices/del/{{ $indInvoice->id }}" type="submit" class="btn final-sub dark-but" name="reset-form">RESET</a>
      @if(Auth::user()->role == "Admin")
      <a href="/invoices/destroy/{{ $indInvoice->id }}" type="submit" class="btn final-sub dark-but" name="delete-form">DELETE</a>
      @endif
    </div>
  </section>
</div>
<script type="text/javascript">

$(document).ready(function(){
  $("input#invoice_date[type='date']").keydown(function (event) { event.preventDefault(); });
  let n = 0;

  $('#addRow').on('click', function(event){
    event.preventDefault();
    addNewRow();
    n++;
  });

  $('form').on('click', '.deleteRow', function(){
    $(this).parent().parent().remove();
  });

  function addNewRow(){

    //MAIN body
    let form = document.getElementById('new-invoice');
    let mbody = createNode('div');
    mbody.classList.add('block-item-nm');

    //QTY
    let qty_input = createNode('input');
    qty_input.type = 'number';
    qty_input.name = 'pipe_qty[]'
    qty_input.id = 'pipe_qty' + n;
    qty_input.classList.add('form-control');
    qty_input.classList.add('input-lg');
    qty_input.classList.add('add-item');
    qty_input.placeholder = 'Qty';
    qty_input.autocomplete = 'off';

    //PIPE Description
    let pd_div = createNode('div');
    let pd_input = createNode('input');
    let pd_list = createNode('div');
    pd_input.type = 'text';
    pd_input.name = 'pipe_description[]'
    pd_input.id = 'pipe_description' + n;
    pd_input.classList.add('form-control');
    pd_input.classList.add('input-lg');
    pd_input.classList.add('add-item');
    pd_input.classList.add('pipe_description');
    pd_input.placeholder = 'Pipe Name';
    pd_input.autocomplete = 'off';

    pd_list.classList.add('pdList');
    pd_list.id = 'pdList' + n;


    $(pd_input).keyup(function(){
      let query = $(this).val();
      if(query != '')
      {
        var _token = $('meta[name="_token"]').attr('content');
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
        $.ajax({
          url:"{{ route('invoice.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $(pd_list).fadeIn();
            $(pd_list).html(data);
          }
        });
      }
    });

    $(pd_list).on('click', 'li', function(event){
      event.preventDefault();
      $(pd_input).val($(this).text());
      $(pd_list).fadeOut();
    });

    append(pd_div, pd_input);
    append(pd_div, pd_list);

    //Select
    let swg_select = createNode('select');
    swg_select.name = 'pipe_swg[]'
    swg_select.classList.add('add-item');
    let option_def = createNode('option');
    option_def.innerHTML = 'SWG';
    option_def.selected = 'true';
    option_def.disabled = 'disabled';
    let option_16 = createNode('option');
    option_16.value = '16';
    option_16.innerHTML = '16';
    let option_18 = createNode('option');
    option_18.value = '18';
    option_18.innerHTML = '18';
    let option_19 = createNode('option');
    option_19.value = '19';
    option_19.innerHTML = '19';
    let option_20 = createNode('option');
    option_20.value = '20';
    option_20.innerHTML = '20';
    let option_21 = createNode('option');
    option_21.value = '21';
    option_21.innerHTML = '21';
    let option_22 = createNode('option');
    option_22.value = '22';
    option_22.innerHTML = '22';
    let option_23 = createNode('option');
    option_23.value = '23';
    option_23.innerHTML = '23';
    append(swg_select, option_def);
    append(swg_select, option_16);
    append(swg_select, option_18);
    append(swg_select, option_19);
    append(swg_select, option_20);
    append(swg_select, option_21);
    append(swg_select, option_22);
    append(swg_select, option_23);

    //RATE
    let rate_input = createNode('input');
    rate_input.type = 'number';
    rate_input.name = 'pipe_rate[]'
    rate_input.classList.add('form-control');
    rate_input.classList.add('input-lg');
    rate_input.classList.add('add-item');
    rate_input.placeholder = '%';
    rate_input.autocomplete = 'off';

    //delete
    let del_div = createNode('div');
    let del_but = createNode('button');
    del_but.classList.add('btn');
    del_but.classList.add('btn-danger');
    del_but.classList.add('deleteRow');
    del_but.innerHTML = 'x';
    append(del_div, del_but);

    append(mbody, qty_input);
    append(mbody, pd_div);
    append(mbody, swg_select);
    append(mbody, rate_input);
    append(mbody, del_div);

    append(form, mbody);
    n++;
  }

  let sub_total = 0;
  let loading_charges = 0;

  @foreach($invoicePipe as $ip)
  sub_total = sub_total + {{ round($ip->pipes->base_price * (($ip->rate + 100) / 100) * 20 * $ip->quantity, 0) }}
  loading_charges = loading_charges + {{ round($ip->pipes->min_weight * $ip->quantity * 0.25, 0) }}
  @endforeach

  let grand_total = sub_total + loading_charges;
  document.getElementById('st').innerHTML = new Intl.NumberFormat().format(sub_total);
  document.getElementById('lc').innerHTML = new Intl.NumberFormat().format(loading_charges);
  document.getElementById('gt').innerHTML = new Intl.NumberFormat().format(grand_total);
});
</script>
@endsection
