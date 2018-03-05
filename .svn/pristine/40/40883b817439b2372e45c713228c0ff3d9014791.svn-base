<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class ActivityTabSetting extends Model
{
    // 表名
    protected $table = 'activity_tab_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    protected $connection="db_config2";


    public  static $redisKey = 'AT_2';

    public static function getKey($model)
    {
        return self::$redisKey;
    }
    protected static function init()
    {
        ActivityTabSetting::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ActivityTabSetting::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        ActivityTabSetting::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ActivityTabSetting::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }









}
