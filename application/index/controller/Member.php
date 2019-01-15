<?php
namespace app\index\controller;
use think\Controller;
use app\common\controller\Common;
use app\common\model\Member as MemberModel;
class Member extends Common {
    public function index($email) {
        return view('');
    }

    /**
     * @param $nikename
     */
    public function setuser($nikename){
        if(session('status') == 1002){
            MemberModel::where('id',session('uid'))->update(['nikename' => $nikename]);
            session('nikename',$nikename);
            session('status',1001);
        }
    }
}
