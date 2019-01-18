<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Order;
use app\common\controller\Common;
class Index extends Common {
    /**
     * @return mixed
     */
    public function index() {
        $list = Order::order('id desc')->limit(5)->select();
        $count = Order::where('uid',session('uid'))->count();
        $data['count'] = $count;
        $data['list'] = $list;
        return view('',$data);
    }

    /**
     * @return mixed
     */
    public function howtouse() {
        return view('');
    }
}