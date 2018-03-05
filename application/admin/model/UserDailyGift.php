<?php

namespace app\admin\model;

use think\Model;

class UserDailyGift extends Model
{
    // 表名
    protected $table = 'user_daily_gift';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'gift_add_time_text',
        'gift_receive_time_text',
        'create_time_text'
    ];

    protected $connection="db_firstlogin";
    



    public function getGiftaddtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['gift_add_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getGiftreceivetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['gift_receive_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setGiftaddtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setGiftreceivetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}