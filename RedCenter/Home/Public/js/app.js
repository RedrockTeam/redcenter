/**
 * Created by zxy on 2016/3/14.
 */
var userApp = angular.module('userCenter',['ngRoute']);

userApp.config(function($routeProvider){
    $routeProvider.when('/userCenter',{
        templateUrl:'../Public/tpl/userCenter.html'
    }).otherwise({
        redirectTo:'/userCenter'
    })
});