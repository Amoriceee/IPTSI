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

function addRow(n) {

  var qtyID = 'id="pipe_qty' + n + '"';
  var descID = 'id="pipe_description' + n + '"';
  var swgID = 'id="pipe_qty'+ n + '"';
  var rateID = 'id="pipe_rate' + n + '"';

  var nr = '<div class="block-item-nm">'+
  '<input type="text" name="pipe_qty[]" class="form-control input-lg add-item" ' + qtyID + ' placeholder="Qty" autocomplete="off"/>'+
  '<div>'+
  '<input type="text" name="pipe_description[]" class="form-control input-lg add-item pipe_description" ' + descID + ' placeholder="Pipe Name" autocomplete="off"/>'+
  '<div id="pdList' + n + '" class="pdList"></div>'+
  '</div>'+
  '<select class="add-item" name="pipe_swg[]" ' + swgID + '>'+
  '<option selected="true" disabled="disabled">SWG</option>'+
  '<option value="18">18</option>'+
  '<option value="19">19</option>'+
  '<option value="20">20</option>'+
  '<option value="21">21</option>'+
  '<option value="22">22</option>'+
  '<option value="23">23</option>'+
  '</select>'+
  '<input type="number" maxlength="2" name="pipe_rate[]" class="form-control input-lg add-item" ' + rateID +' placeholder="%" autocomplete="off"/>'+
  '<div class="ppl">1200</div>'+
  '<div class="linetotal">98000</div>'+
  '<div>'+
  '<button class="btn btn-danger deleteRow">x</button>'+
  '</div>';
  $('form').append(nr);

}
