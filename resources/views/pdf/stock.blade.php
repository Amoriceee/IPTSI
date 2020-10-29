<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style>
* {
  font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  font-size: 12px;
}

#logo {
  width:300px;
  position: absolute;
  left: 180px;
}
.stock-table {
  width: 60%;
  margin: 0 auto;
  text-align: center;
  border-collapse: collapse;
  background-color: white;
  overflow: hidden;
  border-radius: 3px;
}
.page-break {
  page-break-after: always;
}
.page-b {
  page-break-before: always;
}
.stock-table th, .stock-table td {
  padding: 10px;
}
.stock-table th {
  background-color: #7691ab;
  color: white;
}
.stock-table td {
  border-bottom: 1px solid #7691ab;
}
.final {
  font-weight: bolder;
}
div.head {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    /** Extra personal styles **/
    color: white;
    text-align: center;
    line-height: 35px;
}
</style>
<body>
@if($stock16 != [])
<div id="page1" class="page-break">
  <div class="head">
    <img id="logo" src="img/board.png" alt="" />
  </div>
  <div style="position:absolute; top: 200px">
    <table class="stock-table">
      <tr>
        <th>SWG 16</th>
        <th>Quantity</th>
      </tr>
      @foreach($stock16 as $s16)
      <tr>
        <td class="cell" data-title="">{{ $s16->pipe_description }}</td>
        <td class="cell" data-title="">{{ number_format($s16->diff) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif
@if($stock18 != [])
<div id="page2" class="page-break">
  <div class="head">
    <img id="logo" src="img/board.png" alt="" />
  </div>
  <div style="position:absolute; top: 200px">
    <table class="stock-table">
      <tr>
        <th>SWG 18</th>
        <th>Quantity</th>
      </tr>
      @foreach($stock18 as $s18)
      <tr>
        <td class="cell" data-title="">{{ $s18->pipe_description }}</td>
        <td class="cell" data-title="">{{ number_format($s18->diff) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif
@if($stock19 != [])
<div id="page3" class="page-break">
  <div class="head">
    <img id="logo" src="img/board.png" alt="" />
  </div>
  <div style="position:absolute; top: 200px">
    <table class="stock-table">
      <tr>
        <th>SWG 19</th>
        <th>Quantity</th>
      </tr>
      @foreach($stock19 as $s19)
      <tr>
        <td class="cell" data-title="">{{ $s19->pipe_description }}</td>
        <td class="cell" data-title="">{{ number_format($s19->diff) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif
@if($stock20 != [])
<div id="page4" class="page-break">
  <div class="head">
    <img id="logo" src="img/board.png" alt="" />
  </div>
  <div style="position:absolute; top: 200px">
    <table class="stock-table">
      <tr>
        <th>SWG 20</th>
        <th>Quantity</th>
      </tr>
      @foreach($stock20 as $s20)
      <tr>
        <td class="cell" data-title="">{{ $s20->pipe_description }}</td>
        <td class="cell" data-title="">{{ number_format($s20->diff) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif
@if($stock21 != [])
<div id="page5" class="page-break">
  <div class="head">
    <img id="logo" src="img/board.png" alt="" />
  </div>
  <div style="position:absolute; top: 200px">
    <table class="stock-table">
      <tr>
        <th>SWG 21</th>
        <th>Quantity</th>
      </tr>
      @foreach($stock21 as $s21)
      <tr>
        <td class="cell" data-title="">{{ $s21->pipe_description }}</td>
        <td class="cell" data-title="">{{ number_format($s21->diff) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif
@if($stock22 != [])
<div id="page6" class="page-break">
  <div class="head">
    <img id="logo" src="img/board.png" alt="" />
  </div>
  <div style="position:absolute; top: 200px">
    <table class="stock-table">
      <tr>
        <th>SWG 22</th>
        <th>Quantity</th>
      </tr>
      @foreach($stock22 as $s22)
      <tr>
        <td class="cell" data-title="">{{ $s22->pipe_description }}</td>
        <td class="cell" data-title="">{{ number_format($s22->diff) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif
@if($stock23 != [])
<div id="page7">
  <div class="head">
    <img id="logo" src="img/board.png" alt="" />
  </div>
  <div style="position:absolute; top: 200px">
    <table class="stock-table">
      <tr>
        <th>SWG 23</th>
        <th>Quantity</th>
      </tr>
      @foreach($stock23 as $s23)
      <tr>
        <td class="cell" data-title="">{{ $s23->pipe_description }}</td>
        <td class="cell" data-title="">{{ number_format($s23->diff) }}</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>
@endif
</body>

</html>
