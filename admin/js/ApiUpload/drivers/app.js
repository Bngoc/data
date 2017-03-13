var app = angular.module('myApp', ['ngRoute', 'ui.bootstrap', 'ngAnimate'])
    .constant('API_URL', '/admin.php?mod=editconfig&opt=uploadFileAPIGoogle');

app.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
    when('/admin.php', {
      title: 'Products',
      templateUrl: pathcDataAdmin +'/com_board/addUpload.php',
      controller: 'productsCtrl'
    })
    .otherwise({
      redirectTo: '/admin.php'
    });
}]);
