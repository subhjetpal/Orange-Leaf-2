@extends('home.dashboard')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Trade Journal</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <!--<li class="breadcrumb-item">Search</li> -->
                    <li class="breadcrumb-item "><a href="trade-journal" class="active">Trade Journal</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <br />
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Today's Cryptocurrency Prices by Market Cap</h5>
                      <p>The global cryptocurrency market cap today is $1.95 Trillion, a 0.2% change in the last 24 hours</p> -->

                            <!-- Table with stripped rows -->
                            <table class="table" id="DataTable">
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
                                                    <a href="delete-entry.php/{{ $val['Script'] }}"
                                                        onclick="return confirm('Are You sure Want to Delete {{ $val['Script'] }}')"><i
                                                            class="bi bi-trash"></i></a>
                                                @endif
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        @if (Session::has('alert'))
            $(document).ready(function() {
                var alertMessage = '{{ Session::get('alert') }}';
                alert(alertMessage);
                {{ Session::forget('alert') }}
            });
        @endif
    </Script>
@endsection
