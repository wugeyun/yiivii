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
            MemberModel::where('email',session('email'))->update(['nikename' => $nikename]);
            session('status',1001);
        }
    }
}
