<?php

namespace app\admin\model;

use think\Model;

class PlayerOnline extends Model
{
    // 表名
    protected $connection = 'database.db_config1';
    protected $name = 'poker_online';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'ollogintime_text',
        'refreshtime_text'
    ];
    

    



    public function getOllogintimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['ollogintime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getRefreshtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['refreshtime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setOllogintimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setRefreshtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
