@extends('home.dashboard')

@push('css')
    {{-- data table --}}
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <style>
        .breadcrumb {
            background-color: transparent;
        }
    </style>
@endpush

@section('content')
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-4">
                    <div class="pagetitle">
                        <h1>Trade Journal</h1>
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="home">Home</a></li>
                                <!--<li class="breadcrumb-item">Search</li> -->
                                <li class="breadcrumb-item "><a href="trade-journal" class="active">Trade Journal</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <div class="col-lg-6">
                    <div class="row">
                        <form action="" method="POST" name="date_select">
                            @csrf
                            <div class="col-sm-5">
                                <label for="StartDate" class="form-label">Start Date</label>
                                <input type="date" name="StartDate" value="{{ $StartDate }}" class="form-date"
                                    id="StartDate">
                            </div>
                            <div class="col-sm-5">
                                <label for="EndDate" class="form-label">End Date</label>
                                <input type="date" name="EndDate" value="{{ $EndDate }}" class="form-date"
                                    id="EndDate">
                                <div class="invalid-feedback" id="EndDateValid" style="font-size: 10px">End Date Can't Less
                                    than Start Date</div>
                            </div>
                            <div class="col-sm-2">
                                <label for="DateSelect" class="form-label"></label>
                                <button type="submit" class="btn btn-primary" name="DateSelect"
                                    id="DateSelect">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Page Title -->
        {{-- <section class="section">
            <div class="row">
                <div class="col-md-4">
                    <div class="card info-card">
                        <div class="kpi-body">
                            <h5 class="kpi-title" style="text-align:center">Profit/ Loss</h5>
                            <div class="align-items-center" style="text-align:center">
                                <div class="card-icon rounded-circle align-items-center justify-content-center">
                                    <div class="">
                                        <h6 class="kpi-txt"></h6>
                                    </div>
                                </div>
        
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
        </section> --}}
        <br>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body" id="table-container">
                            <!-- <h5 class="card-title">Today's Cryptocurrency Prices by Market Cap</h5>
                                                      <p>The global cryptocurrency market cap today is $1.95 Trillion, a 0.2% change in the last 24 hours</p> -->

                            <!-- Table with stripped rows -->
                            <table class="table" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Trade</th>
                                        <th scope="col">Order</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Chart</th>
                                        <th scope="col">Script</th>
                                        <th scope="col">System</th>
                                        <th scope="col">Entry</th>
                                        <th scope="col">StopLoss</th>
                                        <th scope="col">Target 1:2</th>
                                        <th scope="col">Target 1:3</th>
                                        <th scope="col">Exit</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Candle%</th>
                                        <th scope="col">Risk</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- render tr -->
                                    @foreach ($trade as $val)
                                        <tr>
                                            <td>{{ $val['Trade'] }}</td>
                                            <td>{{ $val['Order'] }}</td>
                                            <td>{{ $val['Date'] }}</td>
                                            <td>{{ $val['Chart'] }}</td>
                                            <td>{{ $val['Script'] }}</td>
                                            <td>{{ $val['System'] }}</td>
                                            <td>{{ $val['Entry'] }}</td>
                                            <td>{{ $val['Stop_Loss'] }}</td>
                                            <td>{{ $val['Target1_2'] }}</td>
                                            <td>{{ $val['Target1_3'] }}</td>
                                            <td>{{ $val['Exit'] }}</td>
                                            <td>{{ $val['Quantity'] }}</td>
                                            <td>{{ $val['Candle'] }}</td>
                                            <td>{{ $val['Risk'] }}</td>
                                            <td>
                                                <a href="view-trade/{{ $val['TradeID'] }}"
                                                    onclick="return confirm('Are You sure Want to View {{ $val['Script'] }}')"><i
                                                        class="bi bi-eye-fill"></i></a>
                                                {{-- <a href="modify-entry/Edit/{{ $val['Order'] }}/{{ $val['TradeID'] }}"
                                                    class=""
                                                    onclick="return confirm('Are You sure Want to modify {{ $val['Script'] }}')"><i
                                                        class="bi bi-pencil-square"></i></a> --}}
                                            </td>
                                            <!-- Script Link for Chart View -->

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection
@push('script')
    {{-- data table --}}
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            var table = $('#datatable').DataTable({
                scrollX: true,
                scrollCollapse: true,
                responsive: true,
                // columnDefs: [{
                //     targets: '_all',
                //     width: calculateColumnWidth(),
                // }],
                order: [
                    [2, 'desc']
                ]
            });
        });


        // start date should not be more than end date; end date today so start date tomorrow
        $(function() {
            $(".form-date").change(function() {
                var EndDate = $("#EndDate").val();
                var StartDate = $("#StartDate").val();
                if (EndDate < StartDate) {
                    $("#EndDateValid").show();
                    $("#DateSelect").prop('disabled', true);
                } else {
                    $("#EndDateValid").hide();
                    $("#DateSelect").prop('disabled', false);
                }
            });
        });
    </script>
@endpush
