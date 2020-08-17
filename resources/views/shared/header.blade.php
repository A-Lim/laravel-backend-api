<header>
  <!-- header-area start -->
  <div id="sticker" class="header-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12 col-sm-12">

          <!-- Navigation -->
          <nav class="navbar navbar-default">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
              <!-- Brand -->
              <a class="navbar-brand page-scroll sticky-logo" href="{{ url('/') }}">
                <img src="{{ asset('img/logo/logo-negative.png') }}" alt="{{ ucfirst(env('APP_NAME')) }}"/>
                <span><strong>{{ strtoupper(env('APP_NAME')) }}</strong></span>
              </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse main-menu bs-example-navbar-collapse-1" id="navbar-example">
              <ul class="nav navbar-nav navbar-right">
              @if (Route::getCurrentRoute()->uri() == '/')
                <li class="active">
                  <a class="page-scroll" href="#home">Home</a>
                </li>
                <li>
                  <a class="page-scroll" href="#why-us">Why Us</a>
                </li>
                <li>
                  <a class="page-scroll" href="#how-it-works">How It Works</a>
                </li>
                <li>
                  <a class="page-scroll" href="#testimonials">Testimonials</a>
                </li>
                <li>
                  <a class="page-scroll" href="#pricing-plans">Order Now</a>
                </li>
                <li>
                  <a class="page-scroll" href="#contact-us">Contact Us</a>
                </li>
              @endif
              @if (Route::getCurrentRoute()->uri() != '/')
                <li class="active">
                  <a class="page-scroll" href="{{ URL::to('/') }}#home">Home</a>
                </li>
                <li>
                  <a class="page-scroll" href="{{ URL::to('/') }}#why-us">Why Us</a>
                </li>
                <li>
                  <a class="page-scroll" href="{{ URL::to('/') }}#how-it-works">How It Works</a>
                </li>
                <li>
                  <a class="page-scroll" href="{{ URL::to('/') }}#testimonials">Testimonials</a>
                </li>
                <li>
                  <a class="page-scroll" href="{{ URL::to('/') }}#pricing-plans">Order Now</a>
                </li>
                <li>
                  <a class="page-scroll" href="{{ URL::to('/') }}#contact-us">Contact Us</a>
                </li>
              @endif
              </ul>
            </div>
            <!-- navbar-collapse -->
          </nav>
          <!-- END: Navigation -->
        </div>
      </div>
    </div>
  </div>
  <!-- header-area end -->
</header>