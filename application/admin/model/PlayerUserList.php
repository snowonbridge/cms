<?php

namespace app\admin\model;

use helper\Okey;
use think\Cache;
use think\Db;
use think\Model;

class PlayerUserList extends Model
{
    protected $connection = 'database.db_config1';
    // 表名
    public $name = 'poker_usergame';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;


    // 追加属性
    protected $append = [
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


    public function getTblname(){
        return $this->name;
    }

    public function getTableNameByField($field = '')
    {
        $tbls = [
            'poker_user' => ['id','openid', 'usertype', 'unid', 'usex', 'uname', 'avartar', 'avartar_type', 'gid', 'ustatus', 'uemail', 'devid', 'region_id', 'regtime', 'city_id', 'personality_signature'],
            'poker_usergame' => ['chip', 'coffer_chip', 'ulevel', 'exp', 'vip', 'roomcard', 'diamond', 'activetime', 'invite', 'ldays', 'cldays', 'prestige', 'gameid', 'charge', 'prestige_level', 'mentercount', 'wincnt', 'losecnt', 'drawcnt', 'lwincnt', 'hlwin', 'zjh_level', 'mj_level', 'nn_level', 'texas_level', 'ddz_level', 'lhd_level', 'subsidy_count', 'novitiate_receive_count', 'sid_regtime', 'total_online_time', 'player_type', 'player_type_force']
        ];
        $filter = array_filter($tbls, function ( $fields,$tbl) use($field) {
            return in_array($field,$fields);
        }, ARRAY_FILTER_USE_BOTH);
       return !$filter ? null : key($filter);
    }


}
