@extends('layouts.admin')
@section('content')
@if ($user->isAdmin())
<div class="content">
  <div class="row">
      <div class="col-lg-12">
          <section class="content">
              <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                      <div class="inner">
                        <h3>{{$totalCompletedEventsCount}}</h3>
        
                        <p>Total Events</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-bag"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                      <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup></h3>
        
                        <p>Bounce Rate</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                      <div class="inner">
                        <h3>44</h3>
        
                        <p>User Registrations</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                  <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                      <div class="inner">
                        <h3>65</h3>
        
                        <p>Unique Visitors</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                      </div>
                    </div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->
                
                <!-- /.row (main row) -->
              </div><!-- /.container-fluid -->
            </section>
      </div>

      <div class="col-lg-12">
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">Bookings</h3>
          </div>
          <div class="card-body">
            <div class="chart">
              <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
@else
  <h1>Organizer</h1>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
@endsection
@section('scripts')
@parent

@endsection

@section('scripts')
<script>
  $(function () {

    var areaChartData = {
      labels  : ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [
        {
          label               : 'Events Booked',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [48, 50, 40, 19, 86, 27, 90]
        },
        {
          label               : 'Events Cancelled',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [5, 9, 8, 4, 40, 5, 25]
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: false
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : false,
          }
        }],
        yAxes: [{
          gridLines : {
            display : false,
          }
        }]
      }
    }


    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp0
    barChartData.datasets[1] = temp1

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false
    }

    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })
  })
</script>
@endsection