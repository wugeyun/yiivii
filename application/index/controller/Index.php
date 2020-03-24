<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Cache;
use QL\QueryList;
use app\common\model\Order;
use app\common\controller\Common;
use app\common\model\Member;

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
        //$data['paylist'] = get_pay();
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
     * 枢轴点show
     * @param $t
     * @return mixed
     */
    public function pp($t)
    {
        $data['pp'] = Cache::get('pp_'.$t,'数据加载中...');
        return view('',$data);
    }

    /**
     * 科普 枢轴点
     * main-content
     */
    public function baike()
    {
        $url = 'https://baike.baidu.com/item/%E6%9E%A2%E8%BD%B4%E7%82%B9/6689552';
        //写入缓存，时间3600
        Cache::remember('baike',function() use ($url){
            $ql = QueryList::get($url);
            $baike = $ql->find('.main-content')->html();
            return $baike;
        },3600*24);
        $data['url'] = $url;
        $data['baike'] = Cache::get('baike') ?: '数据加载中...';
        return view('',$data);
    }

    /**
     * 设置pp
     * 86400 每日
     * week 每周
     * c 为商品货币 默认 commodities
     */
    public function set_pp($t = 'day', $c = '')
    {
        $post['period'] =  $t == 'day' ? '86400' : 'week';
        if ($c != '') {
            $c .= '-';
        }
        $html = callapi('https://www.yiivii.com/investing/technical/' . $c . 'pivot-points', $post);
        $ql = QueryList::html($html);
        $data = $ql->find('#curr_table')->html();
        $cache_name = 'pp_' . $c . $t;
        Cache::set($cache_name, $data);
        echo $cache_name . ' set ok at ';
        echo date('Y-m-d H:i:s');
    }

    /**
     * 每日daily
     * @param int $bcc
     * @return string
     */
    public function daily($bcc = 0)
    {
        $list = $bcc ? Member::where('lastlogin', '>', 0)->column('email') : ['260258959@qq.com'];
        $str = email_daily_body($title = '商品类今日枢轴点', $content = Cache::get('pp_commodities-day'));
        $str .= email_daily_body($title = '货币类今日枢轴点', $content = Cache::get('pp_day'));
        $str .= email_daily_body($title = '商品类本周枢轴点', $content = Cache::get('pp_commodities-week'));
        $str .= email_daily_body($title = '货币类本周枢轴点', $content = Cache::get('pp_week'));
        $str .= email_daily_footer();
        sendMail($content = $str, $to = 'wuge500@vip.qq.com', $title = '最牛逼的交易数据 [' . date('Y-m-d') . ']', $bcc = $list);
        return 'send daily success';
    }
}
