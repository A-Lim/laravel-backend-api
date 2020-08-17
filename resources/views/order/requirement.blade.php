@extends('layout.checkout')
@section('title', 'Secure Checkout | '.config('app.name'))

@section('header')
  <script>
    angular.module('app').constant('ORDER', '{!! $order !!}');
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
                  <img src="{{ asset('img/logo/logo-negative.png') }}" alt="{{ ucfirst(env('APP_NAME')) }}"/>
                  <span><strong>{{ strtoupper(env('APP_NAME')) }}</strong></span>
                </a>
              </div>
              <div class="checkout-menu">
                <ul class="breadcrumbs">
                  <li class="completed"><div class="number"><i class="fa fa-check"></i></div> Order Details</li>
                  <li class="separator"><i class="fa fa-angle-right"></i>&nbsp;</li>
                  <li class="completed"><div class="number"><i class="fa fa-check"></i></div> Confirm and Pay</li>
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
  <div id="requirements" class="requirements-area area-padding">
    <div class="container">
      <h3>Submit Requirements</h3>
      <span>Fill in the form below to help us translate your content more accurately.</span>
      <div class="row">
        <div class="col-md-8 col-xs-12">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <requirements-form></requirements-form>
        </div>

        <div class="col-md-4 col-xs-12">
          <div class="order-summary-panel">
            <h6>Summary</h6>
            <hr/>
            {{-- <pre>{{ $order->items }}</pre> --}}
            @foreach ($order->items as $item)
              <div class="order-item">
                <div class="order-item-summary">
                  <div class="order-item-detail">
                    <div>{{ $item->name }}</div>
                    <div class="item-description">{{ $item->description }}</div>
                  </div>
                  <span class="price">${{ $item->quantity * $item->unit_price }}</span>
                </div>
              </div>
            @endforeach
            
            <hr/>
            <div class="order-item-summary">
              <span><strong>Total</strong></span><span class="price">${{ $order->total }}</span>
            </div>
            <div class="order-item-summary">
              @php
                $delivery_days = array_sum($order->items->pluck('delivery_days')->toArray());
              @endphp
              <span>Delivery Time</span><span class="delivery-time">{{ $delivery_days }} {{ $delivery_days <= 1 ? 'Day' : 'Days' }}</span>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
@endsection

@push('scripts')
  <script src="https://js.stripe.com/v3/"></script>
  <script src="{{ asset('app/controllers/requirements-form.js') }}"></script>
@endpush