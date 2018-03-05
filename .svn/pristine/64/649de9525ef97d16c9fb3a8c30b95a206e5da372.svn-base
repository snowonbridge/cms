<?php

namespace app\admin\model;

use helper\Code;
use think\Db;
use think\Log;
use think\Model;

class Agent extends Model
{
    protected $connection = 'db_config_agent';

    const STATUS_ON = 1;//正常
    const STATUS_OFF = 0;

    protected $auto = [];//新增和更新

    protected $insert = [//新增
        'mobile' => '',
        'password' => '',
        'total_balance' => 0,
        'money' => 0,
        'freeze_money' => 0,
    ];

    protected $update = [//修改

    ];

    protected $autoWriteTimestamp = true;
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    protected $hidden = ['password', 'salt',];

    public function agentDetails(){
        return $this->hasMany('AgentDetails','agent_id','agent_id');
    }

    public function user(){
        return $this->belongsTo('PokerUser','agent_id','id');
    }

    // 追加属性
    protected $append = [
        'status_text',
        'total_settlement_money',
        'last_settlement_time_text',
    ];


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : $data['status'];
        $list = [self::STATUS_OFF => __('status 0'),self::STATUS_ON => __('status 1')];
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getMoneyAttr($value)
    {
        $value = $value/100 ;
        return $value;
    }

    public function getTotalBalanceAttr($value)
    {
        $value = $value/100 ;
        return $value;
    }

    public function getTotalSettlementMoneyAttr($value,$data)
    {
        $value = $value ? $value : $data['total_balance'] - $data['money'];
        $value = $value/100 ;
        return $value;
    }

    public function getLastSettlementTimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['last_settlement_time'];
        if(empty($value)){
            return '无';
        }
        return date('Y-m-d H:i:s',$value);
    }

    public function createBindPlayerByAdmin($agent_id, $mid, $sid, $admin_id,$admin_name, $remark)
    {

        $relationModel = new AgentUserRelation();
        $relationLogModel = new AgentRelationChangeLog();
        $detailsModel = new AgentDetails();
        $pokerUserModel = new PokerUser();

        if (!in_array($sid, config('agent_sid'))) {//todo 是否有效有效游戏id
            return ['code' => Code::CODEGAMDIDERR, 'msg' => '游戏sid参数错误'];
        }

        if (empty($admin_id)) {
            return ['code' => Code::CODE_ERR_AUTH, 'msg' => '没有权限'];
        }

        if (empty($remark)) {
            return ['code' => Code::CODE_ERR_PARAM, 'msg' => '备注不能为空'];
        }

        $relation = $relationModel->findRelationBymid($mid, $sid);
        if ($relation) {
            return ['code' => Code::CODEERRPARAM, 'msg' => '用户已被绑定，如需更改请先解绑后进行再绑定直属玩家操作'];
        }

        if (!in_array($agent_id, config('company_agent'))) {
            $agent = $detailsModel->isAgent($agent_id, $sid);
            if (!$agent) {
                return ['code' => Code::CODE_AGENT_NOEXISTS, 'msg' => 'agent_id不是代理,请先添加成为代理'];//被绑的不是代理
            }
        }

        $user = $pokerUserModel->getUserById($mid);
        if (!$user) {//todo 是否有效用户
            return ['code' => Code::CODEUSERNOEXISTS, 'msg' => '用户不存在'];
        }


        $detailsModel->startTrans();
        $data['agent_id'] = $agent_id;
        $data['sid'] = $sid;
        $data['mid'] = $mid;
        $data['bind_type'] = $relationModel::BIND_TYPE_PLAYER;//关系类型（0代理 1直属玩家）
        $data['bind_level'] = 0;
        $data['first_agent_id'] = $agent_id;//首次绑定的代理id
        $updateRes = $relationModel->save($data);

        $incrRes = true;
        if (!in_array($agent_id, config('company_agent'))) {
            $incrRes = $detailsModel->save(['player_count' => ['exp','player_count+1']], ['agent_id' => $agent_id, 'sid' => $sid]);
        }

        $log['mid'] = $mid;
        $log['sid'] = $sid;
        $log['left_agent_id'] = $agent_id;
        $log['old_agent_id'] = 0;
        $log['change_type'] = 0;//变动类型（0-绑定直属玩家，1-授权更改，2-解绑）
        $log['flag'] = $relationLogModel::FLAG_ADMIN;//变动来源（0-未知，1-上级调整，2-后台调整）
        $log['left_agent_level'] = 0;
        $log['old_agent_level'] = 0;
        $log['old_bind_type'] = 0;
        $log['admin_id'] = $admin_id;
        $log['admin_name'] = $admin_name;
        $log['remark'] = $remark;
        $logRes = $relationLogModel->save($log);
        if ($updateRes && $logRes && $incrRes) {
            $detailsModel->commit();
            $res = ['code' => Code::SUCCESS, 'msg' => '成功'];
        } else {
            $detailsModel->rollBack();
            Log::error(__METHOD__ . ' ' . var_export('数据库更新失败', true));
            $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新失败'];
        }

        return $res;
    }

    public function createBindAgentByAdmin($agent_id, $mid, $sid, $bind_level, $admin_id,$admin_name, $remark)
    {
        $relationModel = new AgentUserRelation;
        $relationLogModel = new AgentRelationChangeLog;
        $detailsModel = new AgentDetails();
        $pokerUserModel = new PokerUser();

        if (!in_array($sid, config('agent_sid'))) {//todo 是否有效有效游戏id
            return ['code' => Code::CODEGAMDIDERR, 'msg' => '游戏id参数错误'];
        }

        if (empty($admin_id)) {
            return ['code' => Code::CODE_ERR_AUTH, 'msg' => '没有权限'];
        }

        if (empty($remark)) {
            return ['code' => Code::CODE_ERR_PARAM, 'msg' => '备注不能为空'];
        }

        if (!in_array($bind_level, [1, 2, 3])) {
            return ['code' => Code::CODEERRPARAM, 'msg' => 'bind_level参数错误'];
        }

        $relation = $relationModel->findRelationBymid($mid, $sid);
        if ($relation) {
            return ['code' => Code::CODEERRPARAM, 'msg' => '用户已被绑定，如需更改请先解绑后再进行授权操作'];
        }

        if (!in_array($agent_id, config('company_agent'))) {
            $agent = $detailsModel->isAgent($agent_id, $sid);
            if (!$agent) {
                return ['code' => Code::CODE_AGENT_NOEXISTS, 'msg' => 'agent_id不是代理,请先添加成为代理'];//被绑的不是代理
            }
        }

        $user = $pokerUserModel->getUserById($mid);
        if (!$user) {//todo 是否有效用户
            return ['code' => Code::CODEUSERNOEXISTS, 'msg' => '用户不存在'];
        }

        if ($user['usertype'] != 3) {//todo 是否微信用户
            return ['code' => Code::CODEERRAUTH, 'msg' => '微信用户才能成为代理哦'];
        }

        $detailsModel->startTrans();
        $data['agent_id'] = $agent_id;
        $data['sid'] = $sid;
        $data['mid'] = $mid;
        $data['bind_type'] = $relationModel::BIND_TYPE_AGENT;//关系类型（0代理 1直属玩家）
        $data['bind_level'] = $bind_level;
        $updateRes = $relation->save($data);

        $incrRes = true;
        if (!in_array($agent_id, config('company_agent'))) {
            $incrRes = $detailsModel->save(['agent_count' => ['exp','agent_count+1']], ['agent_id' => $agent_id, 'sid' => $sid]);
        }

        $log['mid'] = $mid;
        $log['sid'] = $sid;
        $log['left_agent_id'] = $agent_id;
        $log['old_agent_id'] = isset($relation['agent_id']) ? $relation['agent_id'] : 0;
        $log['change_type'] = $relationLogModel::CHANGE_TYPE_BIND_AGENT;//变动类型（0-绑定直属玩家，1-授权更改，2-解绑）
        $log['flag'] = $relationLogModel::FLAG_ADMIN;//变动来源（0-未知，1-上级调整，2-后台调整）
        $log['left_agent_level'] = 0;
        $log['old_agent_level'] = 0;
        $log['old_bind_type'] = 0;
        $log['admin_id'] = $admin_id;
        $log['admin_name'] = $admin_name;
        $log['remark'] = $remark;
        $logRes = $relationLogModel->save($log);

        $createAgentRes = $this->createAgent($mid, $sid, $user['openid'], $bind_level, $agent_id);

        if ($updateRes && $logRes && $incrRes && $createAgentRes) {
            $detailsModel->commit();
            $res = ['code' => Code::SUCCESS, 'msg' => '成功'];
        } else {
            $detailsModel->rollBack();
            Log::error(__METHOD__ . ' ' . var_export('数据库更新失败', true));
            $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新失败'];
        }

        return $res;
    }

    public function unbindRelation($mid, $sid, $admin_id, $admin_name,$remark)
    {
        $relationModel = new AgentUserRelation();
        $relationLogModel = new AgentRelationChangeLog();
        $detailsModel = new AgentDetails();


        if (!in_array($sid, config('agent_sid'))) {//todo 是否有效有效游戏id
            return ['code' => Code::CODEGAMDIDERR, 'msg' => '游戏id参数错误'];
        }

        if (empty($admin_id)) {
            return ['code' => Code::CODEERRAUTH, 'msg' => '没有权限'];
        }

        if (empty($remark)) {
            return ['code' => Code::CODE_ERR_PARAM, 'msg' => '备注不能为空'];
        }

        $relation = $relationModel->findRelationBymid($mid, $sid);
        $old_agent_id = $relation['agent_id'];
        $left_agent_id = config('company_agent')[array_rand(config('company_agent'))];
        if (!isset($relation['agent_id'])) {
            return ['code' => Code::CODEERRPARAM, 'msg' => '参数错误,关系不存在'];
        }

        if (in_array($relation['agent_id'], config('company_agent'))) {
            return ['code' => Code::CODEERRPARAM, 'msg' => '已经解绑'];
        }

        $detailsModel->startTrans();
        $data['agent_id'] = $left_agent_id;
        $updateRes = $relation->save($data);

        $updateDetailsRes = true;
        if ($relation['bind_type'] == $relationModel::BIND_TYPE_PLAYER) {//直属玩家关系解绑
            $incrRes = $detailsModel->save(['player_count' => ['exp','player_count-1']], ['agent_id' => $old_agent_id, 'sid' => $sid]);//上级直属玩家数量减1
            $log['left_agent_level'] = 0;
            $log['old_agent_level'] = 0;
            $log['old_bind_type'] = $relationModel::BIND_TYPE_PLAYER;
        } else {//代理关系解绑
            $details = $detailsModel->where(['agent_id' => $mid, 'sid' => $sid])->find();
            $log['left_agent_level'] = isset($details['agent_level']) ? $details['agent_level'] : 0;
            $log['old_agent_level'] = isset($details['agent_level']) ? $details['agent_level'] : 0;
            $log['old_bind_type'] = $relationModel::BIND_TYPE_AGENT;
            $updateDetailsRes = $detailsModel->save(['parent_agent_id' => $left_agent_id], ['agent_id' => $mid, 'sid' => $sid]);//更新代理详细表被解绑代理的父级代理id
            $detailsModel = new AgentDetails();//新对象
            $incrRes = $detailsModel->save(['agent_count' => ['exp','agent_count-1']], ['agent_id' => $old_agent_id, 'sid' => $sid]);//上级直属代理数量减1
        }

        $log['mid'] = $mid;
        $log['sid'] = $sid;
        $log['left_agent_id'] = $left_agent_id;
        $log['old_agent_id'] = $old_agent_id;
        $log['change_type'] = $relationLogModel::CHANGE_TYPE_UNBIND;//变动类型（0-绑定直属玩家，1-授权更改，2-解绑）
        $log['flag'] = $relationLogModel::FLAG_ADMIN;//变动来源（0-未知，1-上级调整，2-后台调整）
        $log['admin_id'] = $admin_id;
        $log['admin_name'] = $admin_name;
        $log['remark'] = $remark;
        $logRes = $relationLogModel->save($log);

        if ($updateRes && $logRes && $incrRes && $updateDetailsRes) {
            $detailsModel->commit();
            $res = ['code' => Code::SUCCESS, 'msg' => '成功'];
        } else {
            $detailsModel->rollBack();
            Log::error(__METHOD__ . ' ' . var_export('数据库更新失败', true));
            $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新失败'];
        }
        return $res;
    }


    public function updateBindPlayer($agent_id, $mid, $sid, $admin_id,$admin_name, $remark, $force = 0)
    {
        $relationModel = new AgentUserRelation();
        $relationLogModel = new AgentRelationChangeLog();
        $detailsModel = new AgentDetails();
        $relation = $relationModel->findRelationBymid($mid, $sid);
        if ($relation['bind_type'] == $relationModel::BIND_TYPE_AGENT) {
            return ['code' => Code::CODE_ERR_AUTH, 'msg' => '该玩家是代理，不可回退成为玩家'];
        }

        if ($relation['agent_id'] == $agent_id) {
            return ['code' => Code::CODE_ERR_PARAM, 'msg' => '已绑定，请勿重复操作'];
        }

        $checkAgentParam = $this->checkUpdate($agent_id, $sid, $admin_id, $relation, $force);
        if (!($checkAgentParam['code'] == Code::SUCCESS)) {
            return ['code' => $checkAgentParam['code'], 'msg' => $checkAgentParam['msg']];
        }
        $old_agent_id = $relation['agent_id'];
        $old_bind_type = $relation['bind_type'];
        $detailsModel->startTrans();
        $data['agent_id'] = $agent_id;
        $data['bind_type'] = $relationModel::BIND_TYPE_PLAYER;//关系类型（0代理 1直属玩家）
        $updateRes = $relation->save($data);

        $toIncrRes = true;
        if (!in_array($agent_id, config('company_agent'))) {
            $toIncrRes = $detailsModel->save(['player_count' => ['exp','player_count+1']], ['agent_id' => $agent_id, 'sid' => $sid]);
        }

        $log['mid'] = $mid;
        $log['sid'] = $sid;
        $log['left_agent_id'] = $agent_id;
        $log['old_agent_id'] = $old_agent_id;
        $log['change_type'] = 0;//变动类型（0-绑定直属玩家，1-授权更改，2-解绑）
        $log['flag'] = $relationLogModel::FLAG_ADMIN;//变动来源（0-未知，1-上级调整，2-后台调整）
        $log['left_agent_level'] = 0;
        $log['old_agent_level'] = 0;
        $log['old_bind_type'] = $old_bind_type;
        $log['admin_id'] = $admin_id;
        $log['admin_name'] = $admin_name;
        $log['remark'] = $remark;
        $logRes = $relationLogModel->save($log);
        if ($updateRes && $logRes && $toIncrRes) {
            $detailsModel->commit();
            $res = ['code' => Code::SUCCESS, 'msg' => '成功'];
        } else {
            $detailsModel->rollBack();
            Log::error(__METHOD__ . ' ' . var_export('数据库更新失败', true));
            $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新失败'];
        }

        return $res;
    }

    public function updateBindAgent($agent_id, $mid, $sid, $admin_id,$admin_name, $remark, $bind_level, $force = 0)
    {
        $relationModel = new AgentUserRelation();
        $relationLogModel = new AgentRelationChangeLog();
        $detailsModel = new AgentDetails();
        $pokerUserModel = new PokerUser();
        $relation = $relationModel->findRelationBymid($mid, $sid);

        if ($bind_level) {
            if (!in_array($bind_level, [1, 2, 3])) {
                return ['code' => Code::CODEERRPARAM, 'msg' => '设置的代理等级不在范围内'];
            }
            $data['bind_level'] = $bind_level;//没有设置绑定等级则为以前的等级
        }

        if (($relation['agent_id'] == $agent_id) && $relation['bind_type'] == $relationModel::BIND_TYPE_AGENT) {
            return ['code' => Code::CODE_ERR_PARAM, 'msg' => '已绑定，请勿重复操作'];
        }

        if (($relation['agent_id'] != $agent_id)) {//todo 需求更改拦截了 2.代理解绑后，进行的授权更改
            return ['code' => Code::CODE_ERR_PARAM, 'msg' => "授权用户 {$mid} 不是代理 {$agent_id}的直属玩家，不可授权"];
        }

        $checkAgentParam = $this->checkUpdate($agent_id, $sid, $admin_id, $relation, $force);
        if (!($checkAgentParam['code'] == Code::SUCCESS)) {
            return ['code' => $checkAgentParam['code'], 'msg' => $checkAgentParam['msg']];
        }

        if (!in_array($agent_id, config('company_agent'))) {//非官方代理等级授权检测
            $agent = $detailsModel->isAgent($agent_id, $sid);
            $getCanBindLevel = self::getCanBindLevel($agent['agent_level']);
            if (!in_array($bind_level, $getCanBindLevel)) {
                    return ['code' => Code::CODEERRPARAM, 'msg' => '授权等级有误,只能授权该代理以下等级'];
            }
        }

        $user = $pokerUserModel->getUserById($mid);
        if (empty($user) || $user['usertype'] != $pokerUserModel::USER_TYPE_WX) {//todo 是否微信用户
            return ['code' => Code::CODEERRAUTH, 'msg' => '微信用户才能成为代理哦'];
        }

        $old_agent_id = $relation['agent_id'];
        $old_bind_type = $relation['bind_type'];
        $detailsModel->startTrans();
        $data['agent_id'] = $agent_id;
        $data['sid'] = $sid;
        $data['mid'] = $mid;
        $data['bind_type'] = $relationModel::BIND_TYPE_AGENT;//关系类型（0代理 1直属玩家）
        $updateRes = $relation->save($data);

        $toIncrRes = true;

        if ($old_bind_type == $relationModel::BIND_TYPE_PLAYER) {//1.由直属玩家授权成为代理

            if (!in_array($agent_id, config('company_agent'))) {
                $toIncrRes = $detailsModel->save(['agent_count' => ['exp','agent_count+1'],'player_count' => ['exp','player_count-1']], ['agent_id' => $agent_id, 'sid' => $sid]);
            }

            $log['left_agent_level'] = $bind_level;
            $log['old_agent_level'] = 0;
            $createAgentRes = $this->createAgent($mid, $sid, $user['openid'], $bind_level, $agent_id);//创建代理

        } else {//2.代理解绑后，进行的授权

            if (!in_array($agent_id, config('company_agent'))) {
                $toIncrRes = $detailsModel->save(['agent_count' => ['exp','agent_count+1']], ['agent_id' => $agent_id, 'sid' => $sid]);
            }

            $detailsModel = new AgentDetails();
            $details = $detailsModel->where(['agent_id' => $mid, 'sid' => $sid])->find();
            $detailsAgentLevel = isset($details['agent_level']) ? $details['agent_level'] : 0;
            $log['left_agent_level'] = $bind_level == 0 ? $detailsAgentLevel : $bind_level;
            $log['old_agent_level'] = isset($details['agent_level']) ? $details['agent_level'] : 0;
            $createAgentRes = $details->save(['parent_agent_id' => $agent_id], ['agent_id' => $mid, 'sid' => $sid]);
        }
        $log['mid'] = $mid;
        $log['sid'] = $sid;
        $log['old_bind_type'] = $old_bind_type;
        $log['left_agent_id'] = $agent_id;
        $log['old_agent_id'] = $old_agent_id;
        $log['change_type'] = $relationLogModel::CHANGE_TYPE_BIND_AGENT;//变动类型（0-绑定直属玩家，1-授权更改，2-解绑）
        $log['flag'] = $relationLogModel::FLAG_ADMIN;//变动来源（0-未知，1-上级调整，2-后台调整）
        $log['admin_id'] = $admin_id;
        $log['admin_name'] = $admin_name;
        $log['remark'] = $remark;
        $logRes = $relationLogModel->save($log);

        if ($updateRes && $logRes && $toIncrRes && $createAgentRes) {
            $detailsModel->commit();
            $res = ['code' => Code::SUCCESS, 'msg' => '成功'];
        } else {
            $detailsModel->rollBack();
            Log::error(__METHOD__ . ' ' . var_export('数据库更新失败', true));
            $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新失败'];
        }

        return $res;
    }

    public static function getCanBindLevel($agent_level)
    {
        $arr = [];
        if (isset($agent_level)) {
            if ($agent_level == 4){
                $arr = [1, 2, 3];
            } elseif ($agent_level == 1) {
                $arr = [2, 3];
            } elseif ($agent_level == 2) {
                $arr = [3];
            } else {
                $arr = [];
            }
        }
        return $arr;
    }

    protected function checkUpdate($agent_id, $sid, $admin_id, $relation, $force = 0)
    {
        if (!in_array($sid, config('agent_sid'))) {//todo 是否有效有效游戏id
            return ['code' => Code::CODEGAMDIDERR, 'msg' => '游戏id参数错误'];
        }

        if (empty($admin_id)) {//todo
            return ['code' => Code::CODE_ERR_AUTH, 'msg' => '需要管理员权限'];
        }

        if (empty($relation)) {
            return ['code' => Code::CODE_ERR_PARAM, 'msg' => '用户还未绑定，请进行绑定关系操作'];
        }

        if($relation['agent_id'] != $agent_id){//直属玩家升级成代理的情况
            if (!in_array($relation['agent_id'], config('company_agent'))) {
                return ['code' => Code::CODE_ERR_PARAM, 'msg' => '只能在用户绑定为官方代理才能更改绑定，请先进行解绑操作'];
            }
        }

        if ($force == 0) {
            if (in_array($relation['first_agent_id'], config('company_agent'))) {
                if(!in_array($agent_id, config('company_agent'))){
                    return ['code' => Code::CODE_ERR_AUTH, 'msg' => '权限不足,用户当前首绑为官方代理'];
                }
            }
        }

        $detailsModel = new AgentDetails();
        if (!in_array($agent_id, config('company_agent'))) {
            $agent = $detailsModel->isAgent($agent_id, $sid);
            if (!$agent) {
                return ['code' => Code::CODE_AGENT_NOEXISTS, 'msg' => 'agent_id不是代理,请先添加成为代理'];//被绑的不是代理
            }
        }

        return ['code' => Code::SUCCESS, 'msg' => ''];
    }

    public function changeAgentLevel($agent_id, $sid, $agent_level, $admin_id,$admin_name, $remark)
    {

        if (!in_array($sid, config('agent_sid'))) {//todo 是否有效有效游戏id
            return ['code' => Code::CODEGAMDIDERR, 'msg' => '游戏id参数错误'];
        }

        if (!in_array($agent_level, [1, 2, 3])) {
            return ['code' => Code::CODEERRPARAM, 'msg' => '设置的代理等级不在范围内'];
        }

        if (empty($admin_id)) {
            return ['code' => Code::CODEERRAUTH, 'msg' => 'admin_id没有权限'];
        }

        if (empty($remark)) {
            return ['code' => Code::CODEERRPARAM, 'msg' => '备注不能为空'];
        }

        $detailsModel = new AgentDetails();
        $agentLevelChangeLogModel = new AgentLevelChangeLog();
        $agent = $detailsModel->isAgent($agent_id, $sid);
        if (empty($agent)) {
            return ['code' => Code::CODE_AGENT_NOEXISTS, 'msg' => '代理用户不存在'];
        } else {
            $detailsModel->startTrans();
            $data['agent_level'] = $agent_level;
            $updateRes = $detailsModel->save($data, ['agent_id' => $agent_id, 'sid' => $sid,]);
            $log['agent_id'] = $agent_id;
            $log['sid'] = $sid;
            $log['left_level'] = $agent_level;
            $log['old_level'] = $agent['agent_level'];
            $log['change_type'] = $agentLevelChangeLogModel::getChangeType($agent['agent_level'], $agent_level);
            $log['flag'] = $agentLevelChangeLogModel::FLAG_ADMIN;
            $log['admin_id'] = $admin_id;
            $log['admin_name'] = $admin_name;
            $log['remark'] = $remark;
            $logRes = $agentLevelChangeLogModel->save($log);

            if ($updateRes && $logRes) {
                $detailsModel->commit();
                $res = ['code' => Code::SUCCESS, 'msg' => '更新成功'];
            } else {
                $detailsModel->rollBack();
                Log::error(__METHOD__ . ' ' . var_export('数据库更新失败', true));
                $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新失败'];
            }
            return $res;
        }
    }

    public function createAgent($mid, $sid, $union_id, $bind_level, $agent_id)
    {
        $createRes = true;
        if (!$this->where(['mid'=>$mid])->find()) {//agent表数据已创建则忽略
            $data['union_id'] = $union_id;//todo  查找微信 union_id
            $data['agent_id'] = $mid;
            $data['mid'] = $mid;
            $createRes = $this->save($data);
        }
        $detailsData['mid'] = $mid;
        $detailsData['agent_id'] = $mid;
        $detailsData['sid'] = $sid;
        $detailsData['parent_agent_id'] = $agent_id;
        $detailsData['agent_level'] = $bind_level;
        $detailsData['bind_time'] = time();
        $detailsCreateRes = model('AgentDetails')->save($detailsData);
        return $createRes && $detailsCreateRes;
    }

    public function deleteAgent($agent_id){
        $agent = $this->where(['agent_id'=>$agent_id])->find();
        if($agent){
            $detailsModel = new AgentDetails();
            $data['status'] = $detailsModel::STATUS_OFF;
            $affected = $detailsModel->where(['agent_id'=>$agent_id])->saveAll($data);
            $updateAgent = $this->where(['agent_id'=>$agent_id])->save(['status'=>self::STATUS_OFF]);
            $detailsModel->startTrans();
            if($affected && $updateAgent){
                $detailsModel->commit();
                $res = ['code' => Code::SUCCESS, 'msg' => '成功'];
            }else{
                $detailsModel->rollback();
                $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新出错'];
            }

        }else{
            $res = ['code' => Code::CODE_ERR_PARAM, 'msg' => '不存在的代理'];
        }
        return $res;
    }

    public function unDeleteAgent($agent_id){
        $agent = $this->where(['agent_id'=>$agent_id])->find();
        if($agent){
            $detailsModel = new AgentDetails();
            $data['status'] = $detailsModel::STATUS_ON;
            $affected = $detailsModel->where(['agent_id'=>$agent_id])->saveAll($data);
            $updateAgent = $this->where(['agent_id'=>$agent_id])->save(['status'=>self::STATUS_ON]);
            $detailsModel->startTrans();
            if($affected && $updateAgent){
                $detailsModel->commit();
                $res = ['code' => Code::SUCCESS, 'msg' => '成功'];
            }else{
                $detailsModel->rollback();
                $res = ['code' => Code::OPERATE_EXCEPTION, 'msg' => '数据库更新出错'];
            }

        }else{
            $res = ['code' => Code::CODE_ERR_PARAM, 'msg' => '不存在的代理'];
        }
        return $res;
    }

}