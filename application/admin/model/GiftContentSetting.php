<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class GiftContentSetting extends Model
{
    // 表名
    protected $table = 'gift_content_setting';
    
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
        GiftContentSetting::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        GiftContentSetting::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        GiftContentSetting::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        GiftContentSetting::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }








}