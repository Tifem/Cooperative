@extends('layouts.master')

@section('headlinks')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')

    <div class="row">
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1" >
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Income</span>
                            <h4 class="mb-3" style="text-align: right">
                                {{-- ₦<span>{{number_format(\App\Models\Receipt::sum('amount'), 2)}}</span> --}}
                            </h4>
                            <div class="text-nowrap">

                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Lodge</span>
                            <h4 class="mb-3" style="text-align: right">
                                {{-- ₦<span >{{number_format(\App\Models\Receipt::where('lodgement_status', 1)->sum('amount'), 2)}}</span> --}}
                            </h4>
                            <div class="text-nowrap">

                            </div>
                        </div>

                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Total Outstanding</span>
                            <h4 class="mb-3" style="text-align: right">
                                {{-- ₦<span >{{number_format(\App\Models\Receipt::where('lodgement_status', 0)->sum('amount'), 2)}}</span> --}}
                            </h4>
                            <div class="text-nowrap">

                            </div>
                        </div>

                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

    </div><!-- end row-->

    <div class="row" style="display:none">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Line Chart</h4>
                </div>
                <div class="card-body">

                    <canvas id="lineChart" height="300" data-colors='["rgba(28, 132, 238, 0.2)", "#1c84ee", "rgba(235, 239, 242, 0.2)", "#ebeff2"]'></canvas>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Bar Chart</h4>
                </div>
                <div class="card-body">

                    <canvas id="bar" height="300" data-colors='["rgba(52, 195, 143, 0.8)", "rgba(52, 195, 143, 0.9)"]'></canvas>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row" style="display:none">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Pie Chart</h4>
                </div>
                <div class="card-body">

                    <canvas id="pie" height="260" data-colors='["#34c38f", "#ebeff2"]'></canvas>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Donut Chart</h4>
                </div>
                <div class="card-body">

                    <canvas id="doughnut" height="260" data-colors='["#1c84ee", "#ebeff2"]'></canvas>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row" style="display:none">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Polar Chart</h4>
                </div>
                <div class="card-body">

                    <canvas id="polarArea" height="300" data-colors='["#ef6767", "#34c38f", "#ffcc5a", "#1c84ee"]'> </canvas>

                </div>
            </div>
        </div> <!-- end col -->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Radar Chart</h4>
                </div>
                <div class="card-body">
                    <canvas id="radar" height="300" data-colors='["rgba(52, 195, 143, 0.2)", "#34c38f", "rgba(28, 132, 238, 0.2)", "#1c84ee"]'></canvas>
                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row" style="display:none">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Line Chart</h4>
                </div>
                <div class="card-body">
                    <div id="line-chart" data-colors='["#34c38f", "#ccc"]' class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Mix Line-Bar</h4>
                </div>
                <div class="card-body">
                    <div id="mix-line-bar" data-colors='["#34c38f", "#1c84ee", "#ef6767"]' class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Doughnut Chart</h4>
                </div>
                <div class="card-body">
                    <div id="doughnut-chart" data-colors='["#1c84ee", "#ffcc5a", "#ef6767", "#16daf1", "#34c38f"]' class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Pie Chart</h4>
                </div>
                <div class="card-body">
                    <div id="pie-chart" data-colors='["#ef6767", "#34c38f", "#16daf1", "#ffcc5a", "#1c84ee"]' class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->

    <div class="row" style="display:none">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Scatter Chart</h4>
                </div>
                <div class="card-body">
                    <div id="scatter-chart" data-colors='["#34c38f"]' class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Bubble Chart</h4>
                </div>
                <div class="card-body">
                    <div id="bubble-chart" data-colors='["rgb(28, 132, 238)", "rgb(143, 148, 255)", "rgba(28, 132, 238, 0.5)", "rgb(52, 195, 143)", "rgb(111, 255, 203)",  "rgb(52, 195, 143, 0.5)"]' class="e-charts"></div>
                </div>
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('scripts')
        <!-- echarts js -->
        <script src="{{asset('assets/libs/echarts/echarts.min.js')}}"></script>
        <!-- echarts init -->
        <script src="assets/js/pages/echarts.init.js"></script>
    <!-- Chart JS -->
    <script src="{{asset('assets/libs/chart.js/Chart.bundle.min.js')}}"></script>
    <!-- chartjs init -->
    <script src="{{asset('assets/js/pages/chartjs.init.js')}}"></script>
@endsection
