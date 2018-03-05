<?php

namespace app\admin\model;

use think\Model;

class HundredWarTotalStat extends Model
{
    // 表名
    protected $connection = 'database.db_config1';
    protected $name = 'poker_hundred_war_total_stat';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'update_time_text'
    ];
    

    



    public function getUpdatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['update_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setUpdatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
