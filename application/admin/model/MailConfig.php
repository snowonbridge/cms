<?php

namespace app\admin\model;

use think\Model;

class MailConfig extends Model
{
    // 表名
    protected $connection = 'database.db_config1';
    // 表名
    protected $name = 'poker_mail';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

    // 追加属性
    protected $append = [
        'con_type_text',
        'sendtime_text',
        'status_text'
    ];



    public function getContypelist()
    {
        return ['3' => __('Con_type 3'),'2' => __('Con_type 2'),'1' => __('Con_type 1')];
    }
    public function getTypelist()
    {
        return ['1' => __('Type 1'),'0' => __('Type 0')];
    }

    public function getStatuslist()
    {
        return ['completed' => __('Completed'),'delete' => __('Delete'),'normal' => __('Normal')];
    }


    public function getContypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['con_type'];
        $list = $this->getContypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getSendtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['sendtime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setSendtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
