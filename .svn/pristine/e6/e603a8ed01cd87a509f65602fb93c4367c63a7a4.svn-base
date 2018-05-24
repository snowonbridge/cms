<?php

namespace app\admin\model;

use think\Model;

class UserExchangeApply extends Model
{
    // 表名
    protected $name = 'poker_user_exchange_apply';
    protected $connection = 'database.db_config1';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'apply_time_text',
        'status_text',
        'opt_time_text'
    ];
    

    
    public function getStatuslist()
    {
        return ['1' => __('Appling'),'2' => __('Accepted'),'3' => __('Reject')];
    }     


    public function getApplytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['apply_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getOpttimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['opt_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setApplytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setOpttimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
