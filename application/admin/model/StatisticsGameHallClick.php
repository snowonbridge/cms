<?php

namespace app\admin\model;

use app\admin\model\Traits\PartitionsByQuarter;
use think\Model;

class StatisticsGameHallClick extends Model
{


    use PartitionsByQuarter;
    protected  $connection= 'database.db_config1';
    // 表名
    protected $name = 'poker_statistics_game_hall_click';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];

    protected function initialize() {
        $this->get_month_submeter();
    }


}
