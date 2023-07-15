@extends('home.dashboard')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Risk Factor</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <!--<li class="breadcrumb-item">Search</li> -->
                    <li class="breadcrumb-item "><a href="risk-factor" class="active">Risk Factor</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-12">
            <div class="card" style="background-color: transparent; box-shadow: none;">
                <h5 class="card-title">Intraday</h5>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Intraday Capital</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $intraCap }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Total Risk</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $intraTotalRisk }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Turnover</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $turnOver }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Risk In Cash</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $riskPossibleIntra }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Possible trade</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $tradePossibleIntra }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-12">
            <div class="card" style="background-color: transparent; box-shadow: none;">
                <h5 class="card-title">Equity</h5>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Equity Capital</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $equityCap }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Total Risk</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $equityTotalRisk }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Risk In Market</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $InMktRisk }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Risk In Cash</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $riskPossibleEquity }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Possible trade</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $tradePossibleEquity }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <br>

        <!-- Reports -->
        <div class="col-12">
            <div class="card">

                {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div> --}}

                {{-- <div class="card-body">
                    <h5 class="card-title">Reports <span>/Today</span></h5>

                    <!-- Line Chart -->
                    <div id="reportsChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            new ApexCharts(document.querySelector("#reportsChart"), {
                                series: [{
                                    name: 'Sales',
                                    data: [31, 40, 28, 51, 42, 82, 56],
                                }, {
                                    name: 'Revenue',
                                    data: [11, 32, 45, 32, 34, 52, 41]
                                }, {
                                    name: 'Customers',
                                    data: [15, 11, 32, 18, 9, 24, 11]
                                }],
                                chart: {
                                    height: 350,
                                    type: 'area',
                                    toolbar: {
                                        show: false
                                    },
                                },
                                markers: {
                                    size: 4
                                },
                                colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                fill: {
                                    type: "gradient",
                                    gradient: {
                                        shadeIntensity: 1,
                                        opacityFrom: 0.3,
                                        opacityTo: 0.4,
                                        stops: [0, 90, 100]
                                    }
                                },
                                dataLabels: {
                                    enabled: false
                                },
                                stroke: {
                                    curve: 'smooth',
                                    width: 2
                                },
                                xaxis: {
                                    type: 'datetime',
                                    categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z",
                                        "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z",
                                        "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z",
                                        "2018-09-19T06:30:00.000Z"
                                    ]
                                },
                                tooltip: {
                                    x: {
                                        format: 'dd/MM/yy HH:mm'
                                    },
                                }
                            }).render();
                        });
                    </script>
                    <!-- End Line Chart -->

                </div> --}}

            </div>
        </div><!-- End Reports -->
    </main>
@endsection
@push('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
@endpush
