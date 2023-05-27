@extends('home.dashboard')

@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Performance</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="home">Home</a></li>
                    <li class="breadcrumb-item active"><a href="Performance" class="active">Performance</a></li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard faq">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-12">
                    <div class="row">

                        <!-- Risk Type -->
                        <!-- <div class="col-lg-6">
                  <div class="card info-card sales-card">

                    <div class="card-body">
                      <h5 class="card-title">Dashboard</h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-window"></i>
                        </div>
                        <div class="ps-3">
                          <a href="#riskSummary">
                            <h6><?php // echo $myusername;
                            ?></h6>
                          </a>
                        </div>
                      </div>
                    </div>

                  </div>
                </div> -->
                        <!-- End Risk Type -->

                        <!-- Suggestion Card -->
                        <!-- <div class="col-lg-6">
                  <div class="card info-card revenue-card">

                    <div class="card-body">
                      <h5 class="card-title">Dashboard</h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-search"></i>
                        </div>
                        <div class="ps-3">
                          <a href="#suggest">
                            <h6>0</h6>
                          </a>
                        </div>
                      </div>
                    </div>

                  </div>
                </div> -->
                        <!-- End Revenue Card -->

                        <!-- Reports -->
                        <div class="col-lg-12">

                            <div class="card">
                                <div class="card-body" id="overview" style="padding: 0px">
                                    <iframe width="100%"
                                        src="https://lookerstudio.google.com/embed/reporting/629aa096-a694-4323-9ad8-cd618690126e/page/p_bhj3ehsd4c"
                                        frameborder="0" style="border:0"></iframe>
                                </div>
                            </div>

                        </div>
                        <!-- Risk Summary-->
                        <!-- <div class="col-lg-12">
                  <div class="card basic">
                    <div class="card-body" id="riskSummary">
                      <h5 class="card-title">Dashboard</h5>

                    </div>
                  </div>
                </div> -->
                        <!-- End Risk Summary -->
                    </div>
                </div>
                <!-- End Left side columns -->

            </div>
        </section>

    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(function() {
            $(document).ready(function() {
                var width = $(overview).width();
                $('iframe').css('height', width / 2);
            });
        });
    </script>
@endsection
