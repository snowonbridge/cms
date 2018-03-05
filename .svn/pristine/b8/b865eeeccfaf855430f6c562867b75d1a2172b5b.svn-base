<?php

namespace app\admin\model;


use think\Model;

class AgentLevelChangeLog extends Model
{
    protected $connection = 'db_config_agent';

    //变动来源（0-未知，1-达标自动调整，2-后台调整）
    const FLAG_UN_KNOW = 0 ;
    const FLAG_AUTO = 1 ;
    const FLAG_ADMIN = 2 ;

    //升降标识（1升 2降）
    const CHANGE_TYPE_UP = 1 ;
    const CHANGE_TYPE_DOWN = 2 ;

    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = false;

    public function agent(){
        return $this->belongsTo('Agent','agent_id','agent_id');
    }

  /*  public function pokerUser(){
        return $this->belongsTo('PokerUser','mid','id');
    }*/

    // 追加属性
    protected $append = [
        'flag_text',
        'change_type_text',
    ];

    public function getChangeTypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['change_type'];
        $list = [
            self::CHANGE_TYPE_UP => '升级',
            self::CHANGE_TYPE_DOWN => '降级',
        ];
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getFlagTextAttr($value, $data)
    {
        $value = $value ? $value : $data['flag'];
        $list = [
            self::FLAG_AUTO => '自动调整',
            self::FLAG_ADMIN => '后台调整',
        ];
        return isset($list[$value]) ? $list[$value] : '';
    }
    /**
     * 升降级标识返回
     * @param $old_level
     * @param $left_level
     * @return int
     */
    public static function getChangeType($old_level,$left_level){
         if(in_array($old_level,[1,2,3])){
             if(in_array($left_level,[1,2,3])){
                 if($old_level > $left_level){
                     $res = self::CHANGE_TYPE_UP;
                 }else{
                     $res = self::CHANGE_TYPE_DOWN;
                 }
             }else{
                 $res = self::CHANGE_TYPE_UP;
             }
         }else{//预留 4区域代理 5全国递增
             if($old_level < $left_level){
                 $res = self::CHANGE_TYPE_UP;
             }else{
                 $res = self::CHANGE_TYPE_DOWN;
             }
         }
         return $res;
    }

}