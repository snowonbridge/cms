<?php

namespace app\admin\model;


use think\Model;

class AgentBalanceLog extends Model
{
    protected $connection = 'db_config_agent';

    //加钱减钱，1加 2减
    const FLAG_IN = 1 ;
    const FLAG_OUT = 2 ;

    //类型（0无 1房卡 2钻石）
    const LOG_TYPE_NONE = 0 ;
    const LOG_TYPE_CARD = 1 ;
    const LOG_TYPE_DIAMOND = 2 ;

    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

}