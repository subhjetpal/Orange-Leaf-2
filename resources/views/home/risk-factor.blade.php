@extends('home.dashboard')

@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-4">
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
                </div>
                <div class="col-lg-2"></div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="StartDate" class="form-label">Start Period</label>
                            <input type="date" name="StartDate" value="{{ $StartDate }}" class="form-date"
                                id="StartDate" readonly>
                        </div>
                        <div class="col-sm-6">
                            <label for="EndDate" class="form-label">End Period</label>
                            <input type="date" name="EndDate" value="{{ $EndDate }}" class="form-date"
                                id="EndDate" readonly>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="col-12">
            <div class="card" style="background-color: transparent; box-shadow: none;">
                <h5 class="card-title">Positional</h5>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Capital</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $positionalCap }}</h6>
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
                                                <h6 class="kpi-txt">{{ $positiionalTotalRisk }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Risk In Market | Turnover</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $InMktRiskPositional }} | {{$turnoverPositional}}</h6>
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
                                                <h6 class="kpi-txt">{{ $riskPossiblePositional }}</h6>
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
                                                <h6 class="kpi-txt"><span style="font-size: 22px">{{ $positionalRisk }} x </span>{{ $tradePossiblePositional }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Equity Expense</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $equityExpense }}</h6>
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
                <h5 class="card-title">Swing</h5>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Capital</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $swingCap }}</h6>
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
                                                <h6 class="kpi-txt">{{ $swingTotalRisk }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Risk In Market | Turnover</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $InMktRiskSwing }} | {{$turnoverSwing}}</h6>
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
                                                <h6 class="kpi-txt">{{ $riskPossibleSwing }}</h6>
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
                                                <h6 class="kpi-txt"><span style="font-size: 22px">{{ $swingRisk }} x </span>{{ $tradePossibleSwing }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Equity Expense</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $equityExpense }}</h6>
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
                <h5 class="card-title">Options</h5>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Capital</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $optionsCap }}</h6>
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
                                                <h6 class="kpi-txt">{{ $optionsTotalRisk }}</h6>
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
                                                <h6 class="kpi-txt">{{ $turnOverOptions }}</h6>
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
                                                <h6 class="kpi-txt">{{ $riskPossibleOptions }}</h6>
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
                                                <h6 class="kpi-txt"><span style="font-size: 22px">{{ $optionsRisk }} x </span>{{ $tradePossibleOptions }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Expense</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $optionsExpense }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div><div class="col-12">
            <div class="card" style="background-color: transparent; box-shadow: none;">
                <h5 class="card-title">Commodity</h5>
                <section class="section">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Capital</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $commodityCap }}</h6>
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
                                                <h6 class="kpi-txt">{{ $commodityTotalRisk }}</h6>
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
                                                <h6 class="kpi-txt">{{ $turnOverCommodity }}</h6>
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
                                                <h6 class="kpi-txt">{{ $riskPossibleCommodity }}</h6>
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
                                                <h6 class="kpi-txt"><span style="font-size: 22px">{{ $commodityRisk }} x </span>{{ $tradePossibleCommodity }}</h6>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card info-card">
                                <div class="kpi-body">
                                    <h5 class="kpi-title" style="text-align:center">Expense</h5>
                                    <div class="align-items-center" style="text-align:center">
                                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                                            <div class="">
                                                <h6 class="kpi-txt">{{ $commodityExpense }}</h6>
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
