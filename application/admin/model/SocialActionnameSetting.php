<?php

namespace app\admin\model;

use think\Model;

class SocialActionnameSetting extends Model
{
    // 表名
    protected $table = 'social_actionname_setting';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];

    protected $connection="db_config2";

    







}
