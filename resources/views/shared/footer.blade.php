<!-- Start Footer bottom Area -->
  <footer>
    <div class="footer-area">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center">
            <img class="logo" src="{{ asset('img/logo/logo.png') }}" alt="{{ ucfirst(env('APP_NAME')) }}"/>
            <p class="logo-text"><strong>{{ strtoupper(env('APP_NAME')) }}</strong></p>
          </div>
          <div class="col-md-12">
            <ul>
              <li><a class="page-scroll" href="#">Home</a></li>
              <li><a class="page-scroll" href="#why-us">Why Us</a></li>
              <li><a class="page-scroll" href="#how-it-works">How It Works</a></li>
              <li><a class="page-scroll" href="#testimonials">Testimonials</a></li>
              <li><a class="page-scroll" href="#pricing-plans">Order Now</a></li>
              <li><a class="page-scroll" href="#contact-us">Contact Us</a></li>
              <li><a href="/privacy-policy">Privacy Policy</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-area-bottom">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="copyright text-center">
              <p>
                &copy; {{ date("Y") }} Copyright <strong>{{ ucfirst(env('APP_NAME')) }}</strong>. All Rights Reserved
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>