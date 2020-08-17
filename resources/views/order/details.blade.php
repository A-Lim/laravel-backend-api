@extends('layout.checkout')
@section('title', 'Order Details | '.config('app.name'))

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
              <div class="checkout-menu">
                <ul class="breadcrumbs">
                  <li class="completed"><div class="number">1.</div> Order Details</li>
                  <li class="separator"><i class="fa fa-angle-right"></i>&nbsp;</li>
                  <li><div class="number">2.</div> Confirm and Pay</li>
                  <li class="separator"><i class="fa fa-angle-right"></i>&nbsp;</li>
                  <li><div class="number">3.</div> Submit Requirements</li>
                </ul>
              </div>
              <div class="clearfix"></div>
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
  <div id="order-details" class="order-details-area area-padding">
    <div class="container">
      <h3>Order Details</h3>
      <order-details></order-details>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="{{ asset('app/controllers/order-details.js') }}"></script>
@endpush