@extends('site-layout')

@section('content')
    <main style="background-color: #2e4052;">
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('img/orange_leaf_mid.png') }}" alt="Orange Leaf">
                                    <!-- <img src="assets/img/logo.png" alt="">
                              <span class="d-none d-lg-block">Orange Leaf</span> -->
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                                        <p class="text-center small">Enter your username & password to login</p>
                                    </div>

                                    <form action="" class="row g-3 needs-validation" method="POST" novalidate>
                                        <div class="col-12">
                                            @if (session('alert'))
                                                <div class="alert alert-success">
                                                    {{ session('alert') }}
                                                </div>
                                            @endif
                                        </div>
                                        @csrf
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="username" class="form-control" id="yourUsername"
                                                    required>
                                                <div class="invalid-feedback">Please enter your username.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <input type="password" name="password" class="form-control"
                                                    id="yourPassword" required>
                                                <div class="invalid-feedback">Please enter your password!</div>
                                                <span class="input-group-text" id="inputpass" type="button"><i
                                                        class="bi bi-eye-fill" style="font-size: 20px;"></i></span>
                                            </div>
                                        </div>

                                        <!-- <div class="col-12">
                                  <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                  </div>
                                </div> -->
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit"
                                                name="login">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <!-- <p class="small mb-0">Don't have account? <a href="register.php">Create an account </a></p> -->
                                        </div>
                                        <!-- <div class="col-12">
                                  <p class="small mb-0">Can't Remember my password <a href="reset.php">Forget Password? </a></p>
                                </div> -->
                                    </form>

                                </div>
                            </div>

                            <div class="credits" style="color:#a9a9a9">
                                Designed by <a href="#">Webcodder</a>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        // calculate Candle % on Entry and Stoploss value entry
        $(function() {
            $("#inputpass").click(function() {
                var passInput = $("#yourPassword");
                if (passInput.attr('type') === 'password') {
                    passInput.attr('type', 'text');
                } else {
                    passInput.attr('type', 'password');
                }
            });
        });
    </script>
@endsection
