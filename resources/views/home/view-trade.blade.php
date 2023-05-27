@extends('home.dashboard')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{ $val['Script']}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home">Home</a></li>
                <li class="breadcrumb-item">{{ $val['Date']}}</li>
                <li class="breadcrumb-item"><a href="" class="active">{{ $val['Script']}}</a></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile d-flex">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <!-- Summary -->
                    <div class="card">
                        <h5 class="card-title" style="padding-left:15px">Summary</h5>
                        <div class="card-body profile-overview pt-4 d-flex flex-column">
                            <div class="row">
                                <div class="col-md-4 label">Risk</div>
                                <div class="col-md-8">{{ $val['Risk']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label">Entry</div>
                                <div class="col-md-8">{{ $val['Entry']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label">StopLoss</div>
                                <div class="col-md-8">{{ $val['Stop_Loss']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label">Candle</div>
                                <div class="col-md-8">{{ $val['Candle'] . '%'}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label">Target 1:2</div>
                                <div class="col-md-8">{{ $val['Target1_2']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label">Target 1:3</div>
                                <div class="col-md-8">{{ $val['Target1_3']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label">Exit</div>
                                <div class="col-md-8">{{ $val['Exit']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 label">Quantity</div>
                                <div class="col-md-8">{{ $val['Quantity']}}</div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-8">

                    <div class="card">

                        <div class="card-body pt-3">
                            <!-- Bordered Tabs -->
                            <ul class="nav nav-tabs nav-tabs-bordered">

                                <li class="nav-item">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                                </li>

                                <!-- <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                            </li> -->
                            </ul>
                            <!-- Profile Overview -->
                            <div class="tab-content pt-2">
                                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                    <div class="row">
                                        <img style="width: 900px;height: 478px;overflow: hidden; float: left;display:inline-block;vertical-align:middle;" src="images/{{ $val['ImageURL']}}" alt="profile" onerror="this.src='images/profile.png';">
                                    </div>
                                </div>
                            </div><!-- End Bordered Tabs -->

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

</main>
@endsection