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

        <div class="pagetitle">
            <h1>Open Trade</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <!--<li class="breadcrumb-item">Search</li> -->
                    <li class="breadcrumb-item "><a href="open-trade" class="active">Open Trade</a></li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        {{-- Open Trade --}}
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Open Trades</h5>
                            <table class="table" id='datatable' width="100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Trade</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Chart</th>
                                        <th scope="col">Script</th>
                                        <th scope="col">System</th>
                                        <th scope="col">Entry</th>
                                        <th scope="col">StopLoss</th>
                                        <th scope="col">Target 1:2</th>
                                        <th scope="col">Target 1:3</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Candle%</th>
                                        <th scope="col">Risk</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- render tr -->
                                    @foreach ($trade as $val)
                                        @if ($val['Order'] != 'In Process')
                                            <tr>
                                                <td>{{ $val['Trade'] }}</td>
                                                <td>{{ $val['Date'] }}</td>
                                                <td>{{ $val['Chart'] }}</td>
                                                <td>{{ $val['Script'] }}</td>
                                                <td>{{ $val['System'] }}</td>
                                                <td>{{ $val['Entry'] }}</td>
                                                <td>{{ $val['Stop_Loss'] }}</td>
                                                <td>{{ $val['Target1_2'] }}</td>
                                                <td>{{ $val['Target1_3'] }}</td>
                                                <td>{{ $val['Quantity'] }}</td>
                                                <td>{{ $val['Candle'] }}</td>
                                                <td>{{ $val['Risk'] }}</td>
                                                <td>
                                                    <a href="view-trade/{{ $val['TradeID'] }}"
                                                        onclick="return confirm('Are You sure Want to View {{ $val['Script'] }}')"><i
                                                            class="bi bi-eye-fill"></i></a>
                                                    <a href="modify-entry/Edit/{{ $val['Order'] }}/{{ $val['TradeID'] }}"
                                                        class=""
                                                        onclick="return confirm('Are You sure Want to Edit {{ $val['Script'] }}')"><i
                                                            class="bi bi-pencil-square"></i></a>
                                                    <a href="modify-entry/Upgrade/{{ $val['Order'] }}/{{ $val['TradeID'] != 'NULL' ? $val['TradeID'] : $val['Script'] }}/"
                                                        class=""
                                                        onclick="return confirm('Are You sure Want to Upgrade {{ $val['Script'] }}')"><i
                                                            class="bi bi-arrow-up-square"></i></a>
                                                </td>
                                                <!-- Script Link for Chart View -->

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Table with stripped rows -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <br />
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">

                        <div class="card-body">
                            <h5 class="card-title">In Process Trades</h5>
                            <table class="table" id=''>
                                <thead>
                                    <tr>
                                        <th scope="col">Trade</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Chart</th>
                                        <th scope="col">Script</th>
                                        <th scope="col">System</th>
                                        <th scope="col">Entry</th>
                                        <th scope="col">StopLoss</th>
                                        <th scope="col">Target 1:2</th>
                                        <th scope="col">Target 1:3</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">Candle%</th>
                                        <th scope="col">Risk</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- render tr -->
                                    @foreach ($trade as $val)
                                        @if ($val['Order'] == 'In Process')
                                            <tr>
                                                <td>{{ $val['Trade'] }}</td>
                                                <td>{{ $val['Date'] }}</td>
                                                <td>{{ $val['Chart'] }}</td>
                                                <td>{{ $val['Script'] }}</td>
                                                <td>{{ $val['System'] }}</td>
                                                <td>{{ $val['Entry'] }}</td>
                                                <td>{{ $val['Stop_Loss'] }}</td>
                                                <td>{{ $val['Target1_2'] }}</td>
                                                <td>{{ $val['Target1_3'] }}</td>
                                                <td>{{ $val['Quantity'] }}</td>
                                                <td>{{ $val['Candle'] }}</td>
                                                <td>{{ $val['Risk'] }}</td>
                                                <td>
                                                    @if ($val['Order'] != 'In Process')
                                                        <a href="view-trade/{{ $val['TradeID'] }}"
                                                            onclick="return confirm('Are You sure Want to View {{ $val['Script'] }}')"><i
                                                                class="bi bi-eye-fill"></i></a>
                                                        {{-- <a href="modify-entry/Edit/{{ $val['Order'] }}/{{ $val['TradeID'] }}"
                                                        class=""
                                                        onclick="return confirm('Are You sure Want to Edit {{ $val['Script'] }}')"><i
                                                            class="bi bi-pencil-square"></i></a> --}}
                                                    @endif
                                                    <a href="modify-entry/Upgrade/{{ $val['Order'] }}/{{ $val['TradeID'] != 'NULL' ? $val['TradeID'] : $val['Script'] }}/"
                                                        class=""
                                                        onclick="return confirm('Are You sure Want to Upgrade {{ $val['Script'] }}')"><i
                                                            class="bi bi-arrow-up-square"></i></a>
                                                    @if ($val['Order'] == 'In Process')
                                                        <a href="delete-entry/{{ $val['Script'] }}/{{ $val['Order'] }}"
                                                            onclick="return confirm('Are You sure Want to Delete {{ $val['Script'] }}')"><i
                                                                class="bi bi-trash"></i></a>
                                                    @endif
                                                </td>
                                                <!-- Script Link for Chart View -->

                                            </tr>
                                        @endif
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
                    [1, 'desc']
                ]
            });
        });
        
        @if (Session::has('alert'))
            $(document).ready(function() {
                var alertMessage = '{{ Session::get('alert') }}';
                alert(alertMessage);
                {{ Session::forget('alert') }}
            });
        @endif
    </Script>
@endpush
