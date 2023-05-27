@extends('home.dashboard')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Trade Summary</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Home</a></li>
                <!--<li class="breadcrumb-item">Search</li> -->
                <li class="breadcrumb-item "><a href="trade-summary" class="active">Trade Summary</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            {{-- <form action="" method="POST" name="date_select" class="date">
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
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Trade</th>
                                    <th scope="col">Transact</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Script</th>
                                    <th scope="col">Entry</th>
                                    <th scope="col">Exit</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Percent</th>
                                    <th scope="col">Profit_Loss</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- render tr -->
                                @foreach ($trade as $val)
                                    <tr>
                                        <td>{{ $val['Trade']}}</td>
                                        <td>{{ $val['Transact']}}</td>
                                        <td>{{ $val['Date']}}</td>
                                        <td>{{ $val['Script']}}</td>
                                        <td>{{ $val['Entry']}}</td>
                                        <td>{{ $val['Exit']}}</td>
                                        <td>{{ $val['Quantity']}}</td>
                                        <td>{{ $val['Percent']}}</td>
                                        <td>{{ $val['Profit_Loss']}}</td>
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
</main>
@endsection