<?php

namespace app\admin\model;

use think\Model;

class FriendLog extends Model
{
    // 表名
    protected $table = 'friend_log';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'operate_time_text',
        'create_time_text'
    ];


    protected $connection = 'db_config_slog';




    public function getOperatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['operate_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setOperatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function getOperateTypeList()
    {
        return ['1'=>'结为好友','2'=>'解除好友'];
    }
    public function getFTypeList()
    {
        return ['1'=>'主动','2'=>'被动'];
    }

}
