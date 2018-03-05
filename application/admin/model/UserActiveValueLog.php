<?php

namespace app\admin\model;

use think\Model;

class UserActiveValueLog extends Model
{
    // 表名
    protected $table = 'user_active_value_log';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'add_day_time_text',
        'add_time_text'
    ];

    protected $connection="db_firstlogin";
    



    public function getAdddaytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['add_day_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getAddtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['add_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAdddaytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setAddtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}