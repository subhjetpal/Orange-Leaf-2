@extends('home.dashboard')

@section('content')
    <main id="main" class="main">
        <div class="col-4">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title" style="text-align:center">Sales</h5>
                    <div class="align-items-center" style="text-align:center">
                        <div class="card-icon rounded-circle align-items-center justify-content-center">
                            <div class="">
                                <h2 class="card-kpi">145</h2>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
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

                <div class="card-body">
                    <h5 class="card-title">Reports <span>/Today</span></h5>

                    <!-- Line Chart -->
                    <div id="reportsChart"></div>

                    <script>
                        document.addEventListener("DOMContentLoaded", () => {
                            const jsonData = {!! $jsonData !!};
                            const xValues = jsonData.map(item => item.x);
                            const yValues = jsonData.map(item => item.y);
                            new ApexCharts(document.querySelector("#reportsChart"), {
                                series: [{
                                    name: 'Entry',
                                    data: yValues,
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
                                    categories: xValues
                                },
                                tooltip: {
                                    x: {
                                        format: 'YYYY-mm-dd'
                                    },
                                }
                            }).render();
                        });
                    </script>
                    <!-- End Line Chart -->

                </div>

            </div>
        </div><!-- End Reports -->
    </main>
@endsection
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush
