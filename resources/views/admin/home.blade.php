@extends('layouts.admin')
@section('content')
    <div class="content">
        @if (auth()->user()->isOrganizer())
            @if (!auth()->user()->stripeSettings()->exists())
                <div class="alert alert-danger alert-dismissible">
                    <h5><i class="icon fas fa-info"></i> Warning!</h5>
                    Please Connect with Stripe to Access the platform.
                    <a href="">Click Here</a>
                </div>
            @elseif(auth()->user()->stripeSettings()->exists() && !auth()->user()->stripeSettings()->first()->details_submitted)
                <div class="alert alert-info alert-dismissible">
                    <h5><i class="icon fas fa-info"></i> Note!</h5>
                    Please contact the admin to complete the setup.
                </div>
            @endif
        @endif


        <div class="row">
            <div class="col-lg-12">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $counts['totalEvents'] }}</h3>
                                        <p>Total Events</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $counts['totalTicketsSold'] }}</h3>
                                        <p>Total Tickets Sold</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $counts['upcomingEvents'] }}</h3>
                                        <p>Upcoming Events</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ $counts['totalRevenue'] }}</h3>
                                        <p>Total Revenue</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-lg-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Events Overview</h3>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="areaChart"
                                style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
@endsection
@section('scripts')
    @parent
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var labels = [];
            var revenueData = [];

            @foreach ($revenueData as $data)
                labels.push("{{ \Carbon\Carbon::createFromDate($data->year, $data->month, 1)->format('M Y') }}");
                revenueData.push("{{ $data->total_revenue }}");
            @endforeach

            var areaChartData = {
                labels: labels,
                datasets: [{
                    label: 'Monthly Revenue',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: revenueData
                }]
            };

            var areaChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        grid: {
                            display: false
                        }
                    }
                }
            };


            var areaChartCanvas = $('#areaChart').get(0).getContext('2d');
            var areaChart = new Chart(areaChartCanvas, {
                type: 'bar',
                data: areaChartData,
                options: areaChartOptions
            });
        });
    </script>
@endsection
