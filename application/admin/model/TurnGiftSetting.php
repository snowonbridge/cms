<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class TurnGiftSetting extends Model
{
    // 表名
    protected $name = 'turn_gift_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'level_text',
        'create_time_text'
    ];
    protected $connection = 'db_config2';

    
    public function getLevellist()
    {
        return ['3' => __('普通型'),'4' => __('稀有型'),'2' => __('大众型'),'1' => __('白送型')];
    }     


    public function getLevelTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['level'];
        $list = $this->getLevelList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public  static $redisKey = 'AT_22';
    protected static function init()
    {
        TurnGiftSetting::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
        TurnGiftSetting::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });

        TurnGiftSetting::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
        TurnGiftSetting::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::$redisKey);
        });
    }
}
