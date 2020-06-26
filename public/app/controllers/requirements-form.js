app.component('requirementsForm', {
  templateUrl: '/app/templates/requirements-form.html',
  controller: 'RequirementsFormController'
});

app.controller('RequirementsFormController', ['$scope', '$http', 'CSRF_TOKEN', 'ORDER',

function ($scope, $http, $token, $order) {
  $scope.token = $token;

  $scope.order = JSON.parse($order);
  $scope.data = null;
  $scope.message = '';

  this.$onInit = function() {
    $scope.data = {
      'refNo': $scope.order.refNo,
      'name': $scope.order.requirement.name,
      'email': $scope.order.requirement.email,
    }
  }
}]);