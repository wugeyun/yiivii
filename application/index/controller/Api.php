<?php
namespace app\index\controller;

use think\Controller;
use think\facade\Cache;
use QL\QueryList;

class Api extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        echo date('Y-m-d H:i:s');
    }

    /**
     * quotes
     * main-content
     */
    public function quotes()
    {
        $url = 'https://quotes.tickmill.com/livegraph_new/cache/small.php';
        $ql = QueryList::get($url);
        $str = $ql->getHtml();
        //处理
        $data = [];
        $code = 200;
        $message = '操作成功';
        $arr = explode("\n",$str);
        foreach($arr as $v){
            $a = explode(" ",$v);
            if (count($a) == 6) {
                $data[] = [
                    $a[1] => $a[2]
                ];
            }
        }
        if (empty($data)) {
            $code = 500;
            $message = '操作失败';
        }
        //写入缓存
        Cache::remember('paylist',function() use ($data){
            return $data;
        });
        return json(['code'=>$code,'message'=>$message,'data'=>$data]);
    }
}
