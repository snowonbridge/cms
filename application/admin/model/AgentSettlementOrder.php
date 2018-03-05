<?php

namespace app\admin\model;

use think\Model;

class AgentSettlementOrder extends Model
{
    // 表名
    protected $table = 'agent_settlement_order';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'audit_time_text',
        'settlement_time_text',
        'create_time_text'
    ];


    protected $connection = 'db_config_agent';
    



    public function getAudittimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['audit_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getSettlementtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['settlement_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getCreatetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['create_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAudittimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setSettlementtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setCreatetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }






    public function getSettlementTypeList()
    {
        return ['2' => '银行','1' =>'微信'];
    }
    public function getAuditList()
    {
        return ['0' => '未审核','1' =>'审核通过','2' => '审核拒绝','3' => '提现成功','4' => '提现失败'];
    }
}
