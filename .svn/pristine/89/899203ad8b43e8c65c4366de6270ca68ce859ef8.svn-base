<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class ConsumptionConfig extends Model
{
    // 表名
    protected $table = 'consumption_config';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'create_time_text'
    ];

    protected $connection="db_config2";

    



    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


    public  static $redisKey = 'AT_3';

    public static function getKey($model)
    {
        return self::$redisKey."|{$model->id}";
    }
    protected static function init()
    {
        ConsumptionConfig::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ConsumptionConfig::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        ConsumptionConfig::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ConsumptionConfig::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }
}
