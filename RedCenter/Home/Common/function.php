<?php
    function getUinfo(){
        if (session('stunum')) {
            $userInfo = new \Home\myLib\UserInfo(session('stunum'));
            return $userInfo;
        }
    }