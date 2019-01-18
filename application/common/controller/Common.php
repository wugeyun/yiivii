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
         */
        //读取cookie
        $user_info = cookie('user_info');
        //写入session
        if(!empty($user_info) && session('status') != 1001){
            $user = Member::where(['id'=>$user_info['uid'],'email'=>$user_info['email']]);
            session('uid',$user->id);
            session('email',$user->email);
            session('status',1001);
        }
    }
}