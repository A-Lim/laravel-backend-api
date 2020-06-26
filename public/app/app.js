var app = angular.module('app', []);

app.directive('validfile', function validFile() {
  var validFormats = ['docx', 'xls', 'xlsx', 'txt', 'pdf'];
  return {
      require: 'ngModel',
      link: function (scope, elem, attrs, ctrl) {
              
        ctrl.$validators.validfile = function() {
          elem.on('change', function () {
            var value = elem.val();
            var ext = value.substring(value.lastIndexOf('.') + 1).toLowerCase();

            fileIsValid(validFormats.indexOf(ext) !== -1);

            scope.$apply();
          });
        };

        function fileIsValid(bool) {
          ctrl.$setValidity('validfile', bool);
        }
      }
  };
});