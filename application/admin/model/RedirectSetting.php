<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class RedirectSetting extends Model
{
    // 表名
    protected $table = 'redirect_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];

    protected $connection="db_config2";



    public  static $redisKey = 'SGIFTCONTENTSETTING';

    public static function getKey($model)
    {
        return self::$redisKey;
    }
    protected static function init()
    {
        RedirectSetting::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        RedirectSetting::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        RedirectSetting::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        RedirectSetting::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }






}
