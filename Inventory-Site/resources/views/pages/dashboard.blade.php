@inject('dashboardCont', 'App\Http\Controllers\DashboardController')
@extends('layouts.sidebar')
@php

$inventoryNames = array();
$inventoryDisplayNames = array();
$inventoryQuantities = array();
$inventoryCapacities = array();
$inventoryThresholds = array();
$inventoryIDs = array();
$visitedArray = array();

/*
$activeItemsFiltered = $activeItems->toArray();
for ($i = 0; $i < count($activeItems); ++$i) {
  if ($activeItems[$i]->removed == 1) {
    array_splice($activeItemsFiltered, $i, 1);
  }
}
*/

for ($i = 0; $i < count($activeItems); ++$i) {
  //if statement prevents dashboard from breaking if any items are marked removed in the database
  if ($activeItems[$i]->removed == 0) {
    $inventoryNames[] = str_replace(' ', '', $activeItems[$i]->name);
    $inventoryDisplayNames[] = $activeItems[$i]->name;
    $inventoryQuantities[] = $activeItems[$i]->quantity;
    $inventoryCapacities[] = $activeItems[$i]->capacity;
    $inventoryThresholds[] = $activeItems[$i]->low_threshold;
    $inventoryIDs[] = $activeItems[$i]->id;
    $visitedArray[$i+1] = 0;
  }
}

$sortedNames = $inventoryNames;
usort($sortedNames, 'strnatcasecmp');
$sortedDisplayNames = $inventoryDisplayNames;
usort($sortedDisplayNames, 'strnatcasecmp');

$transactionChanges = array();
$transactionDates = array();
$transactionIDs = array();
$recentChanges = array();

for ($i = 0; $i < count($activeTransactions); ++$i) {
  //if statement prevents dashboard from breaking if any items are marked removed in the database
  //TODO CHECK WHY ITS DELETING YEETERONIS
  if ($activeItems[$activeTransactions[$i]->item_id-1]->removed == 0){
    $transactionChanges[] = $activeTransactions[$i]->item_quantity_change;
    $transactionDates[] = $activeTransactions[$i]->transaction_date;
    $transactionIDs[] = $activeTransactions[$i]->item_id;
  }
}
for ($i = count($activeTransactions); $i > count($activeTransactions)-10; --$i) {
  if ($i > 0) {
    $recentChanges[] = $activeTransactions[$i-1];
  }
}

$transactionNames = array();
for ($i = 0; $i < count($transactionIDs); ++$i) {
  if (in_array($transactionIDs[$i], $inventoryIDs)) {
    $transactionNames[] = $inventoryNames[array_search($transactionIDs[$i], $inventoryIDs)];
  }
}


$arrayOfSums = array();
for ($i = 0; $i < count($inventoryIDs); ++$i) {
  $arrayOfSums[$inventoryIDs[$i]] = $inventoryQuantities[$i];
}
$transactionQuantities = array();
for ($i = count($transactionChanges)-1; $i >= 0; --$i){
  if (isset($transactionIDs[$i]) && isset($visitedArray[$transactionIDs[$i]])) {
    if ($visitedArray[$transactionIDs[$i]] == 0){
      $visitedArray[$transactionIDs[$i]] = 1;
      $transactionQuantities[] = $arrayOfSums[$transactionIDs[$i]];
      $arrayOfSums[$transactionIDs[$i]] -= $transactionChanges[$i];
    }
    elseif ($visitedArray[$transactionIDs[$i]] == 1){
      $transactionQuantities[] = $arrayOfSums[$transactionIDs[$i]];
      $arrayOfSums[$transactionIDs[$i]] -= $transactionChanges[$i];
    }
  }

}
@endphp

@section('content')
<head>
  <style>
  .vertical-menu {
    height: 230px;
    overflow-y: auto;
  }
  .vertical-menu a {
    background-color: #eee;
    display: block;
    padding: 8px;
    color: black;
  }
  .vertical-menu a:hover{
    background-color: #ccc;
  }

  .checkbox {
    height: 100px;
  }

  .table-scroll {
    height: 230px;
    overflow-y: auto;
  }
  .viewSelectBoxes {
    height: 230px;
    overflow-y: auto;
  }
  .col-md-2 {
    padding-left: 3%;
  }
  </style>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <script>
    function getUrlVars() {
      var vars = {};
      var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
          vars[key] = value;
      });
      return vars;
    }

    function addData(chart, label, data){
      chart.data.datasets.labels.push(label);
      chart.data.datasets.data.push(data);
      chart.update();
    }
    function removeData(chart){
      chart.data.labels.pop();
      chart.data.datasets.forEach((dataset) => {
        dataset.data.pop();
      });
      chart.update();
    }

    function lineSearch(name, lines){
      for (var i = 0; i < lines.length; i++){
        if (name == lines[i].label){
          return i;
        }
      }
      return -1;
    }

    function rememberChecks() {
      var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
      var form = document.getElementById("viewSelect");
      var checkedNames = getUrlVars();
      //form["totalInventory"].checked = "on";
      if (checkedNames["totalInventory"] == "on"){
        form["totalInventory"].checked = "on";
      }
      for (var i = 0; i < inventoryNames.length; i++){
        if (checkedNames[inventoryNames[i]] == "on"){
          form[inventoryNames[i]].checked = "on";
        }
      }
    }
  </script>

</head>
<body onload="rememberChecks()">
<div class="row">
  <!--Low Inventory Notifier-->
  <div class="col-md-2">
    <h4><strong>Low Inventory</strong></h4>
      <div class="vertical-menu" id="lowInventory">
          @for ($i = 0; $i < count($inventoryQuantities); ++$i)
              @if ($inventoryQuantities[$i] < $inventoryThresholds[$i])
                  <a>{{$inventoryDisplayNames[$i]}}</a>
              @endif
          @endfor
    </div>
  </div>
  <!--Current Inventory Chart-->
  <div class="col-md-5">
    <div>
      <canvas id="inventoryChart"></canvas>
    </div>
    <script>
      var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
      var inventoryDisplayNames = <?php echo json_encode($inventoryDisplayNames); ?>;
      var inventoryQuantities = <?php echo json_encode($inventoryQuantities); ?>;

      var checkedNames = getUrlVars();
      var activeNames = [];
      var activeQuantities = [];
      var activeDisplayNames = [];
      if (checkedNames["totalInventory"] == "on"){
        activeNames = inventoryNames;
        activeDisplayNames = inventoryDisplayNames;
        activeQuantities = inventoryQuantities;
      }
      else {
        for (var i = 0; i < inventoryNames.length; i++){
            if (checkedNames[inventoryNames[i]] == "on"){
            activeNames.push(inventoryNames[i]);
            activeDisplayNames.push(inventoryDisplayNames[i]);
            activeQuantities.push(inventoryQuantities[i]);
          }
        }
      }

      //You can add more colors here just fine
      var backgrounds=[
        'rgba(255, 20, 20, .2)',
        'rgba(20, 240, 255, .2)',
        'rgba(0, 255, 15, .2)',
        'rgba(180, 0, 255, .2)',
        'rgba(255, 160, 0, .2)'];
      var borders=[
        'rgba(255, 20, 20, .8)',
        'rgba(20, 240, 255, .8)',
        'rgba(0, 255, 15, .8)',
        'rgba(180, 0, 255, .8)',
        'rgba(255, 160, 0, .8)'];

      var chartColors = [];
      var chartBorders = [];
      for (var i = 0; i < activeQuantities.length; i++){
        chartColors.push(backgrounds[i%backgrounds.length]);
        chartBorders.push(borders[i%borders.length]);
      }

      var inventoryChart = document.getElementById('inventoryChart').getContext('2d');
      var inventoryChart = new Chart(inventoryChart, {
        type:'bar',
        data:{
          labels:activeDisplayNames,
          datasets:[{
            //label:'Current Inventory',
            data: activeQuantities,
            backgroundColor: chartColors,
            borderColor: chartBorders,
            borderWidth: 2
          }]
        },
        options:{
          legend:{
            display: false
          },
          title:{
            display: true,
            fontSize: 20,
            fontColor: 'black',
            text: 'Current Inventory'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      });

    </script>
  </div>
  <!--Recent Inventory Table-->
  <div class="col-md-5">
    <script>
      var transactionDates = <?php echo json_encode($transactionDates); ?>;
      var transactionChanges = <?php echo json_encode($transactionChanges); ?>;
      var transactionIDs = <?php echo json_encode($transactionIDs); ?>;
      var recentChanges = <?php echo json_encode($recentChanges); ?>;
      var inventoryIDs = <?php echo json_encode($inventoryIDs); ?>;
      var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
      var transactionNames = <?php echo json_encode($transactionNames); ?>;
      var transactionQuantities = <?php echo json_encode($transactionQuantities); ?>;
    </script>
    <h4><strong>Recent Inventory</strong></h4>
    <div class="table-scroll" id="recentInventory">
      <table class="table table-sm">
        <thead>
          <th scope="col">Item</th>
          <th scope="col">Change</th>
          <th scope="col">New Stock</th>
          <th scope="col">Date</th>
        </thead>
        <tbody>
          <!--Displays the X-1 most recent transactions in order of recency
              X meaning the integer in $i > count($transactionChanges)-X
              So if its $i > count($transactionChanges)-10, the 9 most recent transactions are shown-->
          @for ($i = count($transactionChanges)-1; $i > count($transactionChanges)-16; --$i)
          @if ($i >= 0)
            @if ($transactionChanges[$i] < 0)
              <tr style="background-color:#ffdede">
                <th scope="row">{{$transactionNames[$i]}}</th>
                <td>{{$transactionChanges[$i]}}</td>
                <td>{{$transactionQuantities[count($transactionQuantities) - $i - 1]}}</td>
                <td>{{$transactionDates[$i]}}</td>
              </tr>
            @endif
            @if ($transactionChanges[$i] > 0)
              <tr style="background-color:#e0ffde">
                <th scope="row">{{$transactionNames[$i]}}</th>
                <td>{{$transactionChanges[$i]}}</td>
                <td>{{$transactionQuantities[count($transactionQuantities) - $i - 1]}}</td>
                <td>{{$transactionDates[$i]}}</td>
              </tr>
            @endif
            @endif
          @endfor
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="row">
  <!--Form Selection for displayed inventory-->
  <div class="col-md-2">
    <form id="viewSelect" class="viewSelect">
      <div class="form-group">
        <!--<input type="submit" value="Submit" name="submitButton"><br>-->
        <button name="submitButton" type="submit" class="btn btn-primary">Submit</button><br>
      </div>
      <div class="viewSelectBoxes">
      <input type="checkbox" name="totalInventory">Total Inventory<br>
      @for ($i = 0; $i < count($sortedNames); ++$i)
        <input type="checkbox" id="{{$sortedNames[$i]}}" name="{{$sortedNames[$i]}}">{{$sortedDisplayNames[$i]}}<br>
      @endfor
    </div>
    </form>
  </div>
  <!--Weekly Inventory Chart-->
  <div class="col-md-5">
    <div>
      <canvas id="monthlyChart"></canvas>
    </div>
    <script>
      var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
      var inventoryDisplayNames = <?php echo json_encode($inventoryDisplayNames); ?>;
      var inventoryQuantities = <?php echo json_encode($inventoryQuantities); ?>;
      var transactionDates = <?php echo json_encode($transactionDates); ?>;
      var transactionNames = <?php echo json_encode($transactionNames); ?>;

      var checkedNames = getUrlVars();
      var activeNames = [];
      var activeQuantities = [];
      var activeDisplayNames = [];
      if (checkedNames["totalInventory"] == "on"){
        activeNames = inventoryNames;
        activeDisplayNames = inventoryDisplayNames;
        activeQuantities = inventoryQuantities;
      }
      else {
        for (var i = 0; i < inventoryNames.length; i++){
            if (checkedNames[inventoryNames[i]] == "on"){
              activeNames.push(inventoryNames[i]);
              activeDisplayNames.push(inventoryDisplayNames[i]);
              activeQuantities.push(inventoryQuantities[i]);
            }
        }
      }

      //Need to get this to use transactions table
      var ctx = document.getElementById('monthlyChart').getContext('2d');
      var monthlyChart = new Chart(ctx, {
        type:'line',
        data:{
          labels:['3 Weeks', '2 Weeks', '1 Week', '0 Week'],
          datasets:[],
        },
        options:{
          title:{
            display:true,
            text: 'Weekly Inventory',
            fontSize: 20,
            fontColor: 'black'
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      });

      var lines = [];
      var backgrounds=[
        'rgba(255, 20, 20, .2)',
        'rgba(20, 240, 255, .2)',
        'rgba(0, 255, 15, .2)',
        'rgba(180, 0, 255, .2)',
        'rgba(255, 160, 0, .2)'];
      var borders=[
        'rgba(255, 20, 20, .8)',
        'rgba(20, 240, 255, .8)',
        'rgba(0, 255, 15, .8)',
        'rgba(180, 0, 255, .8)',
        'rgba(255, 160, 0, .8)'];
      for (var i = 0; i < activeNames.length; i++){
        var itemLine = {
          label: activeNames[i],
          data: [0, 0, 0, activeQuantities[i]],
          fill: false,
          //i%5 makes colors loop after 5
          //Might need to add more colors, readability concern
          backgroundColor: backgrounds[i%5],
          borderColor: borders[i%5],
          borderWidth: 2
        }
        lines.push(itemLine);
      }

      var today = Date.now();
      //604800000 is the number of milliseconds in a week
      var fourWeeks = today - 4*604800000;
      var threeWeeks = today - 3*604800000;
      var twoWeeks = today - 2*604800000;
      var oneWeek = today - 604800000;

      //DO THIS BY PULLING VALUES FROM RECENT CHANGES TABLE --- getElementById
      //Can't do that b/c the needed values might not be in the ~15 most recent changes
      //Fills data for each line object
      for (var i = 0; i < transactionNames.length; i++){
        var nameIndex = lineSearch(transactionNames[i], lines);
        if (nameIndex >= 0){
          var targetDate = Date.parse(transactionDates[i]);
          if (targetDate > fourWeeks && targetDate <= threeWeeks){
            lines[nameIndex].data[0] = parseInt(lines[nameIndex].data[0]) - parseInt(transactionChanges[i]);
          }
          if (targetDate > threeWeeks && targetDate <= twoWeeks){
            lines[nameIndex].data[1] = parseInt(lines[nameIndex].data[1]) - parseInt(transactionChanges[i]);
          }
          if (targetDate > twoWeeks && targetDate <= oneWeek){
            lines[nameIndex].data[2] = parseInt(lines[nameIndex].data[2]) - parseInt(transactionChanges[i]);
          }
          if (targetDate > oneWeek && targetDate <= today){
            //lines[nameIndex].data[3] = parseInt(lines[nameIndex].data[3]) + parseInt(transactionChanges[i]);
            //lines[nameIndex].data[3] = parseInt(activeQuantities[i]);
          }
        }
      }

      for (var i = 0; i < lines.length; i++){
        lines[i].data[2] = parseInt(lines[i].data[2]) + parseInt(lines[i].data[3]);
        lines[i].data[1] = parseInt(lines[i].data[1]) + parseInt(lines[i].data[2]);
        lines[i].data[0] = parseInt(lines[i].data[0]) + parseInt(lines[i].data[1]);
      }


      //Loads line graph
      for (var i = 0; i < lines.length; i++){
        monthlyChart.data.datasets.push(lines[i]);
      }
      monthlyChart.update();


    </script>
  </div>
  <!--Inventory vs Capacity chart-->
  <div class="col-md-5">
    <div>
      <canvas id="capacityChart"></canvas>
    </div>
    <script>
      var inventoryNames = <?php echo json_encode($inventoryNames); ?>;
      var inventoryQuantities = <?php echo json_encode($inventoryQuantities); ?>;
      var inventoryDisplayNames = <?php echo json_encode($inventoryDisplayNames); ?>;
      var inventoryCapacities = <?php echo json_encode($inventoryCapacities); ?>;

      var checkedNames = getUrlVars();
      var activeNames = [];
      var activeDisplayNames = [];
      var activeQuantities = [];
      var activeCapacities = [];
      if (checkedNames["totalInventory"] == "on"){
        activeNames = inventoryNames;
        activeDisplayNames = inventoryDisplayNames;
        activeQuantities = inventoryQuantities;
        activeCapacities = inventoryCapacities;
      }
      else {
        for (var i = 0; i < inventoryNames.length; i++){
          if (checkedNames[inventoryNames[i]] == "on"){
            activeNames.push(inventoryNames[i]);
            activeDisplayNames.push(inventoryDisplayNames[i]);
            activeQuantities.push(inventoryQuantities[i]);
            activeCapacities.push(inventoryCapacities[i]);
          }
        }
      }

      //You can add more colors here just fine
      var backgrounds=[
        'rgba(255, 20, 20, .2)',
        'rgba(20, 240, 255, .2)',
        'rgba(0, 255, 15, .2)',
        'rgba(180, 0, 255, .2)',
        'rgba(255, 160, 0, .2)'];
      var borders=[
        'rgba(255, 20, 20, .8)',
        'rgba(20, 240, 255, .8)',
        'rgba(0, 255, 15, .8)',
        'rgba(180, 0, 255, .8)',
        'rgba(255, 160, 0, .8)'];

      var chartColors = [];
      var chartBorders = [];
      var chartCapacityColors = [];
      var chartCapacityBorders = [];
      for (var i = 0; i < activeQuantities.length; i++){
        chartColors.push(backgrounds[i%backgrounds.length]);
        chartBorders.push(borders[i%borders.length]);
        chartCapacityColors.push(backgrounds[(i+3)%backgrounds.length]);
        chartCapacityBorders.push(borders[(i+3)%borders.length]);
      }

      var capacityChart = document.getElementById('capacityChart').getContext('2d');
      var capacityChart = new Chart(capacityChart, {
        type:'bar',
        data:{
          labels:activeDisplayNames,
          datasets:[
          {
            label:'Inventory',
            data:activeQuantities,
            backgroundColor:chartColors,
            borderColor:chartBorders,
            borderWidth: 2
          },
          {
            label:'Capacity',
            data:activeCapacities,
            backgroundColor:chartCapacityColors,
            borderColor:chartCapacityBorders,
            borderWidth: 2
          }
        ]
        },
        options:{
          legend:{
            display: false
          },
          title:{
            text: 'Inventory vs. Capacity',
            fontSize: 20,
            fontColor: 'black',
            display: true
          },
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero:true
              }
            }]
          }
        }
      });
    </script>
  </div>
</div>
</body>

@endsection
