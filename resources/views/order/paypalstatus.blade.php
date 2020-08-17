@extends('layout.checkout')
@section('title', 'Payment Status | '.config('app.name'))

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
  <div id="processing-payment" class="processing-payment-area area-padding">
    <div class="container text-center">
      <div class="processing-box">
        <h4>Processing Payment</h4>
        <div class="processing-payment-spinner"><i class="fa fa-2x fa-spin fa-circle-o-notch"></i></div>
        <span class="processing-payment-text">Payment is processing. Please do not close this tab.</span>
      </div>
    </div>
  </div>
  
@endsection

@push('scripts')
  <script type="text/javascript">
    var status = '{{ $data['status'] }}';
    var title = '{{ $data['title'] }}';
    var description = '{{ $data['description'] }}';
    var redirect = '{{ $data['redirect'] }}';

    setTimeout(function() {
      showAlert(status, title, description)
        .then(function() {
          window.location.replace(redirect);
        });
    }, 1000);
    
    function showAlert(status, title, text) {
      return Swal.fire({
        title: title,
        text: text,
        icon: status,
        confirmButtonText: 'OK',
        customClass: {
          header: 'swal2-header',
          content: 'swal2-content',
          confirmButton: 'swal2-confirm-btn',
        }
      });
    }
  </script>
@endpush