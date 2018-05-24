<?php

namespace app\admin\model;

use think\Model;

class ToolOperateLog extends Model
{
    // 表名
    protected $table = 'tool_operate_log';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'expire_time_text',
        'begin_time_text',
        'use_time_text',
        'create_time_text'
    ];
    protected $connection = 'db_config_slog';






    public function getExpiretimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['expire_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getBegintimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['begin_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getUsetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['use_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setExpiretimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setBegintimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setUsetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function getOperateTypelist()
    {
        //:1@获取,2@过期，3@使用
        return ['1' => '获取','2' =>'过期','3' =>'使用'];
    }


    public function getGetTypelist()
    {
        //:1@购买,2@系统赠送,3@玩家赠送,4@游戏获得
        return ['1' => '购买','2' =>'系统赠送','3' =>'玩家赠送',4=>'游戏获得'];
    }
}
