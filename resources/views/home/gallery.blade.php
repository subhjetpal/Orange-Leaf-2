@extends('home.dashboard')

@section('content')
    <main id="main" class="main">
        <!-- Reports -->
        <div class="col-12">
            <div class="card">

                {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>

                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                </div> --}}

                <div class="card-body">
                    <h5 class="card-title">Gallery</h5>
                    <img style="width: 900px;height: 478px;overflow: hidden; float: left;display:inline-block;vertical-align:middle;"
                                                src="{{ asset('images/1_lac_club.png') }}" alt="profile"
                                                onerror="this.src='{{ asset('images/profile.png') }}';">

                </div>

            </div>
        </div><!-- End Reports -->
    </main>
@endsection
