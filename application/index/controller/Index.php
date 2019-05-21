<?php
namespace app\index\controller;

use think\Controller;
use QL\QueryList;
use app\common\model\Order;
use app\common\controller\Common;
class Index extends Common
{
    /**
     * @return mixed
     */
    public function index()
    {
        $list = Order::order('id desc')->limit(15)->select();
        $count = Order::where('uid',session('uid'))->count();
        $data['count'] = $count;
        $data['list'] = $list;
        return view('',$data);
    }

    /**
     * @return mixed
     */
    public function howtouse()
    {
        return view('');
    }

    /**
     * 获取pp
     * 86400 每日
     * week 每周
     */
    public function set_pp($t = 'day')
    {
        $ql = QueryList::getInstance();
        $post['period'] =  $t == 'day' ? '86400' : 'week';
        $html = callapi('https://www.yiivii.com/investing/technical/pivot-points',$post);
        $ql->setHtml($html);
        $data = $ql->find('#curr_table')->html();
        cache('pp_'.$t, $data);
        dump(cache('pp_'.$t));
    }
}