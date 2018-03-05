<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class GiftDailySetting extends Model
{
    // 表名
    protected $table = 'gift_daily_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'create_time_text'
    ];

    protected $connection="db_firstlogin";
    



    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public  static $redisKey = 'RGiftDailySetting';
    protected static function init()
    {
        GiftDailySetting::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
        GiftDailySetting::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });

        GiftDailySetting::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
        GiftDailySetting::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
    }
}
