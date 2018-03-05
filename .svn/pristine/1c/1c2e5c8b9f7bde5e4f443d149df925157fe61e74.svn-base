<?php

namespace app\admin\model;

use think\Model;

class UserPhotos extends Model
{

    protected $connection = 'database.db_config1';
    // 表名
    protected $name = 'poker_user_photos';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'optime_text',
        'apply_time_text'
    ];
    

    



    public function getOptimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['optime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    public function usermap()
    {
        return $this->belongsTo('PokerUserMap', 'uid')->setEagerlyType(0);
    }



    public function getApplytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['apply_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setOptimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setApplytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
