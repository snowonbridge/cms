<?php

namespace app\admin\model;

use think\Model;

class ExchangeConfig extends Model
{
    // 表名
    protected $connection = 'database.db_config1';
    protected $name = 'poker_exchange_config';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'start_time_text',
        'end_time_text',
        'type_text',
        'status_text',
        'broadscast_text'
    ];
    

    
    public function getTypelist()
    {
        return ['3' => __('Type 3'),'2' => __('Type 2'),'1' => __('Type 1')];
    }     

    public function getStatuslist()
    {
        return ['on' => __('On'),'off' => __('Off')];
    }     

    public function getBroadscastlist()
    {
        return ['y' => __('Y'),'n' => __('N')];
    }


    public function getLooplist()
    {
        return ['1' => __('Y'),'0' => __('N')];
    }


    public function getStarttimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['start_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getEndtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['end_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getTypeTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['type'];
        $list = $this->getTypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getBroadscastTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['broadscast'];
        $list = $this->getBroadscastList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setStarttimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setEndtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
