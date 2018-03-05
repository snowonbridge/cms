<?php
/**
 * 产生KEY的php函数集中营
 * Redis 统一用r开头
 * memcache 用m开头
 */
namespace helper;
class Okey {
    const EX_ONE_DAY=86400;//3600*24
    const EX_ONE_HOUR=3600;//3600
    const EX_ONE_MINUTE=60;//
    const EX_ONE_MONTH=2678400;
    static function rIpLimit(){ return "RIPLIMIT";}
    static  function rU($uid){ return "RU|{$uid}";}
    static function rUid( $openid, $pf ) { return "UID|{$openid}|{$pf}"; } //用户信息key
    static function rMsg( $uid) { return "RMSG|{$uid}"; } //用户信息key

    //用户行为锁
    public static function rLockUserAction($uid,$scene_id)
    {
        return "LOCKUSERACTION|{$uid}|{$scene_id}";
    }

    //代理 玩家充值成功--订单佣金待计算队列
    public static function rAgentPlayerRechargeList()
    {
        return 'LIST_AGENT_PLAYER_RECHARGE';
    }

    public static function rAgentUserRelationOne($mid,$sid) { return "AGENT_USER_RELATION_ONE|{$mid}|{$sid}"; } //代理-用户关系证明key,用于是否绑定、是否代理

    //百度淘宝省、城市编号
    public static function rUcCityInfo() { return 'UC_CITY_INFO'; }

    //控制--游戏app版本列表
    public static function rControlAppList($sid) { return 'CONTROL_APP_LIST|'.$sid; }//string
    //控制--渠道设置
    public static function rControlStoreSetting($app_id) { return 'CONTROL_STORE_SETTING|'.$app_id; }//string
    //控制--游戏app版本列表
    public static function rControlAreaSetting($app_id) { return 'CONTROL_AREA_SETTING|'.$app_id; }//string
    //控制-时间策略
    public static function rControlTimeCommonSetting() { return 'CONTROL_TIME_COMMON_SETTING'; }//string

}