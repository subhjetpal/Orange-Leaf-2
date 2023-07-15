@extends('home.dashboard')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Trade Calculator</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="calculator" class="active">calculator</a></li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->
    <!-- Risk Analyze Form -->
    <section class="section">
        <div class="row">
            <div class="col-6">
                <div class="card float-center">
                    <div class="card-body">
                        <h5 class="card-title">EMI Calculator</h5>
                        <div class="col-12">
                            <label for="loanA" class="form-label">Loan Amount</label>
                            <input type="number" name="loanA" value="0" class="form-control" id="loanA" required>
                        </div>
                        <div class="col-12">
                            <label for="tenure" class="form-label">Tenure (in Months)</label>
                            <input type="number" name="tenure" value="12" class="form-control" id="tenure" required>
                        </div>
                        <div class="col-12">
                            <label for="interest" class="form-label">Interest (in Yearly %)</label>
                            <input type="number" name="interest" value="12" class="form-control" id="interest" required>
                        </div>
                        <div class="col-12">
                            <label for="NoCost" class="form-label">No Cost EMI</label>
                            <select name="NoCost" class="form-select" id="NoCost" required>
                                <option value="No" default>No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label for="DownPay" class="form-label">Down Payment</label>
                            <input type="number" name="DownPay" class="form-control" id="DownPay" value="0">
                        </div>
                        <div class="col-12">
                            <label for="EMI" class="form-label">Monthly EMI</label>
                            <input type="number" name="EMI" class="form-control" id="EMI" readonly>
                        </div>
                        <div class="col-12">
                            <label for="AvgGST" class="form-label">Avg GST</label>
                            <input type="number" name="AvgGST" class="form-control" id="AvgGST" readonly>
                        </div>
                        <div class="col-12">
                            <label for="Payable" class="form-label">Total Payable</label>
                            <input type="number" name="Payable" class="form-control" id="Payable" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div id="chart"></div>
            </div>
        </div>
    </section>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    $(function() {
        $(".form-control").change(function() {
            var loanA = $("#loanA").val();
            var tenure = $("#tenure").val();
            var interest = $("#interest").val();
            var NoCost = $("#NoCost").val();
            var DownPay = $("#DownPay").val();
            var GST = 0.18;

            var interest = parseFloat(interest) / 100;
            var MonthlyIntRate = interest / 12;

            var MonthlyIntRate_cal = 1 + parseFloat(MonthlyIntRate);
            var EMI = loanA * (MonthlyIntRate * (MonthlyIntRate_cal ** tenure)) / ((MonthlyIntRate_cal ** tenure) - 1);

            $("#EMI").val(EMI.toFixed(2));

            var Interst = [];
            var Principal = [];
            var MonthGST = [];
            var i, MonthlyInt, MonthlyPrincipal;
            for (i = 0; i < tenure; i++) {
                MonthlyInt = loanA * MonthlyIntRate;
                MonthlyPrincipal = EMI - MonthlyInt;

                Interst.push(MonthlyInt);
                Principal.push(MonthlyPrincipal);

                loanA = loanA - MonthlyPrincipal

                // do something with `substr[i]`
            }

            var options = {
                series: [{
                    name: 'Principal',
                    data: Principal
                }, {
                    name: 'Interest',
                    data: Interst
                    // }, {
                    //     name: 'GST',
                    //     data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                }],
                chart: {
                    type: 'bar',
                    // stacked: true,
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                // xaxis: {
                //     categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                // },
                yaxis: {
                    title: {
                        text: '$ (thousands)'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "$ " + val + " thousands"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

        });
    });
</script>
<script>
    $(function() {
        $(".form-control").change(function() {
            var options = {
                series: [{
                    name: 'Principal',
                    data: Principal.toFixed(2)
                }, {
                    name: 'Interest',
                    data: Interst.toFixed(2)
                    // }, {
                    //     name: 'GST',
                    //     data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                }],
                chart: {
                    type: 'bar',
                    // stacked: true,
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                // xaxis: {
                //     categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                // },
                yaxis: {
                    title: {
                        text: '$ (thousands)'
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return "$ " + val + " thousands"
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();
        });
    });
</script>
@endsection