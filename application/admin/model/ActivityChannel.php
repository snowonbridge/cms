<?php

namespace app\admin\model;

use think\cache\driver\Redis;
use think\Model;

class ActivityChannel extends Model
{
    // 表名
    protected $table = 'activity_channel';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'status_text',
    ];

    protected $connection="db_config2";



    
    public function getStatuslist()
    {
        return ['1' => 'normal','0' => 'hidden'];
    }     

//    public function getProvincelist()
//    {
//        return ['台湾省' => __('台湾省'),'江西省' => __('江西省'),'甘肃省' => __('甘肃省'),'青海省' => __('青海省'),'贵州省' => __('贵州省'),'云南省' => __('云南省'),'四川省' => __('四川省'),'海南省' => __('海南省'),'福建省' => __('福建省'),'江苏省' => __('江苏省'),'浙江省' => __('浙江省'),'安徽省' => __('安徽省'),'陕西省' => __('陕西省'),'山西省' => __('山西省'),'山东省' => __('山东省'),'湖北省' => __('湖北省'),'河南省' => __('河南省'),'河北省' => __('河北省'),'吉林省' => __('吉林省'),'辽宁省' => __('辽宁省'),'黑龙江省' => __('黑龙江省'),'广东省' => __('广东省'),'湖南省' => __('湖南省')];
//    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

 
//    public function getProvinceTextAttr($value, $data)
//    {
//        $value = $value ? $value : $data['province'];
//        $valueArr = explode(',', $value);
//        $list = $this->getProvinceList();
//        return implode(',', array_intersect_key($list, array_flip($valueArr)));
//    }

    public function getChannelList()
    {
        $list = $this->where(['status'=>1])->select();

        return $list;
    }
    //AT_25
    public  static $redisKey = 'AT_25';

    public static function getKey($model)
    {
        return self::$redisKey;
    }
    protected static function init()
    {
        ActivityChannel::beforeInsert(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ActivityChannel::beforeUpdate(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });

        ActivityChannel::beforeDelete(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
        ActivityChannel::beforeWrite(function ($model) {
            $redis = new Redis(config('redis'));
            $redis->rm(self::getKey($model));
        });
    }



}