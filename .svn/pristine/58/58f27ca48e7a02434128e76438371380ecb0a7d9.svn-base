<?php

namespace app\admin\model;

use app\admin\model\Traits\PartitionsByQuarter;
use think\Model;

class StatisticsGameEntry extends Model
{

    use PartitionsByQuarter;
    protected  $connection= 'database.db_config1';
    // 表名
    protected $name = 'poker_statistics_game_entry';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'flag_text',
        'level_text'
    ];
    protected function initialize() {
        $this->get_month_submeter();
    }

    public function getFlagList(){
        return ['enter'=>__('Enter'),'fast'=>__('Fast'),'play'=>__('Play'),'record'=>__('Record'),'time'=>__('Time'),'bankrupt'=>__('Bankrupt')];
    }

    public function getFlagTextAttr($value, $data)
    {
        $value = $value ? $value : $data['flag'];
        $list = $this->getFlagList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getGameLevelList(){
        return ['1'=>__('tabletypes_1'),'2'=>__('tabletypes_2'),'3'=>__('tabletypes_3')];
    }

    public function getLevelTextAttr($value, $data)
    {
        $value = $value ? $value : $data['level'];
        $list = $this->getGameLevelList();
        return isset($list[$value]) ? $list[$value] : '';
    }



}
