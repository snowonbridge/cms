<?php

namespace app\admin\model;

use helper\Okey;
use think\Cache;
use think\Db;
use think\Model;

class PlayerUser extends Model
{
    protected $connection = 'database.db_config1';
    // 表名
    protected $name = 'poker_user';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

    protected static function init()
    {
        PlayerUser::afterUpdate(function ($playerUser) {//更新后删除用户缓存
            $list = Db::connect(config('db_config_poker'))->table('poker_user_map')->where(['mid'=>$playerUser['id']])->select();
            if($list){
                $redis = Cache::store('redis');
                foreach($list as $v){
                    $redis->rm(Okey::rU($v['uid']));
                }
            }
        });
        PlayerUser::afterDelete(function ($playerUser) {
            $list = Db::connect(config('db_config_poker'))->table('poker_user_map')->where(['mid'=>$playerUser['id']])->select();
            if($list){
                $redis = Cache::store('redis');
                foreach($list as $v){
                    $redis->rm(Okey::rU($v['uid']));
                }
            }
        });
    }

    // 追加属性
    protected $append = [
        'usex_text',
        'ustatus_text',
        'regtime_text',
        'location_info',
    ];

    public function getUsexlist()
    {
        return ['0' => __('Usex 0'),'1' => __('Usex 1'),'2' => __('Usex 2')];
    }     

    public function getUstatuslist()
    {
        return ['0' => __('Ustatus 0'),'1' => __('Ustatus 1'),'2' => __('Ustatus 2')];
    }     


    public function getUsexTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['usex'];
        $list = $this->getUsexList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getUstatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['ustatus'];
        $list = $this->getUstatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getRegtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['regtime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setRegtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function getLocationInfoAttr($value, $data)
    {
        $PokerUcCityInfoModel = model('PokerUcCityInfo');
        $regionList = $PokerUcCityInfoModel->getRegionList();
        $cityList = $PokerUcCityInfoModel->getCityList();
        $region = isset($regionList[$data['region_id']]) ? $regionList[$data['region_id']] : '';
        $city = isset($cityList[$data['city_id']]) ? $cityList[$data['city_id']] : '';
        return $region.$city;
    }

}
