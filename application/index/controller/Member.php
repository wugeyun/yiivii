<?php
namespace app\index\controller;
use think\Controller;
use app\common\controller\Common;
use app\common\model\Order;
use app\common\model\Member as MemberModel;
class Member extends Common {
    protected function initialize(){
        if(session('?uid') == false){
            $this->error('请使用Email登陆');
        }
    }
    /**
     * @return mixed
     */
    public function index() {
        $uid = session('uid');
        $list = Order::where('uid',$uid)
            ->paginate(10,true,['type' => 'page\Zui']);
        $data['list'] = $list;
        return view('');
    }
    //更新
    public function edit($pk,$name,$value){
        if($pk){
            Order::update(['id'=>$pk,$name => $value]);
        }else{
            $this->error('非法请求');
        }
    }
}
