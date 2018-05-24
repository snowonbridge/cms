<?php

namespace app\admin\model;

use think\Model;

class PokerUsertoolsView extends Model
{
    // 表名
    protected $table = 'poker_usertools_view';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'usetime_text',
        'gettime_text'
    ];
    protected $connection = 'db_config_poker';

    



    public function getUsetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['usetime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getGettimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['gettime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setUsetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setGettimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }



}
