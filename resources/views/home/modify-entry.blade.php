@extends('home.dashboard')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Modify Entry</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active"><a href="modify-entry" class="active">Modify Entry</a></li>
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
                            <h5 class="card-title">Modify Entry</h5>
                            <form action="{{ url('/modify-entry') }}" method="POST" name="quantity_calc"
                                enctype='multipart/form-data'>
                                @csrf
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="Trade" class="form-label">Trade *</label>
                                            <select name="Trade" class="form-select" id="Trade" required>
                                                <option value="{{ $val['Trade'] }}" default>{{ $val['Trade'] }}</option>
                                                <option value="Swing" default>Swing</option>
                                                <option value="Positional">Positional</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Order" class="form-label">Order *</label>
                                            <select name="Order" class="form-select" id="Order" required>
                                                <option value="{{ $val['Order'] }}" default>{{ $val['Order'] }}</option>
                                                <!-- <option value="In Process">In Process</option> -->
                                                @if ($TradeID == 'NULL')
                                                    <option value="Open"
                                                        @if ($val['Order'] != 'In Process') {{ 'disabled' }} @endif>Open
                                                    </option>
                                                    <option value="Exit"
                                                        @if ($val['Order'] != 'Open') {{ 'disabled' }} @endif>Exit
                                                    </option>
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Date" class="form-label">Date *</label>
                                            <input type="date" name="Date"
                                                value="@if ($TradeID != 'NULL') {{ $val['Date'] }} @endif"
                                                class="form-control" id="Date" required>
                                            {{-- <input type="date" name="Date" value="{{ date("Y-m-d", strtotime($val['Date']))}}" class="form-control" id="Date" required> --}}
                                        </div>

                                    </div>
                                </div>
                                </br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="Chart" class="form-label">Chart *</label>
                                            <select name="Chart" class="form-select" id="Chart" required>
                                                <option value="{{ $val['Chart'] }}" default>{{ $val['Chart'] }}</option>
                                                <option value="Daily">Daily</option>
                                                <option value="Weekly">Weekly</option>
                                                <option value="Monthly">Monthly</option>
                                                <option value="1 Hour">1 Hour</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Script" class="form-label">Script *</label>
                                            <input type="name" name="Script" value="{{ $val['Script'] }}"
                                                class="form-control" id="Script" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="System" class="form-label">System *</label>
                                            <select name="System" class="form-select" id="System" required>
                                                <option value="{{ $val['System'] }}" default>{{ $val['System'] }}</option>
                                                <option value="44 MA">44 MA</option>
                                                <option value="44 MA">30 MA</option>
                                                <option value="ABC">ABC</option>
                                                <option value="ATH">ATH</option>
                                                <option value="ASIANPAINTS">ASIANPAINTS</option>
                                                <option value="Triangle Break">Triangle Break</option>
                                                <option value="Double Bottom">Double Btm</option>
                                                <option value="Bear Trap">Bear Trap</option>
                                                <option value="Bull Trap">Bull Trap</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                </br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="Entry" class="form-label">Entry *</label>
                                            <input type="number" name="Entry" value="{{ $Entry }}"
                                                class="form-control candle" id="Entry" step=".01" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Stop_Loss" class="form-label">StopLoss *</label>
                                            <input type="number" name="Stop_Loss" value="{{ $val['Stop_Loss'] }}"
                                                class="form-control candle" id="Stop_Loss" step=".01" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Target1_2" class="form-label">Taregt 1:2</label>
                                            <input type="number" name="Target1_2" value="{{ $val['Target1_2'] }}"
                                                class="form-control" id="Target1_2" step=".01">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Target1_3" class="form-label">Target 1:3</label>
                                            <input type="number" name="Target1_3" value="{{ $val['Target1_3'] }}"
                                                class="form-control" id="Target1_3" step=".01">
                                        </div>
                                    </div>
                                </div>
                                </br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label for="Exit" class="form-label">Exit </label>
                                            <input type="number" name="Exit" value="{{ $val['Exit'] }}"
                                                class="form-control" id="Exit" step=".01">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Quantity" class="form-label">Quantity *</label>
                                            <input type="number" name="Quantity" value="{{ $val['Quantity'] }}"
                                                class="form-control" id="Quantity" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Candle" class="form-label">Candle% *</label>
                                            <input type="number" name="Candle" value="{{ $val['Candle'] }}"
                                                class="form-control" id="Candle" readonly step=".01">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Risk" class="form-label">Risk *</label>
                                            <input type="number" name="Risk" value="{{ $val['Risk'] }}"
                                                class="form-control" id="Risk" readonly step=".01">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="fileToUpload" class="form-label">Trade Image </label>
                                            <input type="file" name="fileToUpload" class="form-control"
                                                id="fileToUpload" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" name="TradeID" value="{{ $TradeID }}"
                                                class="form-control" id="TradeID">
                                        </div>
                                    </div>
                                </div>
                                </br>
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
        $(function() {
            $(document).ready(function() {
                $("#Script").prop('readonly', true);
                var Order = $("#Order").val();
                if (Order == 'Open') {
                    $("#Exit").prop('readonly', true);
                } else if (Order == 'Exit') {
                    $("#Entry").prop('readonly', true);
                    $("#Stop_Loss").prop('readonly', true);
                    $("#Target1_2").prop('readonly', true);
                    $("#Target1_3").prop('readonly', true);
                } else {
                    $("#Exit").prop('readonly', false);
                    $("#Entry").prop('readonly', false);
                    $("#Stop_Loss").prop('readonly', false);
                    $("#Target1_2").prop('readonly', false);
                    $("#Target1_3").prop('readonly', false);
                }
            });
            @if ($TradeID == 'NULL')
                $(document).ready(function() {
                    $("#entry_submit").prop('disabled', true);
                });
                $("#Order").change(function() {
                    var Order = $(this).val();
                    if (Order == 'Open') {
                        $("#Exit").prop('readonly', true);
                        $("#entry_submit").prop('disabled', false);
                    } else if (Order == 'Exit') {
                        $("#Exit").prop('readonly', false);
                        $("#Entry").prop('readonly', true);
                        $("#Stop_Loss").prop('readonly', true);
                        $("#Target1_2").prop('readonly', true);
                        $("#Target1_3").prop('readonly', true);
                        $("#entry_submit").prop('disabled', false);
                    } else {
                        $("#Exit").prop('readonly', false);
                        $("#Entry").prop('readonly', false);
                        $("#Stop_Loss").prop('readonly', false);
                        $("#Target1_2").prop('readonly', false);
                        $("#Target1_3").prop('readonly', false);
                        $("#entry_submit").prop('disabled', true);
                    }
                });
            @endif

            $(".candle").change(function() {
                var Entry = $("#Entry").val();
                var Stop_Loss = $("#Stop_Loss").val();
                var Candle = (Entry - Stop_Loss) * 100 / Entry;
                var Quantity = $("#Quantity").val();
                var Risk = (Entry - Stop_Loss) * Quantity;
                $("#Candle").val(Candle.toFixed(2));
                $("#Risk").val(Risk);
            });
            $("#Quantity").change(function() {
                var Entry = $("#Entry").val();
                var Stop_Loss = $("#Stop_Loss").val();
                var Quantity = $("#Quantity").val();
                var Risk = (Entry - Stop_Loss) * Quantity;
                $("#Risk").val(Risk);
            });

        });
        // if In Process the Order should Only have option 'Open'
        // for 'Open' select which values can't modify made read only. and disbale which not required

        // if Open the Order should Only have option 'Exit'
        // for 'Exit' select which values can't modify made read only. and disbale which not required
    </script>
@endsection
