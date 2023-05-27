@extends('home.dashboard')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Trade Calculator</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="calculator.php" class="active">calculator</a></li>
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
                        <h5 class="card-title">Swing</h5>
                        <div class="col-12">
                            <label for="risk" class="form-label">Risk Amount</label>
                            <input type="number" name="risk" value="500" class="form-control" id="risk" required>
                        </div>
                        <div class="col-12">
                            <label for="entry" class="form-label">Entry</label>
                            <input type="number" name="entry" value="" class="form-control" id="entry" required>
                        </div>
                        <div class="col-12">
                            <label for="stoploss" class="form-label">Stop Loss</label>
                            <input type="number" name="stoploss" value="" class="form-control" id="stoploss" required>
                        </div>
                        <div class="col-12">
                            <label for="candle" class="form-label">Candle %</label>
                            <input type="number" name="candle" class="form-control" id="candle" disabled>
                        </div>
                        <div class="col-12">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" name="Quantity" class="form-control" id="quantity" disabled>
                        </div>
                        <div class="col-12">
                            <label for="target1_2" class="form-label">Target 1:2</label>
                            <input type="number" name="target1_2" class="form-control" id="target1_2" disabled>
                        </div>
                        <div class="col-12">
                            <label for="target1_3" class="form-label">Target 1:3</label>
                            <input type="number" name="target1_2" class="form-control" id="target1_3" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script>
    $(function() {
        $(".form-control").change(function() {
            var Risk = $("#risk").val();
            var Entry = $("#entry").val();
            var StopLoss = $("#stoploss").val();

            var Diff = parseFloat(Entry - StopLoss);
            var Candle = parseFloat(Diff) * 100 / Entry;
            $("#candle").val(Candle.toFixed(2));

            var Quantity = Risk / parseFloat(Diff);
            $("#quantity").val(Quantity.toFixed(2));

            var Target1_2 = parseFloat(Entry) + parseFloat(Diff * 2);
            $("#target1_2").val(Target1_2.toFixed(2));

            var Target1_3 = parseFloat(Entry) + parseFloat(Diff * 3)
            $("#target1_3").val(Target1_3.toFixed(2));
        });
        $("#EndDate").change(function() {
            var EndDate = $(this).val();
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