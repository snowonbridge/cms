<?php

namespace app\admin\model;

use think\Model;

class MonthCardSetting extends Model
{
    // 表名
    protected $name = 'poker_month_card_setting';
    protected $connection = 'database.db_config1';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'status_text',
        'ptypes_text'
    ];
    

    
    public function getStatuslist()
    {
        return ['off' => __('Off'),'on' => __('On')];
    }     

    public function getPtypeslist()
    {
        return ['5' => __('Ptypes 5'),'2' => __('Ptypes 2'),'3' => __('Ptypes 3')];
    }     


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPtypesTextAttr($value, $data)
    {
        $value = $value ? $value : $data['ptypes'];
        $valueArr = explode(',', $value);
        $list = $this->getPtypesList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }




}
