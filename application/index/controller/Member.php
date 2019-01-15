<?php
namespace app\index\controller;
use think\Controller;
use app\common\controller\Common;
use app\common\model\Order;
use app\common\model\Member as MemberModel;
class Member extends Common {
    /**
     * @return mixed
     */
    public function index() {
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
    public function order(){

    }
}
