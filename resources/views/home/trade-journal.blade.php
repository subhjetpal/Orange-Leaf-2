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
        <section class="section">
            <div class="row">
                {{-- <form action="" method="POST" name="date_select">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-7"></div>
              <div class="col-sm-2">
                <label for="StartDate" class="form-label">Start Date</label>
                <input type="date" name="StartDate" value="{{ (!empty($_POST['StartDate'])) ? $_POST['StartDate'] : date('Y') . "-" . str_pad(ceil(date('m', time()) / 3), 2, '0', STR_PAD_LEFT) . "-01"}}" class="form-date" id="StartDate">
              </div>
              <div class="col-sm-2">
                <label for="EndDate" class="form-label">End Date</label>
                <input type="date" name="EndDate" value="{{ (!empty($_POST['EndDate'])) ? $_POST['EndDate'] : date('Y-m-d')}}" class="form-date" id="EndDate">
                <div class="invalid-feedback" id="EndDateValid" style="font-size: 10px">End Date Can't Less than Start Date</div>
              </div>
              <div class="col-1">
                <label for="DateSelect" class="form-label"></label>
                <button type="submit" class="btn btn-primary" name="DateSelect" id="DateSelect">Submit</button>
              </div>
            </div>
          </div>
        </form> --}}
            </div>
        </section>
        </br>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <!-- <h5 class="card-title">Today's Cryptocurrency Prices by Market Cap</h5>
                  <p>The global cryptocurrency market cap today is $1.95 Trillion, a 0.2% change in the last 24 hours</p> -->

                            <!-- Table with stripped rows -->
                            <table class="table datatable" id="TradeTable">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
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
@endsection
