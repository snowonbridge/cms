<?php

namespace app\admin\model;


use think\Model;

class AgentProfitLog extends Model
{
    protected $connection = 'db_config_agent';

    //订单类型（0无 1房卡 2钻石）
    const ORDER_TYPE_NONE = 0 ;
    const ORDER_TYPE_ROOMCARD = 1 ;
    const ORDER_TYPE_DIAMOND = 2 ;

    //收益类型（1直属玩家 2下级代理 3下级代理直属玩家 4隔代代理 5隔代直属玩家 6全线业绩 7代理自身充值）
    const PROFIT_TYPE_UNDER_PLAYER=1;
    const PROFIT_TYPE_UNDER_AGENT=2;
    const PROFIT_TYPE_UNDER_AGENT_BY_PLAYER=3;
    const PROFIT_TYPE_GRAND_AGENT=4;
    const PROFIT_TYPE_GRAND_PLAYER=5;
    const PROFIT_TYPE_ALL_LOWER_LEVEL=6;
    const PROFIT_TYPE_AGENT_SELF=7;

    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    // 追加属性
    protected $append = [
        'order_type_text',
        'profit_type_text',
    ];


    public function getOrderTypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['order_type'];
        $list = [self::ORDER_TYPE_ROOMCARD => '房卡',self::ORDER_TYPE_DIAMOND => '钻石'];
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getProfitTypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['profit_type'];
        $list = [
            self::PROFIT_TYPE_UNDER_PLAYER => '直属玩家',
            self::PROFIT_TYPE_UNDER_AGENT => '下级代理',
            self::PROFIT_TYPE_UNDER_AGENT_BY_PLAYER => '下级代理直属玩家',
            self::PROFIT_TYPE_GRAND_AGENT => '隔代代理',
            self::PROFIT_TYPE_GRAND_PLAYER => '隔代直属玩家',
            self::PROFIT_TYPE_ALL_LOWER_LEVEL => '全线业绩',
            self::PROFIT_TYPE_AGENT_SELF => '代理自身充值',
        ];
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getAgentRuleAttr($value)
    {
        $value = $value*100 ;
        return round($value,2);
        //return number_format($value,2);
    }


    public function getOrderMoneyAttr($value)
    {
        $value = $value/100 ;
        return $value;
    }

    public function getProfitMoneyAttr($value)
    {
        $value = $value/100 ;
        return $value;
    }

    public function getLeftMoneyAttr($value)
    {
        $value = $value/100 ;
        return $value;
    }

    public function getSumProfit($agent_id,$sid,$start_time,$end_time){

        $sql=" SELECT
        agent_id,sid,
        IFNULL(SUM(profit_money)/100,0) as all_sum,
        SUM(CASE WHEN order_type=1 THEN profit_money ELSE 0 END)/100 as card_sum,
        SUM(CASE WHEN order_type=2 THEN profit_money ELSE 0 END)/100 as diamond_sum
        FROM agent_profit_log
        WHERE agent_id={$agent_id} AND sid={$sid}  AND create_time BETWEEN {$start_time} AND {$end_time}
        ";
        $list = $this->query($sql);

        $sql1=" SELECT
        agent_id,sid,
        IFNULL(SUM(order_money)/100,0) as all_order_sum,
        SUM(CASE WHEN order_type=1 THEN order_money ELSE 0 END)/100 as card_order_sum,
        SUM(CASE WHEN order_type=2 THEN order_money ELSE 0 END)/100 as diamond_order_sum
        FROM (
        SELECT agent_id,sid,order_type,order_money,profit_money,from_mid
        FROM agent_profit_log
        WHERE agent_id={$agent_id} AND sid={$sid}  AND create_time BETWEEN {$start_time} AND {$end_time}
        GROUP BY order_id
        ) tmp
        ";

        $list1 = $this->query($sql1);
        return array_merge($list[0],$list1[0]);
    }


    public function getSumProfitByType($agent_id,$sid,$start_time,$end_time,$profit_type_str){

       /* $sql=" SELECT
        agent_id,from_mid,sid,profit_type,
        SUM(CASE WHEN order_type=1 THEN profit_money ELSE 0 END)/100 as card_sum,
        SUM(CASE WHEN order_type=1 THEN order_money ELSE 0 END)/100 as card_order_sum,
        SUM(CASE WHEN order_type=2 THEN profit_money ELSE 0 END)/100 as diamond_sum,
        SUM(CASE WHEN order_type=2 THEN order_money ELSE 0 END)/100 as diamond_order_sum
        FROM agent_profit_log
        WHERE agent_id={$agent_id} AND sid={$sid} AND create_time>={$start_time} AND profit_type IN ($profit_type_str)
        ";*/
        $sql=" SELECT
        agent_id,sid,
        SUM(CASE WHEN order_type=1 THEN profit_money ELSE 0 END)/100 as card_sum
        FROM agent_profit_log
        WHERE agent_id={$agent_id} AND sid={$sid} AND profit_type IN ($profit_type_str) AND create_time BETWEEN {$start_time} AND {$end_time}
        ";
        $list = $this->query($sql);

        $sql1=" SELECT
        agent_id,sid,
        SUM(CASE WHEN order_type=1 THEN order_money ELSE 0 END)/100 as card_order_sum
        FROM
        (
        SELECT agent_id,sid,order_type,order_money,profit_money,from_mid
        FROM agent_profit_log
        WHERE agent_id={$agent_id} AND sid={$sid} AND profit_type IN ($profit_type_str) AND create_time BETWEEN {$start_time} AND {$end_time}
        GROUP BY order_id
        ) tmp

        ";
        $list1 = $this->query($sql1);
        return array_merge($list[0],$list1[0]);
    }

    public function getPlayerSumProfit($mid,$sid,$start_time,$end_time){

        $sql=" SELECT
        from_mid,sid,
        IFNULL(SUM(profit_money)/100,0) as all_sum,
        SUM(CASE WHEN order_type=1 THEN profit_money ELSE 0 END)/100 as card_sum,
        SUM(CASE WHEN order_type=2 THEN profit_money ELSE 0 END)/100 as diamond_sum
        FROM agent_profit_log
        WHERE from_mid={$mid} AND sid={$sid}  AND create_time BETWEEN {$start_time} AND {$end_time}
        ";
        $list = $this->query($sql);

        $sql1=" SELECT
        from_mid,sid,
        IFNULL(SUM(order_money)/100,0) as all_order_sum,
        SUM(CASE WHEN order_type=1 THEN order_money ELSE 0 END)/100 as card_order_sum,
        SUM(CASE WHEN order_type=2 THEN order_money ELSE 0 END)/100 as diamond_order_sum
        FROM
        (
        SELECT agent_id,sid,order_type,order_money,profit_money,from_mid
        FROM agent_profit_log
        WHERE from_mid={$mid} AND sid={$sid}  AND create_time BETWEEN {$start_time} AND {$end_time}
        GROUP BY order_id
        ) tmp
        ";
        $list1 = $this->query($sql1);
        return array_merge($list[0],$list1[0]);
    }


    public function getPlayerSumProfitByType($mid,$sid,$start_time,$end_time,$profit_type_str){

        /* $sql=" SELECT
         agent_id,from_mid,sid,profit_type,
         SUM(CASE WHEN order_type=1 THEN profit_money ELSE 0 END)/100 as card_sum,
         SUM(CASE WHEN order_type=1 THEN order_money ELSE 0 END)/100 as card_order_sum,
         SUM(CASE WHEN order_type=2 THEN profit_money ELSE 0 END)/100 as diamond_sum,
         SUM(CASE WHEN order_type=2 THEN order_money ELSE 0 END)/100 as diamond_order_sum
         FROM agent_profit_log
         WHERE agent_id={$agent_id} AND sid={$sid} AND create_time>={$start_time} AND profit_type IN ($profit_type_str)
         ";*/
        $sql=" SELECT
        from_mid,sid,
        SUM(CASE WHEN order_type=1 THEN profit_money ELSE 0 END)/100 as card_sum
        FROM agent_profit_log
        WHERE from_mid={$mid} AND sid={$sid} AND profit_type IN ($profit_type_str) AND create_time BETWEEN {$start_time} AND {$end_time}
        ";
        $list = $this->query($sql);

        $sql1=" SELECT
        from_mid,sid,
        SUM(CASE WHEN order_type=1 THEN order_money ELSE 0 END)/100 as card_order_sum
        FROM
        (
        SELECT agent_id,sid,order_type,order_money,profit_money,from_mid
        FROM agent_profit_log
        WHERE from_mid={$mid} AND sid={$sid} AND profit_type IN ($profit_type_str) AND create_time BETWEEN {$start_time} AND {$end_time}
        GROUP BY order_id
        ) tmp
        ";
        $list1 = $this->query($sql1);
        return array_merge($list[0],$list1[0]);
    }
}