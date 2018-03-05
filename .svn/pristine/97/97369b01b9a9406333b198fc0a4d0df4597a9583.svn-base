<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class ActivityNotice extends Model
{
    // 表名
    protected $table = 'activity_notice';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    protected $connection="db_config2";


    public  static $redisKey = 'AT_1';

    public static function getKey($model)
    {
        return self::$redisKey."|{$model->sid}";
    }
    protected static function init()
    {
        ActivityNotice::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ActivityNotice::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        ActivityNotice::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ActivityNotice::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }








}
