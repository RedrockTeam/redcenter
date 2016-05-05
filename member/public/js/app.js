/**
 * Created by zxy on 2016/3/14.
 */
var userApp = angular.module('userCenter',['ngRoute']);

userApp.config(function($routeProvider){
    $routeProvider.when('/userCenter',{
        templateUrl:'../public/tpl/userCenter.html'
    })
        .when('/product',{
        templateUrl:'../public/tpl/myProduct.html'
    })
        .when('/dataCenter',{
        templateUrl:'../public/tpl/dataCenter.html'
    })
        .when('/helpCenter',{
            templateUrl:'../public/tpl/helpCenter.html'
        })
        .when('/prizes',{
            templateUrl:'../public/tpl/prizes.html'
        })
        .otherwise({
        redirectTo:'/userCenter'
    })
});
