@extends('layouts.app')

@section('styling')
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
      <div class="select-box">
        <select id="client_list" class="select-client" name="client_id">
          <option selected="selected" disabled="disabled">Select A Client</option>
          @foreach($clientList as $client)
          <option value="{{ $client->id }}" <?php if(isset($_POST['client_id']) && $_POST['client_id'] == $client->id) echo 'selected="selected"';?>>{{ $client->client_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="block-item">
        <h3>INVOICE:</h3>
        <input type="date" name="invoice_date" id="invoice_date" class="form-control input-lg date-item" value="<?php echo date("Y-m-d");?>"/>
      </div>
      <div id="due_block" class="block-item">
        <h3>DELIVERY:</h3>
        <input type="date" name="delivery_date" id="delivery_date" class="form-control input-lg date-item" value="<?php echo date("Y-m-d");?>"/>
      </div>
    </form>
    <div>
      <button type="button" id="addRow" class="btn btn-info addRow">+</button>
    </div>
    <div>
      @if($errors->any())
          {!! implode('', $errors->all('<div>:message</div>')) !!}
      @endif
    </div>
    <div>
      <input type="submit" class="btn final-sub" form="new-invoice" name="save-form" value="SAVE">
    </div>
  </section>
</div>
<script type="text/javascript">
$(document).ready(function(){

  let n = 0;
  addNewRow();

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
    mbody.classList.add('block-item-nm-create');

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
    //$(pd_div).append("<input name='_token' value='" + _token + "' type='hidden'>");

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

});
</script>
@endsection
