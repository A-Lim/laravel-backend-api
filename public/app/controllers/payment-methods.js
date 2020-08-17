app.component('paymentMethods', {
  templateUrl: '/app/templates/payment-methods.html',
  controller: 'PaymentMethodsController'
});

app.controller('PaymentMethodsController', ['$scope', '$http', '$window', 'CSRF_TOKEN', 'REFNO',

function ($scope, $http, $window, $token, $refNo) {
  $scope.paymentmethod = null;
  $scope.data = null;

  $scope.isLoading = false;

  // order summary
  $scope.total = 0;
  $scope.subTotal = 0;
  $scope.delivery_days = 0;

  $scope.stripeInstance = null;
  $scope.stripeKey = null;
  $scope.stripeCard = null;
  $scope.stripeError = null;
  $scope.stripeCardComplete = false;

  $scope.paypalKey = null;

  $scope.order = null;


  this.$onInit = function () {
    var getReq = {
      method: 'GET',
      url: '/order/' + $refNo,
      headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': $token },
    };

    $http(getReq).then(function(response) {
      $scope.order = response.data.data;

      // reset 
      $scope.total = 0;
      $scope.subTotal = 0;
      $scope.delivery_days = 0;

      var tempTotal = 0;
      var temp_delivery_days = 0;

      // calculate order summary
      for (var i = 0; i < $scope.order.items.length; i++) {
        var orderitem = $scope.order.items[i];
        tempTotal += orderitem.unit_price * orderitem.quantity;
        temp_delivery_days += orderitem.delivery_days;
      }

      $scope.total = tempTotal;

      // if there is discounts
      // calculate here
      $scope.subTotal = tempTotal;

      // if there is fast delivery, 
      // calculate / deduct delivery days here
      $scope.delivery_days = temp_delivery_days;
    }, function(error) {

    });
  }

  $scope.paymentMethodSelected = function() {

    switch ($scope.paymentmethod) {

      case 'credit_debit_cards':
        $scope.getStripeIntegration();
        break;

      case 'paypal':
        break;

      default:
        break;
    }
  }

  $scope.checkout = function() {

    switch ($scope.paymentmethod) {
      case 'credit_debit_cards':
        stripe_checkout();
        break;
    
      case 'paypal':
        paypal_checkout();
        break;

      default:
        break;
    }
  }

  /** STRIPE FUNCTIONS **/

  $scope.getStripeIntegration = function() {
    if ($scope.stripeKey == null) {
      var getReq = {
        method: 'GET',
        url: '/payment/stripe/integration',
        headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': $token },
      };
  
      $http(getReq).then(function(response) {
        $scope.stripeKey = response.data.data.key;
        $scope.initStripe();
      }, function(error) {

      });

      return;
    }

    $scope.initStripe();
  }

  $scope.initStripe = function() {
    $scope.stripeInstance = Stripe($scope.stripeKey);

    // Create an instance of Elements.
    var elements = $scope.stripeInstance.elements();

    var style = {
      base: {
        color: '#32325d',
        fontFamily: '"Open Sans", sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '14px',
        '::placeholder': {
          color: '#aab7c4'
        },
        
      },
      invalid: {
        color: '#a94442',
        iconColor: '#a94442'
      }
    };

    // Create an instance of the card Element.
    $scope.stripeCard = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    $scope.stripeCard.mount('#card-element');


    // Handle real-time validation errors from the card Element.
    $scope.stripeCard.on('change', function(event) {
      $scope.stripeCardComplete = event.complete;
      if (event.error)
        $scope.stripeError = event.error.message;
      else
        $scope.stripeError = null;
      
      $scope.$apply();
    });
  }

  /** PRIVATE FUNCTIONS **/
  function stripe_checkout() {
    $scope.isLoading = true;

    var url = '/payment/stripe/pay';

    var data = {
      refNo: $refNo,
      payment_method: $scope.paymentmethod,
      name: $scope.data.name,
      email: $scope.data.email
    };

    var postReq = {
      method: 'POST',
      url: url,
      data: data,
      headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': $token },
    };

    var redirectTo = '';

    $scope.stripeInstance.createToken($scope.stripeCard)
      .then(function(result) {
        // Inform the user if there was an error.
        if (result.error) {
          $scope.stripeError = result.error.message;
          $scope.$apply();
          return Promise.reject({ data: result.error });
        }

        // Send the token to your server.
        data.stripe_token = result.token.id;
        return $http(postReq);
      })
      .then(function (response) {
        $scope.isLoading = false;
        $scope.$apply();

        if (response.data.redirect)
          redirectTo = response.data.redirect;

        return showSuccessAlert('Payment Successful');
      })
      .then(function() {
        $window.location.href = redirectTo;
      })
      .catch(function(error) {
        console.log(error);
        $scope.isLoading = false;
        showErrorAlert('Payment Failed', error?.data?.message);
        $scope.$apply();
      });
  }

  function paypal_checkout() {
    $scope.isLoading = true;

    var url = '/payment/paypal/pay';

    var data = {
      refNo: $refNo,
      payment_method: $scope.paymentmethod,
      // name: $scope.data.name,
      // email: $scope.data.email
    };

    var postReq = {
      method: 'POST',
      url: url,
      data: data,
      headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': $token },
    };

    var redirectTo = '';

    $http(postReq).then(function (response) {
      if (response.data.redirect) 
        $window.location.href = response.data.redirect;
      
        
      // console.log(response);
      // $scope.isLoading = false;
      // $scope.$apply();

      // if (response.data.redirect)
      //   redirectTo = response.data.redirect;

      // return showSuccessAlert('Payment Successful');
    })
    // .then(function() {
    //   $window.location.href = redirectTo;
    // })
    // .catch(function(error) {
    //   $scope.isLoading = false;
    //   showErrorAlert('Payment Failed', error?.data?.message);
    //   $scope.$apply();
    // });
  }

  function showSuccessAlert(title) {
    return Swal.fire({
      title: title,
      icon: 'success',
      confirmButtonText: 'OK',
      customClass: {
        header: 'swal2-header',
        content: 'swal2-content',
        confirmButton: 'swal2-confirm-btn',
      }
    });
  }

  function showErrorAlert(title, text) {
    return Swal.fire({
      title: title,
      text: text,
      icon: 'error',
      confirmButtonText: 'OK',
      customClass: {
        header: 'swal2-header',
        content: 'swal2-content',
        confirmButton: 'swal2-confirm-btn',
      }
    });
  }

}]);