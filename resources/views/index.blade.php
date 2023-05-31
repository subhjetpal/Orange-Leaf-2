@extends('site-layout')

@section('content')
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up">
                    <div>
                        <img src="{{ asset('img/orange_leaf_icon.png') }}" alt="">
                        <h1>Orange Leaf - Be the Change</h1>
                        <h2></h2>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img"
                    data-aos="fade-up">
                    <img src="{{ asset('img/details-1.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section>
    <main id="main">

        <!-- ======= App Features Section ======= -->
        <!-- <section id="features" class="features">
              <div class="container">

                <div class="section-title">
                  <h2>App Features</h2>
                  <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="row no-gutters">
                  <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
                    <div class="content d-flex flex-column justify-content-center">
                      <div class="row">
                        <div class="col-md-6 icon-box" data-aos="fade-up">
                          <i class="bx bx-receipt"></i>
                          <h4>Corporis voluptates sit</h4>
                          <p>Consequuntur sunt aut quasi enim aliquam quae harum pariatur laboris nisi ut aliquip</p>
                        </div>
                        <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                          <i class="bx bx-cube-alt"></i>
                          <h4>Ullamco laboris nisi</h4>
                          <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt</p>
                        </div>
                        <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                          <i class="bx bx-images"></i>
                          <h4>Labore consequatur</h4>
                          <p>Aut suscipit aut cum nemo deleniti aut omnis. Doloribus ut maiores omnis facere</p>
                        </div>
                        <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                          <i class="bx bx-shield"></i>
                          <h4>Beatae veritatis</h4>
                          <p>Expedita veritatis consequuntur nihil tempore laudantium vitae denat pacta</p>
                        </div>
                        <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                          <i class="bx bx-atom"></i>
                          <h4>Molestiae dolor</h4>
                          <p>Et fuga et deserunt et enim. Dolorem architecto ratione tensa raptor marte</p>
                        </div>
                        <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                          <i class="bx bx-id-card"></i>
                          <h4>Explicabo consectetur</h4>
                          <p>Est autem dicta beatae suscipit. Sint veritatis et sit quasi ab aut inventore</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                    <img src="index/assets/img/features.svg" class="img-fluid" alt="">
                  </div>
                </div>

              </div>
            </section> -->
        <!-- End App Features Section -->

        <!-- ======= Details Section ======= -->
        <!-- <section id="details" class="details">
              <div class="container">

                <div class="row content">
                  <div class="col-md-4" data-aos="fade-right">
                    <img src="index/assets/img/details-1.png" class="img-fluid" alt="">
                  </div>
                  <div class="col-md-8 pt-4" data-aos="fade-up">
                    <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
                    <p class="fst-italic">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                      magna aliqua.
                    </p>
                    <ul>
                      <li><i class="bi bi-check"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                      <li><i class="bi bi-check"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                      <li><i class="bi bi-check"></i> Iure at voluptas aspernatur dignissimos doloribus repudiandae.</li>
                      <li><i class="bi bi-check"></i> Est ipsa assumenda id facilis nesciunt placeat sed doloribus praesentium.</li>
                    </ul>
                    <p>
                      Voluptas nisi in quia excepturi nihil voluptas nam et ut. Expedita omnis eum consequatur non. Sed in asperiores aut repellendus. Error quisquam ab maiores. Quibusdam sit in officia
                    </p>
                  </div>
                </div>

                <div class="row content">
                  <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="index/assets/img/details-2.png" class="img-fluid" alt="">
                  </div>
                  <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                    <h3>Corporis temporibus maiores provident</h3>
                    <p class="fst-italic">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                      magna aliqua.
                    </p>
                    <p>
                      Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                      velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                      culpa qui officia deserunt mollit anim id est laborum
                    </p>
                    <p>
                      Inventore id enim dolor dicta qui et magni molestiae. Mollitia optio officia illum ut cupiditate eos autem. Soluta dolorum repellendus repellat amet autem rerum illum in. Quibusdam occaecati est nisi esse. Saepe aut dignissimos distinctio id enim.
                    </p>
                  </div>
                </div>

                <div class="row content">
                  <div class="col-md-4" data-aos="fade-right">
                    <img src="index/assets/img/details-3.png" class="img-fluid" alt="">
                  </div>
                  <div class="col-md-8 pt-5" data-aos="fade-up">
                    <h3>Sunt consequatur ad ut est nulla consectetur reiciendis animi voluptas</h3>
                    <p>Cupiditate placeat cupiditate placeat est ipsam culpa. Delectus quia minima quod. Sunt saepe odit aut quia voluptatem hic voluptas dolor doloremque.</p>
                    <ul>
                      <li><i class="bi bi-check"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat.</li>
                      <li><i class="bi bi-check"></i> Duis aute irure dolor in reprehenderit in voluptate velit.</li>
                      <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.</li>
                    </ul>
                    <p>
                      Qui consequatur temporibus. Enim et corporis sit sunt harum praesentium suscipit ut voluptatem. Et nihil magni debitis consequatur est.
                    </p>
                    <p>
                      Suscipit enim et. Ut optio esse quidem quam reiciendis esse odit excepturi. Vel dolores rerum soluta explicabo vel fugiat eum non.
                    </p>
                  </div>
                </div>

                <div class="row content">
                  <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                    <img src="index/assets/img/details-4.png" class="img-fluid" alt="">
                  </div>
                  <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                    <h3>Quas et necessitatibus eaque impedit ipsum animi consequatur incidunt in</h3>
                    <p class="fst-italic">
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                      magna aliqua.
                    </p>
                    <p>
                      Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
                      velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
                      culpa qui officia deserunt mollit anim id est laborum
                    </p>
                    <ul>
                      <li><i class="bi bi-check"></i> Et praesentium laboriosam architecto nam .</li>
                      <li><i class="bi bi-check"></i> Eius et voluptate. Enim earum tempore aliquid. Nobis et sunt consequatur. Aut repellat in numquam velit quo dignissimos et.</li>
                      <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.</li>
                    </ul>
                  </div>
                </div>

              </div>
            </section> -->
        <!-- End Details Section -->

        <!-- ======= Coin Section ======= -->
        <!-- <section id="gallery" class="gallery">
              <div class="container" data-aos="fade-up">

                <div class="section-title">
                  <h2>Crypto</h2>
                  <p></p>
                </div>

              </div>

              <div class="container-fluid" data-aos="fade-up">
                <div class="gallery-slider swiper">
                  <div class="swiper-wrapper">
                    
                    
                  </div>
                  <div class="swiper-pagination"></div>
                </div>

              </div>
            </section> -->
        <!-- End Gallery Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <!-- <section id="faq" class="faq section-bg">
              <div class="container" data-aos="fade-up">

                <div class="section-title">

                  <h2>Frequently Asked Questions</h2>
                  <p></p>
                </div>

                <div class="accordion-list">
                  <ul>
                    <li data-aos="fade-up">
                      <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1">What is cryptocurrency?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                      <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                        <p>
                          Refers to a digital currency, secured with cryptography to enable trusted transactions. Blockchain is the underlying technology, functioning as a ‘ledger’ or record of transactions made.
                        </p>
                      </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="100">
                      <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed">How is crypto stored?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                      <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                        <p>
                          Let’s look at a national currency like the rupee. It can be deposited in your name at a bank, or privately stuffed into a mattress at home far away from anyone’s eyes.
                          Similarly, a cryptocurrency can be held on your behalf by a company, usually in your wallet at a crypto exchange online. You could also hold it in without being affiliated to anybody, in a private cryptocurrency wallet.
                        </p>
                      </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="200">
                      <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed">What is the purpose of cryptocurrency?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                      <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                        <p>
                          As indicated by ‘currency’, they were originally intended to be used in the same way as rupees and dollars are, as a medium of payment between people for products and services purchased.
                        </p>
                      </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="300">
                      <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-4" class="collapsed">How does supply and demand work in the cryptocurrency market?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                      <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
                        <p>
                          Some cryptocurrencies like Bitcoin and Ether are designed to have a limited supply. By comparison, real-world currencies like the US Dollar do not have a hard limit on supply. When demand increases, the value of a supply-limited item is expected to increase.
                          That difference in supply, a high demand for crypto and new ways to profit from rising crypto, have led to a self-perpetuating cycle that drives up the exchange value of major cryptocurrencies.
                        </p>
                      </div>
                    </li>

                    <li data-aos="fade-up" data-aos-delay="400">
                      <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-5" class="collapsed">How to trade in cryptocurrencies in a safe way?<i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                      <div id="accordion-list-5" class="collapse" data-bs-parent=".accordion-list">
                        <p>
                          For beginners in the crypto market, experts advise investing only as much money as you’re willing to lose. The reason is, crypto trading marries the ‘irrational exuberance potential’ of a conventional stock market to the regulatory uncertainty of crypto.
                        </p>
                      </div>
                    </li>

                  </ul>
                </div>

              </div>
            </section> -->
        <!-- End Frequently Asked Questions Section -->

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
    </script>
@endsection
