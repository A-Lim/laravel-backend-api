@extends('layout.checkout')
@section('title', 'Secure Checkout | '.config('app.name'))

@section('header')
  <script>
    angular.module('app').constant('REFNO', '{!! $order->refNo !!}');
  </script>
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
                  <img src="{{ asset('img/logo/logo-negative.png') }}" alt="Translate Champ"/>
                  <span><strong>TRANSLATE CHAMP</strong></span>
                </a>
              </div>
              <div class="checkout-menu">
                <ul class="breadcrumbs">
                  <li class="completed"><div class="number"><i class="fa fa-check"></i></div><a href="{{ url('order/details') }} ">Order Details</a></li>
                  <li class="separator"><i class="fa fa-angle-right"></i>&nbsp;</li>
                  <li class="completed"><div class="number">2.</div> Confirm and Pay</li>
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
  <div id="payment-methods" class="payment-methods-area area-padding">
    <div class="container">
      <h3>Choose Payment Method</h3>
      <payment-methods></payment-methods>
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ asset('app/controllers/payment-methods.js') }}"></script>
@endpush