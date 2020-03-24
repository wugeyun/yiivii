<?php
namespace app\common\model;
use think\Model;
class Tags extends Model {
    protected $auto = ['update_time'];
    protected $insert = ['create_time'];
    //写入时间
    protected function setCreateTimeAttr(){
        return time();
    }
    //更新时间
    protected function setUpdateTimeAttr(){
        return time();
    }

}