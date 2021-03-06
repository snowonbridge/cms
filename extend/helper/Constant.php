<?php
/**
 * Created by PhpStorm.
 * User: nihao
 * Date: 17-10-26
 * Time: 下午7:34
 */

namespace helper;


class Constant {


    //订单类型（0无 1房卡 2钻石）
    const  ORDER_TYPE_NONE=0;
    const  ORDER_TYPE_ROOMCARD=1;
    const  ORDER_TYPE_DIAMOND=2;


    //收益类型（1直属玩 家2下级代理 3下级代理直属玩家 4隔代代理 5隔代直属玩家 6全线业绩 7代理自身充值）
    const PROFIT_TYPE_UNDER_PLAYER=1;
    const PROFIT_TYPE_UNDER_AGENT=2;
    const PROFIT_TYPE_UNDER_AGENT_BY_PLAYER=3;
    const PROFIT_TYPE_GRAND_AGENT=4;
    const PROFIT_TYPE_GRAND_PLAYER=5;
    const PROFIT_TYPE_ALL_LOWER_LEVEL=6;
    const PROFIT_TYPE_AGENT_SELF=7;

    //关系类型（1直属玩家 2代理 ）
    const BIND_TYPE_PLAYER = 1 ;
    const BIND_TYPE_AGENT = 2 ;


    const GAME_ID_ZJH = 1001;//炸金花	2	1	1
    const GAME_ID_LHD = 1002;//	龙虎斗	4	1	1
    const GAME_ID_NN = 1003;//	牛牛	5	1	1
    const GAME_ID_DDZ = 1004;//	斗地主	1	1	1
    const GAME_ID_MJ = 1005;//	麻将	3	1	1

    const PLATFORM_ONLINE = 10001;//线上
    const PLATFORM_OFFLINE = 10002;//线下
    static public function getAllsid()
    {
        return [self::PLATFORM_OFFLINE];
    }
    //审核状态（0未审核,1审核通过,2审核拒绝,3提现成功,4提现失败
    const PAY_STATUS_AUDIT_UNREAD = 0;
    const PAY_STATUS_AUDIT_PASS = 1;
    const PAY_STATUS_AUDIT_REJECT = 2;
    const PAY_STATUS_SETTLEMENT_PASS = 3;
    const PAY_STATUS_SETTLEMENT_FAIL = 4;

    //充值类型查询今日充值，本周充值，本月充值，累计充值
    const TYPE_CHARGE_TODAY = 1;
    const TYPE_CHARGE_WEEK = 2;
    const TYPE_CHARGE_MONTH = 3;
    const TYPE_CHARGE_ALL = 4;

    //1人工转账 2微信企业结算 3银行
    const SETTLEMENT_TYPE_ADMIN = 1;
    const SETTLEMENT_TYPE_WX = 2;
    const SETTLEMENT_TYPE_BANK = 3;

    static public function getSidText($sid){
        $cfg = config('sidList');
        $list = [
            self::PLATFORM_ONLINE => $cfg[self::PLATFORM_ONLINE],
            self::PLATFORM_OFFLINE =>$cfg[self::PLATFORM_OFFLINE],
        ];
        return isset($list[$sid])?$list[$sid]:'';
    }

/*    static public function getOfflineSidList(){
        $list = [
            [
                'sid'=>self::PLATFORM_OFFLINE,
                'text'=>'欢乐棋牌',
            ],
        ];
        return $list;
    }*/

    static public function getOfflineSidList(){
        $cfg = config('sidList');
        $list = [
                self::PLATFORM_OFFLINE=> self::PLATFORM_OFFLINE.$cfg[self::PLATFORM_OFFLINE],
        ];
        return $list;
    }

    //状态（0失效 1正常 ）
    const STATUS_ON = 1;//正常
    const STATUS_OFF = 0;//失效

} 