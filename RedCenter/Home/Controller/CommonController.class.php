<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/6/15
 * Time: 14:58
 */
namespace Home\Controller;
use Home\myLib\UserInfo;
use Think\Controller;

class CommonController extends Controller {
    protected $uinfo;
    public function _initialize(){
        if(is_null(session('stunum'))){
            $this->redirect('Home/Login/index');
        }
        $this->uinfo = new UserInfo(session('stunum'));
    }
}