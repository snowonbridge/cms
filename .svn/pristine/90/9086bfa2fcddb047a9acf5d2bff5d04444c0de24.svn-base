<?php

namespace app\admin\model;

use think\Model;

class UserUseRoomcardLog extends Model
{
    // 表名
    protected $table = 'user_use_roomcard_log';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'add_month_time_text',
        'add_day_time_text',
        'create_time_text'
    ];
    protected $connection="db_config2";






    public function getAddmonthtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['add_month_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getAdddaytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['add_day_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAddmonthtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setAdddaytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
