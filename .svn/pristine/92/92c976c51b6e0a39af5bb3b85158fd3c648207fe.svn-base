<?php

namespace app\admin\model;

use think\Model;

class UserExchangeRecord extends Model
{
    // 表名
    protected $name = 'poker_user_exchange_log';
    protected $connection = 'database.db_config1';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'log_time_text',
        'status_text'
    ];
    

    
    public function getStatuslist()
    {
        return ['incomplete' => __('Incomplete'),'inprogress' => __('Inprogress'),'completed' => __('Completed')];
    }     


    public function getLogtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['log_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setLogtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
