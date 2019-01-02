<?php
namespace app\common\controller;
use think\Controller;
use app\common\model\Member;
class Common extends Controller {
    protected function initialize() {
        /**
         * 系统状态初始化
         * 1000 游客状态
         * 1001 登陆状态
         * 1002 nikename为空
         */
        session('?status') ? '' : session('status',1000);
        //读取cookie
        $email = cookie('email');
        $user = Member::get(['email'=>$email]);
        //判断用户
        if(!empty($user)){
            session('email',$email);
            $user['nikename'] == '' ? session('status',1002) : session('status',1001);
        }

    }
}
