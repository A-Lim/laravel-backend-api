@extends('layout.checkout')
@section('title', 'Thank You | '.config('app.name'))

@section('header')
  <header>
    <!-- header-area start -->
    <div id="checkout-header" class="header-area">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-sm-12">

            <!-- Navigation -->
            <nav class="navbar navbar-default">
              <!-- Brand and toggle get grouped for better mobile display -->
              <div class="navbar-header">
                <!-- Brand -->
                <a class="navbar-brand page-scroll sticky-logo" href="{{ url('/') }}">
                  <img src="{{ asset('img/logo/logo-negative.png') }}" alt="{{ ucfirst(env('APP_NAME')) }}"/>
                  <span><strong>{{ strtoupper(env('APP_NAME')) }}</strong></span>
                </a>
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
@endsection

@section('content')
  <div id="thankyou" class="thankyou-area area-padding">
    <div class="container text-center">
      <div class="thankyou-box">
        <h4>Thank You</h4>
        <p>Your order has been successfully submitted. Thank you for using our service.</p>

      <a class="btn btn-primary" href="{{ url('/') }}">Back To Home Page</a>
      </div>
    </div>
  </div>
@endsection