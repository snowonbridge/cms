<?php

namespace app\admin\model;

use think\Model;

class PokerUserGift extends Model
{
    // 表名
    protected $table = 'poker_user_gift';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'gettime_text'
    ];

    protected $connection = 'db_config_poker';

    



    public function getGettimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['gettime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setGettimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function getMTypeList()
    {
        return [1=>'金币',2=>'钻石',3=>'房卡'];
    }
    public function getRefList()
    {
        return [1 => '加好友赠送', 2=> '邀请赠送', 3 => '出售商品'];
    }

}
