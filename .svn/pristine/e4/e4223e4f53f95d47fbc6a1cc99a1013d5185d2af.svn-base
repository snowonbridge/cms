<?php

namespace app\admin\model;

use think\Model;

class ExchangeTypeConfig extends Model
{
    // 表名
    protected $connection = 'database.db_config1';
    protected $name = 'poker_exchange_type_config';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'type_text',
        'status_text'
    ];
    

    
    public function getTypelist()
    {
        return ['3' => __('Type 3'),'2' => __('Type 2'),'1' => __('Type 1')];
    }     

    public function getStatuslist()
    {
        return ['off' => __('Off'),'on' => __('On')];
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




}
