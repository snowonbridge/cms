<?php

namespace app\admin\model;

use think\Model;

class PokerNotice extends Model
{
    // 表名
    protected $table = 'poker_notice';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'show_start_time_text',
        'show_end_time_text',
        'create_time_text'
    ];
    protected $connection='db_config_poker';






    public function getShowstarttimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['show_start_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getShowendtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['show_end_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setShowstarttimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setShowendtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
