<?php

namespace app\admin\model;

use app\admin\model\Traits\PartitionsByQuarter;
use think\Config;
use think\Model;

class Order extends Model
{

    use PartitionsByQuarter;
    // 表名
    protected $name = 'poker_order';
    protected $connection = 'database.db_config1';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'pstime_text',
        'petime_text'
    ];


    protected $info = [];
    protected $info_field = '';

    protected function initialize() {
        $this->get_month_submeter();

    }


    public function getPstimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['pstime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getPetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['petime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setPstimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setPetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }






}
