<?php

namespace app\admin\model;

use think\Model;

class PokerFriendApply extends Model
{
    // 表名
    protected $table = 'poker_friend_apply';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'agree_time_text',
        'unbind_time_text'
    ];

    protected $connection = 'database.db_config1';

    



    public function getAgreetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['agree_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getUnbindtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['unbind_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAgreetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setUnbindtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function getStatusList()
    {
        return ['0'=>'未读','1'=>'已读'];
    }
    public function getFriendStatusList()
    {
//        return ['0'=>'申请中','1'=>'同意','2'=>'被拒绝','3'=>'解绑好友关系'];
        return ['1'=>'结为好友','3'=>'解绑好友关系'];
    }

}
