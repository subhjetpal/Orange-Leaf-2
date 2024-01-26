@extends('home.dashboard')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Add Entry</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active"><a href="add-entry.php" class="active">Add Entry</a></li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->
        <!-- Risk Analyze Form -->
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Add Entry</h5>
                            <form action="{{ url('/add-entry') }}" method="POST" name="entry_form"
                                onsubmit="return confirm('Are you want to submit')" enctype="multipart/form-data">
                                @csrf
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="Trade" class="form-label">Trade *</label>
                                            <select name="Trade" class="form-select" id="Trade" required>
                                                <option value="" default>Select</option>
                                                <option value="Intraday">Intraday</option>
                                                <option value="Swing">Swing</option>
                                                <option value="Positional">Positional</option>
                                                <option value="Dividend">Dividend</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Type" class="form-label">Instrument Type *</label>
                                            <select name="Type" class="form-select" id="Type" required>
                                                <option value="" default>Select</option>
                                                <option value="Equity">Equity</option>
                                                <option value="Commodity">Commodity</option>
                                                <option value="Options">Options</option>
                                                <option value="Futures" disabled>Futures</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Order" class="form-label">Order *</label>
                                            <select name="Order" class="form-select" id="Order" required>
                                                <option value="" default>Select</option>
                                                <option value="In Process" id="In_Process">In Process</option>
                                                <option value="Open" id="Open">Open</option>
                                                <option value="Buy">Buy</option>
                                                <option value="Short">Short</option>
                                                <option value="Exit" id="Exit_O">Exit</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Date" class="form-label">Date</label>
                                            <input type="date" name="Date" value="" class="form-control"
                                                id="Date">
                                        </div>

                                    </div>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="Chart" class="form-label">Chart *</label>
                                            <select name="Chart" class="form-select" id="Chart" required>
                                                <option value="Daily" default>Daily</option>
                                                <option value="3 min">3 min</option>
                                                <option value="5 min">5 min</option>
                                                <option value="15 min">15 min</option>
                                                <option value="75 min">75 min</option>
                                                <option value="1 Hour">1 Hour</option>
                                                <option value="Weekly">Weekly</option>
                                                <option value="Monthly">Monthly</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Script" class="form-label">Script *</label>
                                            <input type="name" name="Script" value="" class="form-control"
                                                id="Script" autocomplete="off" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="System" class="form-label">System *</label>
                                            <select name="System" class="form-select" id="System" required>
                                                <option value="44 MA" default>44 MA</option>
                                                <option value="30 MA">30 MA</option>
                                                <option value="ABC">ABC</option>
                                                <option value="ABC4">ABC4</option>
                                                <option value="ATH">ATH</option>
                                                <option value="ASIANPAINTS">ASIANPAINTS</option>
                                                <option value="Trend Line">Trend Line</option>
                                                <option value="Double Bottom">Double Btm</option>
                                                <option value="R62">R62</option>
                                                <option value="Squeeze">Squeeze</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="Entry" class="form-label">Entry *</label>
                                            <input type="number" name="Entry" value=""
                                                class="form-control candle" id="Entry" step=".01" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Stop_Loss" class="form-label">StopLoss *</label>
                                            <input type="number" name="Stop_Loss" value=""
                                                class="form-control candle" id="Stop_Loss" step=".01" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Target1_2" class="form-label">Taregt 1:2</label>
                                            <input type="number" name="Target1_2" value="0" step=".01"
                                                class="form-control" id="Target1_2">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Target1_3" class="form-label">Target 1:3</label>
                                            <input type="number" name="Target1_3" value="0" step=".01"
                                                class="form-control" id="Target1_3">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="Exit" class="form-label">Exit </label>
                                            <input type="number" name="Exit" value="0" step=".01"
                                                class="form-control" id="Exit">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Quantity" class="form-label">Quantity *</label>
                                            <input type="number" name="Quantity" value="" class="form-control"
                                                id="Quantity" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Candle" class="form-label">Candle%</label>
                                            <input type="number" name="Candle" value="" step=".01"
                                                class="form-control" id="Candle" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Risk" class="form-label">Risk *</label>
                                            <input type="number" name="Risk" value="" step=".01"
                                                class="form-control" id="Risk" readonly>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fileToUpload" class="form-label">Trade Image</label>
                                            <input type="file" name="fileToUpload" class="form-control"
                                                id="fileToUpload">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Charges" class="form-label">Charges *</label>
                                            <input type="number" name="Charges" value="20" step=".01"
                                                class="form-control" id="Charges">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Others" class="form-label">Other Charges</label>
                                            <input type="number" name="Others" value="0" step=".01"
                                                class="form-control" id="Others">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" name="entry_submit"
                                        id="entry_submit">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
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
        // calculate Candle % on Entry and Stoploss value entry
        $(function() {
            var Percent = 0.00;
            $(".candle").change(function() {
                var Entry = $("#Entry").val();
                var Stop_Loss = $("#Stop_Loss").val();
                // var Trade = $("#Trade").val();
                // var Order = $("#Order").val();

                // Percent = Order=='Short'?(Stop_Loss - Entry):(Entry - Stop_Loss);
                Percent = (Entry - Stop_Loss);
                Percent = Percent < 0 ? Percent * -1 : Percent;
                var Candle = (Percent * 100) / Entry;
                var Quantity = $("#Quantity").val();
                var Risk = Percent * Quantity;

                $("#Candle").val(Candle.toFixed(2));
                $("#Risk").val(Risk.toFixed(2));
            });
            $("#Quantity").change(function() {
                var Quantity = $("#Quantity").val();

                var Risk = Percent * Quantity;
                $("#Risk").val(Risk.toFixed(2));
            });
            $("#Order").change(function() {
                var Order = $(this).val();
                if (Order == 'In Process') {
                    $("#Date").prop('disabled', true);
                    $("#fileToUpload").prop('disabled', true);
                    $("#Exit").prop('disabled', true);
                } else if (Order == 'Open') {
                    $("#fileToUpload").prop('disabled', false);
                    $("#Date").prop('disabled', false);
                    $("#Exit").prop('disabled', true);
                } else {
                    $("#Date").prop('disabled', false);
                    $("#Exit").prop('disabled', false);
                }
            });
            $("#Trade").change(function() {
                var Trade = $(this).val();
                if (Trade == 'Positional') {
                    $("#In_Process").prop('disabled', false);
                    $("#Order").prop('disabled', false);
                    $("#System").prop('disabled', false);
                    $("#Entry").prop('readonly', false);
                    $("#Chart").prop('disabled', false);
                    $("#Stop_Loss").prop('readonly', false);
                    $("#Target1_2").prop('readonly', true);
                    $("#Target1_3").prop('readonly', true);
                    $("#Risk").prop('disabled', false);
                    $("#fileToUpload").prop('disabled', true);
                } else if (Trade == 'Dividend') {
                    $("#Order").prop('disabled', true);
                    $("#Type").prop('disabled', false);
                    $("#System").prop('disabled', true);
                    $("#Entry").prop('readonly', true);
                    $("#Chart").prop('disabled', true);
                    $("#Stop_Loss").prop('readonly', true);
                    $("#Target1_2").prop('readonly', true);
                    $("#Target1_3").prop('readonly', true);
                    $("#Risk").prop('disabled', true);
                    $("#fileToUpload").prop('disabled', true);
                } else if (Trade == 'Intraday') {
                    $("#fileToUpload").prop('disabled', false);
                    $("#In_Process").prop('disabled', true);
                    $("#Exit").prop('disabled', false);
                    $("#Exit_O").prop('disabled', true);
                } else {
                    $("#In_Process").prop('disabled', false);
                    $("#Order").prop('disabled', false);
                    $("#Type").prop('disabled', false);
                    $("#System").prop('disabled', false);
                    $("#Entry").prop('readonly', false);
                    $("#Chart").prop('disabled', false);
                    $("#Stop_Loss").prop('readonly', false);
                    $("#Target1_2").prop('readonly', false);
                    $("#Target1_3").prop('readonly', false);
                    $("#Risk").prop('disabled', false);
                    $("#In_Process").prop('disabled', false);
                    $("#Exit").prop('disabled', true);
                    $("#fileToUpload").prop('disabled', true);
                }
            });
            $("#Type").change(function() {
                var Type = $(this).val();
                var Trade = $("#Trade").val();
                if (Type == 'Commodity' || Type == 'Options' || (Type == 'Equity' && Trade == 'Intraday')) {
                    $("#Charges").prop('disabled', false);
                } else {
                    $("#Charges").prop('disabled', true);
                }
            });
        });
    </script>
@endsection
