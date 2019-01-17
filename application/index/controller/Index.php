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
        $list = Order::limit(8)->select();
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
