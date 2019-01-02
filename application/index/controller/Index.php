<?php
namespace app\index\controller;
use think\Controller;
use app\common\controller\Common;
class Index extends Common {
    public function index() {
        return view('');
    }

    public function howtouse() {
        return view('');
    }
}
