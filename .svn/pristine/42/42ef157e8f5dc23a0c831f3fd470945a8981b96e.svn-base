<?php

namespace app\admin\controller\agent\manage;

use app\admin\controller\agent\Base;
use app\admin\model\Agent;
use app\admin\model\AgentDetails;

use app\admin\model\AgentProfitLog;
use app\admin\model\AgentUserRelation;
use app\admin\model\PokerUser;
use helper\Code;
use helper\Constant;
use helper\Func;
use think\console\command\make\Model;
use think\Controller;
use think\Db;
use think\Exception;
use think\Request;

class Index extends Base
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        //$this->model = model('AgentDetails');
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 查看
     */
    public function index()
    {
        $model = model('AgentDetails');
        $this->model = $model;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        //if ($this->request->isPost())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('pkey_name'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams(null,true);
/*            $total = $model->where($where)
                ->order($sort, $order)
                ->count();

            $list = $model->with('agent')->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();*/

            $total = $model->with('agentjoin')->where($where)
                ->order($sort, $order)
                ->count();

            $list = $model->with('agentjoin')->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();


            if(empty($list)){
                $total_balance = 0;
                $money = 0;
                $settlement_money = 0;
            }else{
                $list = $list->toArray();

                /*$agentList = array_column($list,'agent');
                $total_balance = array_sum(array_column($agentList,'total_balance'));
                $money = array_sum(array_column($agentList,'money'));
                $settlement_money = $total_balance-$money;*/
                $agent_id_list = array_column($list,'agent_id');
                $total_balance = (new Agent())->where(['agent_id'=>['in',$agent_id_list]])->sum('total_balance');
                $money = (new Agent())->where(['agent_id'=>['in',$agent_id_list]])->sum('money');
                $settlement_money = $total_balance-$money;
            }
            $result = array(
                "total" => $total,
                "rows" => $list,
                'total_balance'=>number_format($total_balance/100,2),
                'money'=>number_format($money/100,2),
                'settlement_money'=>number_format($settlement_money/100,2)
            );

            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
            if ($params)
            {
                foreach ($params as $k => &$v)
                {
                    $v = is_array($v) ? implode(',', $v) : $v;
                }

                try
                {
                    $agent_id = $params['agent_id'];
                    $remark = $params['remark'];
                    $mid = $params['mid'];
                    $sid = $params['sid'];
                    $admin_id = $this->admin['id'];
                    $admin_name = $this->admin['nickname'];
                    $bind_level = $params['bind_level'];

                    $model = new Agent();
                    $result = $model->updateBindAgent($agent_id,$mid,$sid,$admin_id,$admin_name,$remark,$bind_level);

                    if ($result['code'] == Code::SUCCESS)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($result['msg']);
                    }
                }
                catch (Exception $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch('',['agentLevelList'=>[1=>'一级代理',2=>'二级代理',3=>'三级代理'],'offlineSidList'=>Constant::getOfflineSidList()]);
    }

    /**
     * 编辑等级
     */
    public function edit($ids = NULL)
    {
        $model = new AgentDetails();
        $row = $model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
            if ($params)
            {
                foreach ($params as $k => &$v)
                {
                    $v = is_array($v) ? implode(',', $v) : $v;
                }

                try
                {
                    $sid = $params['sid'];
                    $agent_id = $params['agent_id'];
                    $remark = $params['remark'];
                    $agent_level = $params['agent_level'];
                    $admin_id = $this->admin['id'];
                    $admin_name = $this->admin['nickname'];

                    $model = new Agent();
                    $result = $model->changeAgentLevel($agent_id,$sid,$agent_level,$admin_id,$admin_name,$remark);

                    if ($result['code'] == Code::SUCCESS)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($result['msg']);
                    }
                }
                catch (Exception $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch('',['agentLevelList'=>[1=>'一级代理',2=>'二级代理',3=>'三级代理']]);
    }


    /**
     * 解绑
     */
    public function unbind($sid='',$mid='')
    {
        $model = new AgentUserRelation();
        $row = $model->where(['sid'=>intval($sid),'mid'=>intval($mid)])->find();
        if (!$row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
            if ($params)
            {

                foreach ($params as $k => &$v)
                {
                    $v = is_array($v) ? implode(',', $v) : $v;
                }

                try
                {
                    $remark = $params['remark'];
                    $mid = $params['mid'];
                    $sid = $params['sid'];
                    $admin_id = $this->admin['id'];
                    $admin_name = $this->admin['nickname'];

                    $model = new Agent();
                    $result = $model->unbindRelation($mid, $sid, $admin_id, $admin_name,$remark);

                    if ($result['code'] == Code::SUCCESS)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($result['msg']);
                    }
                }
                catch (Exception $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {
        $model = new AgentDetails();
        $row = $model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
            if ($params)
            {
                foreach ($params as $k => &$v)
                {
                    $v = is_array($v) ? implode(',', $v) : $v;
                }

                try
                {
                    $agent_id = $params['agent_id'];
                    $sid = $params['sid'];
                    $status = isset($params['status'])?$params['status']:$model::STATUS_OFF;

                    $model = new AgentDetails();

                    if($status == $model::STATUS_ON){
                        $result = $model->unDeleteAgentDetails($agent_id,$sid);
                    }elseif($status == $model::STATUS_OFF){
                        $result = $model->deleteAgentDetails($agent_id,$sid);
                    }else{
                        $result = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'参数错误','data'=>[]];
                    }

                    if ($result['code'] == Code::SUCCESS)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($result['msg']);
                    }
                }
                catch (Exception $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    public function info($agent_id,$day='all')
    {
        if ($this->request->isAjax()){
            return $this->getInfo($agent_id,$day);
        }
        return $this->view->fetch();
    }

    public function getInfo($agent_id,$day='all')
    {
        $model = new Agent();
        $agentProfitLogModel = new AgentProfitLog();
        $agentUserRelationModel = new AgentUserRelation();
        $agentDetailsModel =new AgentDetails();

        if (empty($agent_id)){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'没有数据','data'=>[]];
            return json($res);
        }

        if($day=='today'){
            $start_time = strtotime(date('Ymd'));
            $end_time = time();
        }elseif($day=='week'){
            $dayArr = Func::getWeekRange(date('Ymd'));
            $start_time = strtotime($dayArr['sdate']);
            $end_time = time();
        }elseif($day=='month'){
            $dayArr = Func::getMonthRange(date('Ymd'));
            $start_time = strtotime($dayArr['sdate']);
            $end_time = time();
        }else{
            $start_time = 0;
            $end_time = time();
        }

        $row = $model->with('user')->where(['agent_id'=>$agent_id])->find();


        $agentDetails = $agentDetailsModel->where(['agent_id'=>$agent_id])->select()->toArray();

        if ($row && $agentDetails) {

            $parent_agent_id_arr = array_column($agentDetails,'parent_agent_id');//上级昵称查找
            $parent_users = (new PokerUser())->where(['id'=>['in',$parent_agent_id_arr]])->select();

            $parent_users = Func::array_index($parent_users,'id');

            foreach($agentDetails as $k=>$v){

                if(isset($parent_users[$v['parent_agent_id']])){
                    $uname = $parent_users[$v['parent_agent_id']]['uname'];
                    //$agent_level = $agentDetailsModel->where(['agent_id'=>$v['parent_agent_id'],'sid'=>$v['sid']])->find()['agent_level'];
                }elseif(in_array($v['parent_agent_id'], config('company_agent'))){
                    $uname = '官方代理';
                    //$agent_level = '无';
                }else{
                    $uname = '无';
                    //$agent_level = '无';
                }
                $agentDetails[$k]['parent_user'] = [
                    'uname'=>$uname,
                    //'agent_level'=>$agent_level,
                ];

                $getSumProfit = $agentProfitLogModel->getSumProfit($v['agent_id'],$v['sid'],$start_time,$end_time);
                $agentDetails[$k]['all_sum'] = number_format($getSumProfit['all_sum'],2);
                $agentDetails[$k]['all_order_sum'] = number_format($getSumProfit['all_order_sum'],2);
                $agentDetails[$k]['card_sum'] = number_format($getSumProfit['card_sum'],2);
                $agentDetails[$k]['card_order_sum'] = number_format($getSumProfit['card_order_sum'],2);
                $agentDetails[$k]['diamond_sum'] = number_format($getSumProfit['diamond_sum'],2);
                $agentDetails[$k]['diamond_order_sum'] = number_format($getSumProfit['diamond_order_sum'],2);

                //收益类型（1直属玩家 2下级代理 3下级代理直属玩家 4隔代代理 5隔代直属玩家 6全线业绩 7代理自身充值）
                $getSumProfitByType = $agentProfitLogModel->getSumProfitByType($v['agent_id'],$v['sid'],$start_time,$end_time,'1,7');
                $agentDetails[$k]['player_card_sum'] = number_format($getSumProfitByType['card_sum'],2);
                $agentDetails[$k]['player_card_order_sum'] = number_format($getSumProfitByType['card_order_sum'],2);

                $getSumProfitByType = $agentProfitLogModel->getSumProfitByType($v['agent_id'],$v['sid'],$start_time,$end_time,'2,3');
                $agentDetails[$k]['agent_card_sum'] = number_format($getSumProfitByType['card_sum'],2);
                $agentDetails[$k]['agent_card_order_sum'] = number_format($getSumProfitByType['card_order_sum'],2);

                $getSumProfitByType = $agentProfitLogModel->getSumProfitByType($v['agent_id'],$v['sid'],$start_time,$end_time,'4,5');
                $agentDetails[$k]['gedai_card_sum'] = number_format($getSumProfitByType['card_sum'],2);
                $agentDetails[$k]['gedai_card_order_sum'] = number_format($getSumProfitByType['card_order_sum'],2);

                $getSumProfitByType = $agentProfitLogModel->getSumProfitByType($v['agent_id'],$v['sid'],$start_time,$end_time,'6');
                $agentDetails[$k]['qx_card_sum'] = number_format($getSumProfitByType['card_sum'],2);
                $agentDetails[$k]['qx_card_order_sum'] = number_format($getSumProfitByType['card_order_sum'],2);

                //关系类型（1直属玩家 2代理 ）
                $getSumProfitByType = $agentUserRelationModel->getSumRelation($v['agent_id'],$v['sid'],strtotime(date('Ymd')),time());
                $agentDetails[$k]['player_sum'] = number_format($getSumProfitByType['player_count']);
                $agentDetails[$k]['agent_sum'] = number_format($getSumProfitByType['agent_count']);

            }

            $res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>['agentInfo'=>$row,'agentDetails'=>$agentDetails]];
            //$res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>['agentInfo'=>$row,'agentDetails'=>array_merge($agentDetails,$agentDetails)]];
            return json($res);

        }else{
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'没有数据','data'=>[]];
            return json($res);
        }

    }

    public function playerinfo($mid,$day='all')
    {
        if ($this->request->isAjax()){
           return $this->getPlayerInfo($mid,$day);
        }
        return $this->view->fetch();
    }

    public function getPlayerInfo($mid,$day='all')
    {
        //$model = new Agent();
        $agentProfitLogModel = new AgentProfitLog();
        $agentUserRelationModel = new AgentUserRelation();

        if (empty($mid)){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'没有数据','data'=>[]];
            return json($res);
        }

        if($day=='today'){
            $start_time = strtotime(date('Ymd'));
            $end_time = time();
        }elseif($day=='week'){
            $dayArr = Func::getWeekRange(date('Ymd'));
            $start_time = strtotime($dayArr['sdate']);
            $end_time = time();
        }elseif($day=='month'){
            $dayArr = Func::getMonthRange(date('Ymd'));
            $start_time = strtotime($dayArr['sdate']);
            $end_time = time();
        }else{
            $start_time = 0;
            $end_time = time();
        }

        $sid_arr = $agentUserRelationModel->where(['mid'=>$mid])->column('sid');

        $row = (new PokerUser())->where(['id'=>$mid])->find();

        if ($sid_arr) {

            $userDetails = [];
            foreach($sid_arr as $k=>$sid){

                $userDetails[$k]['sid'] = $sid;
                $relationChainDetails = $agentUserRelationModel->getUserRelationChainDetail($mid,$sid);
                $userDetails[$k]['relationChainDetails'] = $relationChainDetails;

                $getSumProfit = $agentProfitLogModel->getPlayerSumProfit($mid,$sid,$start_time,$end_time);
                $userDetails[$k]['all_sum'] = number_format($getSumProfit['all_sum'],2);
                $userDetails[$k]['all_order_sum'] = number_format($getSumProfit['all_order_sum'],2);
                $userDetails[$k]['card_sum'] = number_format($getSumProfit['card_sum'],2);
                $userDetails[$k]['card_order_sum'] = number_format($getSumProfit['card_order_sum'],2);
                $userDetails[$k]['diamond_sum'] = number_format($getSumProfit['diamond_sum'],2);
                $userDetails[$k]['diamond_order_sum'] = number_format($getSumProfit['diamond_order_sum'],2);

                //收益类型（1直属玩家 2下级代理 3下级代理直属玩家 4隔代代理 5隔代直属玩家 6全线业绩 7代理自身充值）
                $getSumProfitByType = $agentProfitLogModel->getPlayerSumProfitByType($mid,$sid,$start_time,$end_time,'1,2,3,7');
                $userDetails[$k]['agent_card_sum'] = number_format($getSumProfitByType['card_sum'],2);
                $userDetails[$k]['agent_card_order_sum'] = number_format($getSumProfitByType['card_order_sum'],2);

                $getSumProfitByType = $agentProfitLogModel->getPlayerSumProfitByType($mid,$sid,$start_time,$end_time,'4,5');
                $userDetails[$k]['gedai_card_sum'] = number_format($getSumProfitByType['card_sum'],2);
                $userDetails[$k]['gedai_card_order_sum'] = number_format($getSumProfitByType['card_order_sum'],2);

                $getSumProfitByType = $agentProfitLogModel->getPlayerSumProfitByType($mid,$sid,$start_time,$end_time,'6');
                $userDetails[$k]['qx_card_sum'] = number_format($getSumProfitByType['card_sum'],2);
                $userDetails[$k]['qx_card_order_sum'] = number_format($getSumProfitByType['card_order_sum'],2);

            }

            $res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>['userInfo'=>$row,'userDetails'=>$userDetails]];
            //$res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>['userInfo'=>$row,'userDetails'=>array_merge($userDetails,$userDetails)]];
            return json($res);

        }else{
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'没有数据','data'=>[]];
            return json($res);
        }

    }
}
