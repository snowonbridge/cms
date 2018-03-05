<?php

namespace app\admin\model;


use think\Model;

class AgentRelationChangeLog extends Model
{
    protected $connection = 'db_config_agent';

    //变动来源（0-未知，1-上级调整，2-后台调整）
    const FLAG_UNKNOWN = 0;
    const FLAG_AGENT = 1;
    const FLAG_ADMIN = 2;

    //变动类型（0-绑定直属玩家，1-授权更改，2-解绑）
    const CHANGE_TYPE_BIND_PLAYER = 0;
    const CHANGE_TYPE_BIND_AGENT = 1;
    const CHANGE_TYPE_UNBIND = 2;

    //解绑前的绑定关系类型（1直属玩家 2代理）
    const OLD_BIND_TYPE_PLAYER = 1;
    const OLD_BIND_TYPE_AGENT = 2;

    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    public function agent(){
        return $this->belongsTo('Agent','agent_id','agent_id');
    }

    public function pokerUser(){
        return $this->belongsTo('PokerUser','mid','id');
    }

    // 追加属性
    protected $append = [
        'flag_text',
        'change_type_text',
        'old_bind_type_text',
    ];

    public function getChangeTypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['change_type'];
        $list = [
            self::CHANGE_TYPE_BIND_PLAYER => '绑定直属玩家',
            self::CHANGE_TYPE_BIND_AGENT => '授权更改',
            self::CHANGE_TYPE_UNBIND => '解绑'
        ];
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getFlagTextAttr($value, $data)
    {
        $value = $value ? $value : $data['flag'];
        $list = [
            self::FLAG_ADMIN => '后台调整',
            self::FLAG_AGENT => '上级调整',
            self::FLAG_UNKNOWN => ''
        ];
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getOldBindTypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['old_bind_type'];
        $list = [
            self::OLD_BIND_TYPE_PLAYER => '直属玩家',
            self::OLD_BIND_TYPE_AGENT => '代理',
        ];
        return isset($list[$value]) ? $list[$value] : '';
    }
}