<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class CrossChallegeConfig extends Model
{
    // 表名
    protected $table = 'cross_challege_config';
    
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


    public  static $redisKey = 'AT_4';

    public static function getKey($model)
    {
        return self::$redisKey."|{$model->id}";
    }
    protected static function init()
    {
        CrossChallegeConfig::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        CrossChallegeConfig::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        CrossChallegeConfig::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        CrossChallegeConfig::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }
}
