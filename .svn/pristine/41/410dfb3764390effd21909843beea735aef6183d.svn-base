<?php

namespace app\admin\controller\agent\manage;

use app\admin\controller\agent\Base;
use app\admin\model\Agent;
use app\admin\model\AgentDetails;

use app\admin\model\AgentUserRelation;
use helper\Code;
use helper\Constant;
use helper\Func;
use think\Controller;
use think\Exception;
use think\Request;

class Agentrelation extends Base
{

    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
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
        $day = request()->param('day','all');//从代理、玩家详情页跳转增加的处理
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

        $model = new AgentUserRelation();
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('pkey_name'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $model->where($where)
                ->where(['bind_type'=>$model::BIND_TYPE_AGENT])
                ->where(['bind_time'=>['between',[$start_time,$end_time]]])
                ->order($sort, $order)
                ->count();

            $list = $model->with('user,agentUser')
                ->where($where)
                ->where(['bind_type'=>$model::BIND_TYPE_AGENT])
                ->where(['bind_time'=>['between',[$start_time,$end_time]]])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            $result = array("total" => $total, "rows" => $list);

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
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $model = new AgentUserRelation();
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
                    $remark = $params['remark'];
                    $mid = $row['mid'];
                    $sid = $row['sid'];
                    $admin_id = $this->admin['id'];
                    $admin_name = $this->admin['nickname'];
                    $bind_level = $row['bind_level'];

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
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

    /**
     * 解绑
     */
    public function del($ids='')
    {
        $model = new AgentUserRelation();
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

}
