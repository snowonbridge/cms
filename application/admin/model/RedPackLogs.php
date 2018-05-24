<?php

namespace app\admin\model;

use think\Model;

class RedPackLogs extends Model
{
    // 表名
    protected $name = 'red_pack_logs';
    protected $connection = 'database.db_larawechat';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [

    ];
    

    







}
