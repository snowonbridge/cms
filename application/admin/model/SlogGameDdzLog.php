<?php

namespace app\admin\model;

use think\Model;

class SlogGameDdzLog extends Model
{
    // 表名
    protected $name = 'slog_game_ddz_log';
    protected $connection = 'database.db_config_slog';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

}
