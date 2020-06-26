app.component('orderDetails', {
  templateUrl: '/app/templates/order-details.html',
  controller: 'OrderDetailsController'
});

app.controller('OrderDetailsController', ['$scope', '$http', 'CSRF_TOKEN',

function ($scope, $http, $token) {
  $scope.cart = [];
  $scope.isLoading = false;
  $scope.token = $token;

  // order summary
  $scope.total = 0;
  $scope.subTotal = 0;
  $scope.delivery_days = 0;

  this.$onInit = function () {
    $scope.isLoading = true;
    var getReq = {
      method: 'GET',
      url: '/cart',
      headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': $token },
    };

    $http(getReq).then(function(response) {
      $scope.cart = response.data.data;

      // reset 
      $scope.total = 0;
      $scope.subTotal = 0;
      $scope.delivery_days = 0;

      var tempTotal = 0;
      var temp_delivery_days = 0;

      // calculate order summary
      for (var i = 0; i < $scope.cart.length; i++) {
        var cartItem = $scope.cart[i];
        tempTotal += cartItem.product.price * cartItem.quantity;
        temp_delivery_days += cartItem.product.delivery_days;
      }

      $scope.total = tempTotal;

      // if there is discounts
      // calculate here
      $scope.subTotal = tempTotal;

      // if there is fast delivery, 
      // calculate / deduct delivery days here
      $scope.delivery_days = temp_delivery_days;

      $scope.isLoading = false;
    }, function(error) {
      $scope.isLoading = false;
    });
  };

  $scope.remove = function(product_id) {
    $scope.isLoading = true;

    var delReq = {
      method: 'POST',
      url: '/cart',
      headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': $token },
      data: { 'product_id': product_id, '_method': 'delete' }
    };

    $http(delReq).then(function(response) {
      $scope.cart = response.data.data;
      $scope.isLoading = false;
    }, function(error) {
      $scope.isLoading = false;
    });

  }
}]);