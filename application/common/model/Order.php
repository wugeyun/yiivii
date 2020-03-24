<?php
namespace app\common\model;
use think\Model;
class Order extends Model {
    protected $auto = ['update_time', 'ip'];
    protected $insert = ['uid','create_time'];
    //设置ip
    protected function setIpAttr(){
        return request()->ip();
    }
    //写入uid
    protected function setUidAttr(){
        return session('uid');
    }
    //写入时间
    protected function setCreateTimeAttr(){
        return time();
    }
    //更新时间
    protected function setUpdateTimeAttr(){
        return time();
    }

}