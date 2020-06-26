app.component('contactUs', {
  templateUrl: '/app/templates/contact-us.html',
  controller: 'ContactUsController'
});

app.controller('ContactUsController', ['$scope', '$http', 'CSRF_TOKEN',

function ($scope, $http, $token) {

  $scope.status = null;
  $scope.message = null;

  // contact-us form data
  $scope.data = {};

  $scope.submit = function() {
    var request = {
      method: 'POST',
      url: '/contact-us',
      headers: { 'Accept': 'application/json', 'X-XSRF-TOKEN': $token },
      data: $scope.data,
    };

    $http(request).then(function(response) {
      $scope.status = 'success';
      $scope.message = response.data.message;
      $scope.resetForm();
    }, function(error) {
      $scope.status = 'error';
      $scope.message = error.data.message;
    });
  }

  $scope.resetForm = function() {
    $scope.data = {};
    $scope.form.$setPristine();
    $scope.form.$setUntouched();
  } 


}

]);