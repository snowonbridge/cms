<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class TurnLotterySetting extends Model
{
    // 表名
    protected $name = 'turn_lottery_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];



    protected $connection="db_config2";

    public  static $redisKey = 'AT_23';
    protected static function init()
    {
        TurnLotterySetting::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
        TurnLotterySetting::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });

        TurnLotterySetting::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
        TurnLotterySetting::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
    }





}
