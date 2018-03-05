<?php

namespace app\admin\model;


use helper\Func;
use helper\Okey;
use think\Cache;
use think\Model;

class AgentUserRelation extends Model
{
    protected $connection = 'db_config_agent';

    //关系类型（1直属玩家 2代理 ）
    const BIND_TYPE_PLAYER = 1 ;
    const BIND_TYPE_AGENT = 2 ;

    protected $autoWriteTimestamp = true;
    protected $createTime = false;
    protected $updateTime = 'bind_time';

    protected static function init()
    {
        AgentUserRelation::afterWrite(function ($agentUserRelation) {
            $redis = Cache::store('redis')->handler();
            $data = $agentUserRelation->data;
            $redis->setex(Okey::rAgentUserRelationOne($data['mid'],$data['sid']),86400,json_encode($data));
        });
    }

    public function agent(){
        return $this->belongsTo('Agent','agent_id','agent_id');
    }


    public function agentUser(){
        return $this->belongsTo('PokerUser','agent_id','id');
    }

    public function user(){
        return $this->belongsTo('PokerUser','mid','id');
    }

    // 追加属性
    protected $append = [
        'bind_type_text',
    ];

    public function getBindTypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['bind_type'];
        $list = [
            self::BIND_TYPE_PLAYER => '直属玩家',
            self::BIND_TYPE_AGENT => '代理',
        ];
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function findRelationByMid($mid,$sid)
    {
        return $this->where([
            'mid' => $mid,
            'sid' => $sid,
        ])->find();

    }

    public function isMyChildPlayer($relation,$agent_id){
        $res = false;
        if(empty($relation)) return $res;
        if($relation['agent_id']==$agent_id && $relation['bind_type']==self::BIND_TYPE_PLAYER){
            $res = true;
        }
        return $res;
    }

    public function isMyChildAgent($relation,$agent_id){
        $res = false;
        if(empty($relation)) return $res;
        if($relation['agent_id']==$agent_id && $relation['bind_type']==self::BIND_TYPE_AGENT){
            $res = true;
        }
        return $res;
    }

    public function isCanBindPlayer($mid,$sid){
        $relation = $this->findRelationByMid($mid,$sid);
        if($relation){
            return ['code'=>-1,'msg'=>'用户已被绑定'];//已绑定
        }
        return ['code'=>1,'msg'=>''];
    }

    public function isCanBindAgent($mid,$sid,$agent_id){
        $relation = $this->findRelationByMid($mid,$sid);
        if($this->isMyChildAgent($relation,$agent_id)){
            return ['code'=>-1,'msg'=>'已绑定'];//已绑定
        }
        if(!$this->isMyChildPlayer($relation,$agent_id)){
            return ['code'=>0,'msg'=>'该用户不是你的直属玩家，不可授权'];//已绑定
        }
        return ['code'=>1,'msg'=>''];
    }

    public function getSumRelation($agent_id,$sid,$start_time,$end_time){

        $sql=" SELECT
        SUM(CASE WHEN bind_type=1 THEN 1 ELSE 0 END) as player_count,
        SUM(CASE WHEN bind_type=2 THEN 1 ELSE 0 END) as agent_count
        FROM agent_user_relation
        WHERE agent_id={$agent_id} AND sid={$sid}  AND bind_time BETWEEN {$start_time} AND {$end_time}
        ";
        $list = $this->query($sql);
        return $list[0];
    }


    /**
     * 获取最长关系链
     * @param $mid
     * @param $sid
     * @param array $arr
     * @param int $i
     * @return array
     */
    public function getUserRelationChain($mid, $sid, &$arr = array(), $i = 0)
    {
        $times = 7;//3.最大为查找7次，直到隔5代为止
        $times = 6;//3.最大为查找7次，直到隔5代为止
        $relationModel = new AgentUserRelation();

        if ($i < $times) {
            $relation = $relationModel->where(['mid' => $mid, 'sid' => $sid,])->find();
            if (empty($relation)) {
                return $arr;//2.关系不存在 则跳出循环
            }
            $arr[] = [
                'id' => $relation['id'],
                'agent_id' => $relation['agent_id'],
                'sid' => $relation['sid'],
                'mid' => $relation['mid'],
                'bind_type' => $relation['bind_type'],
                'bind_level' => $relation['bind_level'],
                'bind_time_text' => date('Y-m-d H:i:s',$relation['bind_time']),
            ];
            if (in_array($relation['agent_id'], config('company_agent'))) {
                return $arr;//1.上级是官方代理,则跳出循环
            }
            $i += 1;
            $this->getUserRelationChain($relation['agent_id'], $sid, $arr, $i);
        }
        return $arr;
    }

    public function getUserRelationChainDetail($mid, $sid){
        $agentDetailsModel = new AgentDetails();
        $getUserRelationChain = $this->getUserRelationChain($mid, $sid);
        $arr=[];
        if($getUserRelationChain){
            $agent_id_arr = array_column($getUserRelationChain,'agent_id');
            $agent_list = $agentDetailsModel->where(['sid'=>$sid])->where(['agent_id'=>['in',$agent_id_arr]])->select();
            $agent_list = Func::array_index($agent_list,'agent_id');
            //$mid_arr = array_column($getUserRelationChain,'mid');
            $user_list = (new PokerUser())->where(['id'=>['in',$agent_id_arr]])->select();
            $user_list = Func::array_index($user_list,'id');

            foreach($getUserRelationChain as $k=>$v){

                $nickname = isset($user_list[$v['agent_id']]['uname'])?$user_list[$v['agent_id']]['uname']:'无';//上级昵称
                if(isset($agent_list[$v['agent_id']])){
                    $arr[] = [
                        'id' => $v['id'],
                        'mid' => $v['mid'],
                        'agent_id' => $v['agent_id'],
                        'agent_level' => $agent_list[$v['agent_id']]['agent_level'],
                        'bind_time_text' => $v['bind_time_text'],
                        'nickname' => $nickname,
                    ];

                }elseif(in_array($v['agent_id'], config('company_agent'))){
                    $arr[] = [
                        'id' => $v['id'],
                        'mid' => $v['mid'],
                        'agent_id' => $v['agent_id'],
                        'agent_level' => '无',
                        'bind_time_text' => $v['bind_time_text'],
                        'nickname' => '官方代理',
                    ];

                }else{
                    $arr[] = [
                        'id' => 0,
                        'mid' => 0,
                        'agent_id' => 0,
                        'agent_level' => '无',
                        'bind_time_text' => '无',
                        'nickname' => '失效代理',
                    ];
                }
            }
        }
        return $arr;
    }

}