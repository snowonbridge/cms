<?php

namespace app\admin\model;

use think\Model;

class NewhandSetting extends Model
{
    // 表名
    protected $table = 'newhand_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'update_time_text',
        'create_time_text'
    ];
    protected $connection="db_config2";






    public function getUpdatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['update_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setUpdatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


    public function registerText()
    {
        return ['1'=>'游客','2'=>'手机','3'=>'微信','4'=>'QQ','5'=>'灵游'];
    }
    public function systemText()
    {
        return ['1'=>'安卓','2'=>'IOS','3'=>'PC'];

    }

}
