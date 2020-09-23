@inject('dashboardCont', 'App\Http\Controllers\DashboardController')
@extends('layouts.sidebar')
@php
$inventoryNames = array();
$inventoryDisplayNames = array();
$inventoryQuantities = array();
$inventoryCapacities = array();
$inventoryThresholds = array();
$inventoryIDs = array();

for ($i = 0; $i < count($activeItems); ++$i) {
    $inventoryNames[] = str_replace(' ', '*', $activeItems[$i]->name);
    $inventoryDisplayNames[] = $activeItems[$i]->name;
    $inventoryQuantities[] = $activeItems[$i]->quantity;
    $inventoryCapacities[] = $activeItems[$i]->capacity;
    $inventoryThresholds[] = $activeItems[$i]->low_threshold;
    $inventoryDates[] = $activeItems[$i]->updated_at;
    $inventoryIDs[] = $activeItems[$i]->id;
}

$transactionChanges = array();
$transactionDates = array();
$transactionIDs = array();
$transactionComments = array();
$transactionUsers = array();
$recentChanges = array();

for ($i = 0; $i < count($activeTransactions); ++$i) {
  $transactionChanges[] = $activeTransactions[$i]->item_quantity_change;
  $transactionDates[] = $activeTransactions[$i]->transaction_date;
  $transactionIDs[] = $activeTransactions[$i]->item_id;
  $transactionComments[] = $activeTransactions[$i]->comment;
  $transactionUserIDs[] = $activeTransactions[$i]->member_id;
}
for ($i = count($activeTransactions); $i > count($activeTransactions)-3; --$i) {
  if ($i > 0) {
    $recentChanges[] = $activeTransactions[$i-1];
  }
}

$transactionNames = array();
for ($i = 0; $i < count($transactionIDs); ++$i) {
  if (in_array($transactionIDs[$i], $inventoryIDs)) {
    $transactionNames[] = $inventoryDisplayNames[array_search($transactionIDs[$i], $inventoryIDs)];
  }
}

$userNames = array();
$userIDs = array();
for ($i = 0; $i < count($activeUsers); ++$i) {
  $userNames[] = $activeUsers[$i]->name;
  $userIDs[] = $activeUsers[$i]->id;
}

$transactionUserNames = array();
for ($i = 0; $i < count($transactionUserIDs); ++$i) {
  if (in_array($transactionUserIDs[$i], $userIDs)) {
    $transactionUserNames[] = $userNames[array_search($transactionUserIDs[$i], $userIDs)];
  }
}

$sortedNames = $inventoryNames;
usort($sortedNames, 'strnatcasecmp');
$sortedDisplayNames = $inventoryDisplayNames;
usort($sortedDisplayNames, 'strnatcasecmp');
@endphp

@section('content')
    <head>
      <style>
        .table-scroll {
          height: 450px;
          overflow-y: auto;
        }
        table th{
          padding-right: 20px;
          border: 1px solid black;
          background-color: #e0e0e0;
        }
        table td{
          border: 1px solid black;
          padding-right: 8px;
        }
        table tr:nth-child(even){
          background-color: #e0e0e0;
        }
      </style>
    </head>

    <script>
      function getUrlVars() {
        var vars = {};
        var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
            vars[key] = value;
        });
        return vars;
      }

      function sortTable() {
        var sortOrder = getUrlVars();
        var table = document.getElementById("transTable");

        /*For sorting by date and alphabetically, no longer needed but I've left them in the code just in case
        if (sortOrder.sort == 'date'){
          while (switching){
            var rows = table.rows;
            var date1 = Date.parse(rows[i].cells[0].innerHTML);
            var date2 = Date.parse(rows[i+1].cells[0].innerHTML);
            if (sortOrder.order == 'dec' && date1 < date2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 0;
            }
            else if (sortOrder.order == 'inc' && date1 > date2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 0;
            }
            if (i == rows.length - 1){
              switching = false;
              i = 0;
            }
            i++;
          }
        }
        else if (sortOrder.sort == 'alph'){
          i = 1;
          while (switching){
            var rows = table.rows;
            var item1 = rows[i].cells[1].innerHTML;
            var item2 = rows[i+1].cells[1].innerHTML;
            if (sortOrder.order == 'dec' && item1 < item2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 1;
            }
            else if (sortOrder.order == 'inc' && item1 > item2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 1;
            }
            if (i == rows.length - 1){
              switching = false;
              i = 1;
            }
            i++;
          }
        }
        */
        //For filtering by item name
        var sort = sortOrder.sort.replace("*", " ");
        if (sort != "" && sort != 'all') {
          for (var i = 1; i < table.rows.length; i++){
            if (sort != table.rows[i].cells[1].innerHTML){
              table.deleteRow(i);
              i--;
            }
          }
        }

        //For chronological sorting


        /*
        var switching = true;
        var i = 1;
        if (sortOrder.order == 'dec' || sortOrder.order == 'inc'){
          while (switching){
            if (i == rows.length - 1){
              switching = false;
              i = 1;
            }
            var rows = table.rows;
            var date1 = Date.parse(rows[i].cells[0].innerHTML);
            var date2 = Date.parse(rows[i+1].cells[0].innerHTML);
            if (sortOrder.order == 'dec' && date1 < date2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 1;
            }
            else if (sortOrder.order == 'inc' && date1 > date2){
              rows[i].parentNode.insertBefore(rows[i+1], rows[i]);
              i = 1;
            }
            i++;
          }
        }
        */
        var switching = true;
        var i = 0;
        if (sortOrder.order == 'dec'){
          while (i < table.rows.length - 1){
            var date1 = Date.parse(table.rows[i].cells[0].innerHTML);
            var date2 = Date.parse(table.rows[i+1].cells[0].innerHTML);
            if (date1 < date2){
              table.rows[i].parentNode.insertBefore(table.rows[i+1], table.rows[i]);
              i = 0;
            }
            i++;
          }
          table.rows[0].cells[0].innerHTML = 200;
        }
        else if (sortOrder.order == 'inc'){
          while (i < table.rows.length - 1){
            var date1 = Date.parse(table.rows[i].cells[0].innerHTML);
            var date2 = Date.parse(table.rows[i+1].cells[0].innerHTML);
            if (date1 > date2){
              table.rows[i].parentNode.insertBefore(table.rows[i+1], table.rows[i]);
              i = 0;
            }
            i++;
          }
          table.rows[0].cells[0].innerHTML = 300;
        }


        //Filter by add or removing quantities
        if (sortOrder.addrmv == 'add'){
          for (var i = 1; i < table.rows.length; i++){
            var change = parseInt(table.rows[i].cells[2].innerHTML);
            if (change < 0){
              table.deleteRow(i);
              i--;
            }
          }
        }
        else if (sortOrder.addrmv == 'rmv'){
          for (var i = 1; i < table.rows.length; i++){
            var change = parseInt(table.rows[i].cells[2].innerHTML);
            if (change > 0){
              table.deleteRow(i);
              i--;
            }
          }
        }

        //Filter by calendar date range
        if (sortOrder.start != '' || sortOrder.end != ''){
          var startDate = Date.parse(sortOrder.start);
          var endDate = Date.parse(sortOrder.end);
          for (var i = 1; i < table.rows.length; i++){
            var transDate = Date.parse(table.rows[i].cells[0].innerHTML);
            if (startDate > transDate){
              table.deleteRow(i);
              i--;
            }
            if (endDate < transDate){
              table.deleteRow(i);
              i--;
            }
          }
        }
      }

      function filterTable() {
        var urlVars = getUrlVars();
        var table = document.getElementById("transTable");
        if (urlVars.addrmv == 'add'){
          for (var i = 0; i < table.rows.length; i++){
            table.rows[i].cells[0].innerHTML = 500;

          }
        }

      }
    </script>

    <body onload="sortTable()">
      <div class="row">
        <div class="col text-center" style="...">
          <h1>Inventory History</h1>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <form id="sortSelect">
              <div class="form-group">
                <select id="inventoryDropdown" class="form-control" name="sort" id="sort">
                  <!--<option value="date">Date</option>
                  <option value="alph">Alphabetical</option>-->
                  <option value="all">All Inventory</option>
                  @for ($i = 0; $i < count($sortedNames); ++$i)
                    <option id="inventory-{{$i}}" value="{{$sortedNames[$i]}}" name="{{$sortedNames[$i]}}">{{$sortedDisplayNames[$i]}}</option>
                  @endfor
                </select>
              </div>
              <div class="form-group">
                <select id="ascendingOrDescendingDropdown" class="form-control" name="order" id="order">
                  <option value="dec">Descending</option>
                  <option value="inc">Ascending</option>
                </select>
              </div>
              <div class="form-group">
                <select id="addOrRemoveDropdown" class="form-control" name="addrmv" id="addrmv">
                  <option value="addrmv">Add/Remove</option>
                  <option value="add">Add</option>
                  <option value="rmv">Remove</option>
                </select>
              </div>
              <div class="form-group">
                Start Date: <input class="form-control" name="start" type="date"><br>
                End Date: <input class="form-control" name="end" type="date">
              </div>
              <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <div class="col-md-8">
            <div class="table-scroll">
              <table dusk="transactionTable" id="transTable" class="table table-striped table-bordered">
                <thead>
                  <th scope="col">Transaction Date</th>
                  <th scope="col">Item</th>
                  <th scope="col">Change</th>
                  <th scope="col">User</th>
                  <th scope="col">Comment</th>
                </thead>
                <tbody>
                  @for ($i = count($activeTransactions) - 1; $i > 0; --$i)
                  <tr>
                    <td>{{$transactionDates[$i]}}</td>
                    <td>{{$transactionNames[$i]}}</td>
                    <td>{{$transactionChanges[$i]}}</td>
                    <td>{{$transactionUserNames[$i]}}</td>
                    <td>{{$transactionComments[$i]}}</td>
                  </tr>
                  @endfor
                </tbody>
              </div>
          </div>


            <br>

    </body>
@endsection
