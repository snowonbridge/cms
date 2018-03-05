<?php

namespace app\admin\model;

use think\Config;
use think\Model;

class User extends Model
{
    // 表名
    protected $name = 'poker_user';
    protected $connection = 'database.db_config1';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;


    // 追加属性
    protected $append = [
        'regtime_text',
    ];

    public function getRegtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['regtime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function onlineInfo(){
        return $this->hasMany('PokerOnline','uid','id');
    }

//    public function userGame(){
//        //hasManyThrough('关联模型名','中间模型名','外键名','中间模型关联键名','当前模型主键名',['模型别名定义']);
//        return $this->hasManyThrough('PokerUserGame','PokerUserMap','uid','mid','id');
//
//    }

}
