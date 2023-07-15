@extends('home.dashboard')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Add Journal</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ url('/add-Journal') }}" class="active">Add Journal</a></li>
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
                            <h5 class="card-title">Add Journal</h5>
                            <form action="" method="POST" name="journal_form"
                                onsubmit="return confirm('Are you want to submit')">
                                @csrf
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="Account_Debit" class="form-label">Select Debit Account *</label>
                                            <select name="Account_Debit" class="form-select" id="Account_Debit" required>
                                                <option value="" default>Select</option>
                                                <option value="CASH">CASH</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Receivables">Receivables</option>
                                                <option value="Inventories">Inventories</option>
                                                <option value="Prepaid Expances">Prepaid Expances</option>
                                                <option value="Investment">Investment</option>
                                                <option value="Equipment">Equipment</option>
                                                <option value="Liability">Liability</option>
                                                <option value="Payable">Payable</option>
                                                <option value="Term Debt">Term Debt</option>
                                                <option value="Deferred Revenue">Deferred Revenue</option>
                                                <option value="Equity">Equity</option>
                                                <option value="Revenue">Revenue</option>
                                                <option value="Expances">Expances</option>
                                                <option value="Drawings">Drawings</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Account_Credit" class="form-label">Select Credit Account *</label>
                                            <select name="Account_Credit" class="form-select" id="Account_Credit" required>
                                                <option value="" default>Select</option>
                                                <option value="CASH">CASH</option>
                                                <option value="Bank">Bank</option>
                                                <option value="Receivables">Receivables</option>
                                                <option value="Inventories">Inventories</option>
                                                <option value="Prepaid Expances">Prepaid Expances</option>
                                                <option value="Investment">Investment</option>
                                                <option value="Equipment">Equipment</option>
                                                <option value="Liability">Liability</option>
                                                <option value="Payable">Payable</option>
                                                <option value="Term Debt">Term Debt</option>
                                                <option value="Deferred Revenue">Deferred Revenue</option>
                                                <option value="Equity">Equity</option>
                                                <option value="Revenue">Revenue</option>
                                                <option value="Expances">Expances</option>
                                                <option value="Drawings">Drawings</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="Amount" class="form-label">Amount *</label>
                                            <input type="number" name="Amount" value="0" class="form-control"
                                                id="Amount" step=".01" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="Date" class="form-label">Date *</label>
                                            <input type="date" name="Date" value="" class="form-control"
                                                id="Date" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="Comments" class="form-label">Comment *</label>
                                            <input type="text" name="Comments" value=""
                                                class="form-control" id="Comments" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" name="journal_submit"
                                        id="journal_submit">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@push('script')
<script>
    @if (Session::has('alert'))
        $(document).ready(function() {
            var alertMessage = '{{ Session::get('alert') }}';
            alert(alertMessage);
            {{ Session::forget('alert') }}
        });
    @endif
</script>
@endpush
