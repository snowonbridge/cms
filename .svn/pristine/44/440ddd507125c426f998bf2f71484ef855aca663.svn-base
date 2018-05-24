<?php

namespace app\admin\model;

use think\Model;

class UserMonthCard extends Model
{
    // 表名
    protected $name = 'poker_user_month_card';
    protected $connection = 'database.db_config1';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'buy_time_text',
        'expir_time_text',
        'ptype_text',
    ];
    

    



    public function getBuytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['buy_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getExpirtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['expir_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setBuytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setExpirtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }



    public function getPtypeslist()
    {
        return ['5' => __('Ptypes 5'),'2' => __('Ptypes 2'),'3' => __('Ptypes 3')];
    }


    public function getPtypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['ptype'];
        $valueArr = explode(',', $value);
        $list = $this->getPtypesList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }

}
