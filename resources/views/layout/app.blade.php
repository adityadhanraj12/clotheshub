<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> ClothesHub - Fashion Shop</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="robots" content="all,follow">
  <!-- Bootstrap CSS-->
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
  <!-- Font Awesome CSS-->
  <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
  <!-- Bootstrap Select-->
  <link rel="stylesheet" href="{{ asset('vendor/bootstrap-select/css/bootstrap-select.min.css') }}">
  <!-- Price Slider Stylesheets -->
  <link rel="stylesheet" href="{{ asset('vendor/nouislider/nouislider.css') }}">
  <!-- Custom font icons-->
  <link rel="stylesheet" href="{{ asset('css/custom-fonticons.css') }}">
  <!-- Google fonts - Poppins-->
  <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Poppins:300,400,500,700') }}">
  <!-- owl carousel-->
  <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.carousel.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/owl.carousel/assets/owl.theme.default.css') }}">
  <!-- theme stylesheet-->
  <link rel="stylesheet" href="{{ asset('css/style.default.css') }}" id="theme-stylesheet">
  <!-- Custom stylesheet - for your changes-->
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <!-- Favicon-->
  <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
  <!-- Modernizr-->
  <script src="{{ asset('js/modernizr.custom.79639.js') }}"></script>
</head>

<body>
  <!-- navbar-->
  <header class="header">
    <!-- Tob Bar-->
    <div class="top-bar">
      <div class="container-fluid">
        <div class="row d-flex align-items-center">
          <div class="col-lg-6 hidden-lg-down text-col">
            <ul class="list-inline">
              <li class="list-inline-item"><i class="icon-telephone"></i>+91 08765 43210</li>
              <li class="list-inline-item">Free shipping on orders over ₹300</li>
            </ul>
          </div>
          <div class="col-lg-6 d-flex justify-content-end">
          </div>
        </div>
      </div>
    </div>
    <nav class="navbar navbar-expand-lg">
      <div class="search-area">
        <div class="search-area-inner d-flex align-items-center justify-content-center">
          <div class="close-btn"><i class="icon-close"></i></div>

          <form action="{{ route('search') }}" method="GET">
            <div class="form-group">
              <input type="search" name="search" id="search" placeholder="What are you looking for?" required>

              <button type="submit" class="submit">
                <i class="icon-search"></i>
              </button>
            </div>
          </form>

        </div>
      </div>
      <div class="container-fluid">
        <!-- Navbar Header  --><a href="{{ route('index') }}" class="navbar-brand"><img
            src="{{ asset('img/logo.png') }}" alt="..."></a>
        <button type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse"
          aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i
            class="fa fa-bars"></i></button>
        <!-- Navbar Collapse -->
        <div id="navbarCollapse" class="collapse navbar-collapse">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item"><a href="{{ route('index') }}" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="{{ route('category') }}" class="nav-link">Shop</a></li>
            <!-- Megamenu-->
            <li class="nav-item dropdown menu-large"><a href="#" data-toggle="dropdown" class="nav-link">PAGES<i
                  class="fa fa-angle-down"></i></a>
              <div class="dropdown-menu megamenu">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="row">
                      <div class="col-lg-3"><strong class="text-uppercase">Home</strong>
                        <ul class="list-unstyled">
                          <li><a href="{{ route('index') }}">Homepage</a></li>
                        </ul>
                        @auth
                          <strong class="text-uppercase">Cart</strong>
                          <ul class="list-unstyled">
                            <li><a href="{{ route('cart') }}">Shopping cart</a></li>
                          </ul>
                        @endauth
                      </div>
                      <div class="col-lg-3"><strong class="text-uppercase">Shop</strong>
                        <ul class="list-unstyled">
                          <li><a href="{{ route('category', ['category' => 1]) }}">Men's Fashion</a></li>
                          <li><a href="{{ route('category', ['category' => 2]) }}">Women's Fashion</a></li>
                          <li><a href="{{ route('category', ['category' => 3]) }}">Accessories</a></li>
                        </ul>
                      </div>
                      <div class="col-lg-3"><strong class="text-uppercase">Customer Service</strong>
                        <ul class="list-unstyled">
                          <li><a href="{{ route('contact') }}">Contact</a></li>
                          <li><a href="{{ route('about') }}">About us</a></li>
                          <li><a href="{{ route('faq') }}">FAQ <span class="badge badge-success ml-2">New</span></a>
                          </li>
                        </ul>
                      </div>
                      <div class="col-lg-3"><strong class="text-uppercase">Customer</strong>
                        <ul class="list-unstyled">
                          @guest
                            <li><a href="{{ route('customerLogin') }}">Login/sign up</a></li>
                          @endguest
                          @auth
                            <li><a href="{{ route('customerAccount') }}">Profile</a></li>
                            <li><a href="{{ route('customerOrders') }}">Orders</a></li>
                            <li><a href="{{ route('customerAddresses') }}">Addresses</a></li>
                          @endauth
                        </ul>
                      </div>
                    </div>
                    <div class="row services-block">
                      <div class="col-xl-3 col-lg-6 d-flex">
                        <div class="item d-flex align-items-center">
                          <div class="icon"><i class="icon-truck text-primary"></i></div>
                          <div class="text"><span class="text-uppercase">Free shipping &amp; return</span><small>Free
                              Shipping over ₹300</small></div>
                        </div>
                      </div>
                      <div class="col-xl-3 col-lg-6 d-flex">
                        <div class="item d-flex align-items-center">
                          <div class="icon"><i class="icon-coin text-primary"></i></div>
                          <div class="text"><span class="text-uppercase">Money back guarantee</span><small>7 Days Money
                              Back</small></div>
                        </div>
                      </div>
                      <div class="col-xl-3 col-lg-6 d-flex">
                        <div class="item d-flex align-items-center">
                          <div class="icon"><i class="icon-headphones text-primary"></i></div>
                          <div class="text"><span class="text-uppercase">+91 08765 43210</span><small>24/7 Available
                              Support</small></div>
                        </div>
                      </div>
                      <div class="col-xl-3 col-lg-6 d-flex">
                        <div class="item d-flex align-items-center">
                          <div class="icon"><i class="icon-secure-shield text-primary"></i></div>
                          <div class="text"><span class="text-uppercase">Secure Payment</span><small>Secure
                              Payment</small></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
            <!-- /Megamenu end-->
            <li class="nav-item"><a href="{{ route('contact') }}" class="nav-link">Contact</a>
            </li>
          </ul>
          <div class="right-col d-flex align-items-lg-center flex-column flex-lg-row">
            <!-- Search Button-->
            <div class="search"><i class="icon-search"></i></div>
            @guest
              <div class="user">
                <a href="{{ route('customerLogin') }}" class="user-link"> <i class="icon-profile"></i> </a>
              </div>
            @endguest

            <!-- Authenticated User -->
            @auth
              <div class="user dropdown">
                <a href="#" id="userdetails" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  <i class="icon-profile"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="userdetails">
                  <li class="dropdown-item">
                    <a href="{{ route('customerOrders') }}">Orders</a>
                  </li>
                  <li class="dropdown-item">
                    <a href="{{ route('customerAddresses') }}">Addresses</a>
                  </li>
                  <li class="dropdown-item">
                    <a href="{{ route('customerAccount') }}">Profile</a>
                  </li>

                  <li class="dropdown-divider"></li>
                </ul>
              </div>
            @endauth
            @auth
            <!-- Cart Dropdown-->
            <div class="cart dropdown show"><a id="cartdetails" href="https://example.com" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="icon-cart"></i>
                <div class="cart-no">{{ $cartCount }}</div>
              </a><a href="{{ route('cart') }}" class="text-primary view-cart">View Cart</a>
              <div aria-labelledby="cartdetails" class="dropdown-menu">
                @forelse($cartItems as $cart)
                  <div class="dropdown-item cart-product">
                    <div class="d-flex align-items-center">

                      <div class="img">
                        <img src="{{ asset($cart->product->image_url ?? 'img/shirt.png') }}" class="img-fluid"
                          alt="{{ $cart->product->name }}">
                      </div>

                      <div class="details d-flex justify-content-between">

                        <div class="text">

                          <a href="{{ route('product.show', $cart->product->id) }}">
                            <strong>{{ $cart->product->name }}</strong>
                          </a>

                          <small>
                            Quantity: {{ $cart->quantity }}
                          </small>

                          <span class="price">
                            ${{ number_format($cart->product->base_price * $cart->quantity, 2) }}
                          </span>

                        </div>

                        <form action="{{ route('cart.remove', $cart->id) }}" method="POST">

                          @csrf
                          @method('DELETE')

                          <button type="submit" class="delete border-0 bg-transparent">

                            <i class="fa fa-trash-o"></i>

                          </button>

                        </form>

                      </div>

                    </div>
                  </div>
                @empty
                  <div class="dropdown-item text-center">
                    Cart is empty
                  </div>
                @endforelse
                <!-- total price-->
                <div class="dropdown-item total-price d-flex justify-content-between"><span>Total</span><strong
                    class="text-primary">
                    ₹{{ number_format($cartTotal, 2) }}
                  </strong></div>
                <!-- call to actions-->
                <div class="dropdown-item CTA d-flex">
                  {{-- View Cart: Disable only when cart is empty --}}
                  <a href="{{ $cartCount > 0 ? route('cart') : '#' }}"
                    class="btn btn-template wide {{ $cartCount == 0 ? 'disabled' : '' }}"
                    style="{{ $cartCount == 0 ? 'pointer-events:none;opacity:0.5;' : '' }}">
                    View Cart
                  </a>
                  {{-- Checkout: Disable when cart is empty OR user not logged in --}}
                  <a href="{{ Auth::check() && $cartCount > 0 ? route('checkout1') : '#' }}"
                    class="btn btn-template wide {{ !Auth::check() || $cartCount == 0 ? 'disabled' : '' }}"
                    style="{{ !Auth::check() || $cartCount == 0 ? 'pointer-events:none;opacity:0.5;' : '' }}">
                    Checkout
                  </a>
                </div>
              </div>
            </div>
            @endauth
          </div>
        </div>
      </div>
    </nav>
  </header>
  <!-- Hero Section-->
  @yield('section')
  <!-- Footer-->
  <footer class="main-footer">
    <!-- Service Block-->
    <div class="services-block">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 d-flex justify-content-center justify-content-lg-start">
            <div class="item d-flex align-items-center">
              <div class="icon"><i class="icon-truck"></i></div>
              <div class="text">
                <h6 class="no-margin text-uppercase">Free shipping &amp; return</h6><span>Free Shipping over ₹300</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 d-flex justify-content-center">
            <div class="item d-flex align-items-center">
              <div class="icon"><i class="icon-coin"></i></div>
              <div class="text">
                <h6 class="no-margin text-uppercase">Money back guarantee</h6><span>7 Days Money Back Guarantee</span>
              </div>
            </div>
          </div>
          <div class="col-lg-4 d-flex justify-content-center">
            <div class="item d-flex align-items-center">
              <div class="icon"><i class="icon-headphones"></i></div>
              <div class="text">
                <h6 class="no-margin text-uppercase">+91 08765 43210</h6><span>24/7 Available Support</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Main Block -->
    <div class="main-block">
      <div class="container">
        <div class="row">
          <div class="info col-lg-4">
            <div class="logo"><img src="{{ asset('img/logo-white.png') }}" alt="..."></div>
            <p>Discover the latest fashion trends with ClothesHub. We offer premium quality clothing for men and women
              at affordable prices, ensuring style, comfort, and confidence with every purchase.</p>
            <ul class="social-menu list-inline">
              <li class="list-inline-item"><a href="javascript:void(0)" style="pointer-events: none; cursor: default;" title="twitter"><i class="fa fa-twitter"></i></a>
              </li>
              <li class="list-inline-item"><a href="javascript:void(0)" style="pointer-events: none; cursor: default;" title="facebook"><i
                    class="fa fa-facebook"></i></a></li>
              <li class="list-inline-item"><a href="javascript:void(0)" style="pointer-events: none; cursor: default;" title="instagram"><i
                    class="fa fa-instagram"></i></a></li>
              <li class="list-inline-item"><a href="javascript:void(0)" style="pointer-events: none; cursor: default;" title="pinterest"><i
                    class="fa fa-pinterest"></i></a></li>
              <li class="list-inline-item"><a href="javascript:void(0)" style="pointer-events: none; cursor: default;" title="vimeo"><i class="fa fa-vimeo"></i></a>
              </li>
            </ul>
          </div>
          <div class="site-links col-lg-2 col-md-6">
            <h5 class="text-uppercase">Shop</h5>
            <ul class="list-unstyled">
              <li><a href="{{ route('category') }}">Shop All Products</a></li>
              <li><a href="{{ route('category', ['category' => 1]) }}">Men's Fashion</a></li>
              <li><a href="{{ route('category', ['category' => 2]) }}">Women's Fashion</a></li>
              <li><a href="{{ route('category', ['category' => 3]) }}">Accessories</a></li>
              <li><a href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
          </div>
          <div class="site-links col-lg-2 col-md-6">
            <h5 class="text-uppercase">Company</h5>
            <ul class="list-unstyled">
              <li><a href="{{ route('about') }}">About Us</a></li>
              @guest
                <li>
                  <a href="{{ route('customerLogin') }}">Login/sign up</a>
                </li>
              @endguest
              @auth
                <li><a href="{{ route('customerAccount') }}">My Account</a></li>
                <li><a href="{{ route('customerOrders') }}">My Orders</a></li>
              @endauth
              <li><a href="{{ route('faq') }}">FAQ</a></li>
            </ul>
          </div>
          <div class="newsletter col-lg-4">
            <h5 class="text-uppercase">Daily Offers & Discounts</h5>
            <p> Subscribe to our newsletter and be the first to know about exclusive deals, seasonal sales, new
              arrivals, and special discounts available only to our subscribers.</p>
            <form action="#" id="newsletter-form">
              <div class="form-group">
                <input type="email" name="subscribermail" placeholder="Your Email Address">
                <button type="submit"> <i class="fa fa-paper-plane"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="copyrights">
      <div class="container">
        <div class="row d-flex align-items-center">
          <div class="text col-md-6">
            <p>&copy; 2026 <a href="https://bootstrapious.com" target="_blank">ClothesHub</a> All rights reserved.
            </p>
          </div>
          <div class="payment col-md-6 clearfix">
            <ul class="payment-list list-inline-item pull-right">
              <li class="list-inline-item"><img src="{{ asset('img/visa.svg') }}" alt="..."></li>
              <li class="list-inline-item"><img src="{{ asset('img/mastercard.svg') }}" alt="..."></li>
              <li class="list-inline-item"><img src="{{ asset('img/paypal.svg') }}" alt="..."></li>
              <li class="list-inline-item"><img src="{{ asset('img/western-union.svg') }}" alt="..."></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- JavaScript files-->
  <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
  <script src="{{ asset('vendor/owl.carousel/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('vendor/owl.carousel2.thumbs/owl.carousel2.thumbs.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
  <script src="{{ asset('vendor/nouislider/nouislider.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-countdown/jquery.countdown.min.js') }}"></script>
  <script src="{{ asset('vendor/masonry-layout/masonry.pkgd.min.js') }}"></script>
  <script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <!-- masonry -->
  <script>
    $(function () {
      var $grid = $('.masonry-wrapper').masonry({
        itemSelector: '.item',
        columnWidth: '.item',
        percentPosition: true,
        transitionDuration: 0,
      });
      $grid.imagesLoaded().progress(function () {
        $grid.masonry();
      });
    })
  </script>
  <!-- Main Template File-->
  <script src="{{ asset('js/front.js') }}"></script>
</body>

</html>