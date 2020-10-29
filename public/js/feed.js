let n = 0;

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

  var _token = $('meta[name="_token"]').attr('content');

  $(pd_input).keyup(function(){
    let query = $(this).val();
    console.log(query);
    if(query != '')
    {
      var _token = $('input[name="_token"]').val();
      $.ajax({
        url:"{{ route('invoice.fetch') }}",
        method:"POST",
        contentType: "application/json; charset=utf-8",
        data:{query:query, _token:_token},
        success:function(data){
          $(pd_list).fadeIn();
          $(pd_list).html(data);
        }
      });
    }
  });

  append(pd_div, pd_input);
  append(pd_div, pd_list);
  //$(pd_div).append("<input name='_token' value='" + _token + "' type='hidden'>");

  //Select
  let swg_select = createNode('select');
  let option_def = createNode('option');
  option_def.innerHTML = 'SWG';
  option_def.selected = 'true';
  option_def.disabled = 'disabled';
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

function createFunction(n) {
  $(document).ready(function(){
    let pd = '#pipe_description' + n;
    let pl = '#pdList' + n;
    console.log(pd);
    console.log(pl);
    $(pd).keyup(function(){
      let query = $(this).val();
      console.log(query);
      if(query != '')
      {
        var _token = $('input[name="_token"]').val();
        $.ajax({
          url:"{{ route('invoice.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
            $(pl).fadeIn();
            $(pl).html(data);
          }
        });
      }
    });
  });
}


function createNode(element) {
  return document.createElement(element);
}

function append(parent, elm) {
  return parent.appendChild(elm);
}
