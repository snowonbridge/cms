<?php

namespace app\admin\model;

use helper\Okey;
use think\Cache;
use think\Model;

class PlayerUsergame extends Model
{

    protected $connection = 'database.db_config1';
    // 表名
    protected $name = 'poker_usergame';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'activetime_text'
    ];


    protected static function init()
    {
        PlayerUsergame::afterUpdate(function ($PlayerUsergame) {//更新后删除用户缓存
             $redis = Cache::store('redis');
             $redis->rm(Okey::rU($PlayerUsergame['uid']));
        });
        PlayerUsergame::afterDelete(function ($PlayerUsergame) {
            $redis = Cache::store('redis');
            $redis->rm(Okey::rU($PlayerUsergame['uid']));
        });
    }


    public function getActivetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['activetime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setActivetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
