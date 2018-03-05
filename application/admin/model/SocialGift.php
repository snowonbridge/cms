<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class SocialGift extends Model
{
    // 表名
    protected $table = 'social_gift';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];


    protected $connection="db_config2";

    public  static $redisKey = 'AT_10';

    public static function getKey($model)
    {
        return self::$redisKey."|{$model->activity_id}";
    }
    protected static function init()
    {
        SocialGift::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        SocialGift::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        SocialGift::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        SocialGift::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }







}
