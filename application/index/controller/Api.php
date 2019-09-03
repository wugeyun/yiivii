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
        $arr = explode("\n",$str);
        foreach($arr as $v){
            $a = explode(" ",$v);
            if (count($a) == 6) {
                $data[] = [
                    $a[1] => $a[2]
                ];
            }
        }
        return json(['code'=>200,'message'=>'操作完成','data'=>$data]);
    }
}
