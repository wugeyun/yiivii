<?php
namespace app\index\controller;
use think\Controller;
use app\common\controller\Common;
use app\common\model\Order;
use app\common\model\Tags;
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
    public function index($tag = '') {
        $uid = session('uid');
        $where['uid'] = $uid;
        if($tag != ''){
            $where['tag'] = urldecode($tag);
        }
        $list = Order::where($where)
            ->order('id desc')
            ->paginate(5,false,['type' => 'page\Zui']);
        $data['list'] = $list;
        return view('',$data);
    }
    /**
     * @return mixed
     */
    public function add(){
        return view('');
    }

    /**
     * @return mixed
     */
    public function getdata($term = ''){
        if($term){
            $list = Tags::field('name')
                ->where('name','like',"%$term%")
                ->column('name');
            return json($list);
        }
    }
    /**
     * 新增订单
     */
    public function order($type = ''){
        if($type == ''){
            $this->error('请选择多空选项');
        }
        $post = input('post.');
        if($post){
            $order = Order::create($post);
            if($order->id){
                $this->redirect('member/index');
            }else{
                $this->error('非法请求.');
            }
        }else{
            $this->error('非法请求');
        }
    }
    /**
     * 更新
     * @param $pk
     * @param $name
     * @param $value
     */
    public function edit($pk,$name,$value){
        if($pk){
            Order::update(['id'=>$pk,$name => $value]);
        }else{
            $this->error('非法请求');
        }
    }
}
