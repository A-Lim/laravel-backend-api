@extends('layout.checkout')
@section('title', 'Order Details | '.config('app.name'))

@section('content')
  <div id="order-details" class="order-details-area area-padding">
    <div class="container">
      <h3>Payment Options</h3>
      <payment-methods></payment-methods>
    </div>
  </div>
@endsection