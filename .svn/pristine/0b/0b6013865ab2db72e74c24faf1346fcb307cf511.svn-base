<?php

namespace app\admin\controller\agent\manage;

use app\admin\controller\agent\Base;

use app\admin\model\Agent;
use app\admin\model\AgentDetails;
use app\admin\model\AgentProfitLog;
use helper\Code;
use helper\Func;
use think\Controller;
use think\Exception;
use think\Request;

class Waitingdown extends Base
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
        $model = new AgentProfitLog();
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
           // if ($this->request->isPost())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('pkey_name'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
           /* $total = $model->where($where)
                ->order($sort, $order)
                ->count();*/
            $agent_level_rule = config('agent_level_rule');

            $days = Func::getWeekRange(date('Ymd'));
            $start_time = strtotime("{$days['sdate']} -7 day"); //上周一
            $end_time = strtotime("{$days['edate']} -7 day"."23:59:59");//上周日

            $sql_count = "
SELECT
COUNT(agent_details.id) as num
 FROM agent_details
LEFT JOIN
(SELECT SUM(profit_money) AS profit_money_sum,sid,agent_id,id FROM agent_profit_log WHERE create_time BETWEEN {$start_time} AND {$end_time} GROUP BY sid,agent_id ) tmp
ON tmp.agent_id=agent_details.agent_id AND tmp.sid = agent_details.sid
WHERE agent_details.player_count < (CASE WHEN agent_details.agent_level=1 THEN {$agent_level_rule['down'][2]['member']} WHEN agent_details.agent_level=2 THEN {$agent_level_rule['down'][3]['member']} ELSE 0 END)
AND (tmp.profit_money_sum < (CASE WHEN agent_details.agent_level=1 THEN {$agent_level_rule['down'][2]['profit']} WHEN agent_details.agent_level=2 THEN {$agent_level_rule['down'][3]['profit']} ELSE 0 END) OR tmp.profit_money_sum IS NULL)
";
            $total = $model->query($sql_count);
            $total = $total[0]['num'];

           /* $list = $model->with('agent')->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();*/
            $sql = "
SELECT
agent_details.player_count,IFNULL(tmp.profit_money_sum,0) AS profit_money_sum ,agent_details.agent_id,agent_details.sid,agent_details.agent_level,agent_details.id
 FROM agent_details LEFT JOIN
(SELECT SUM(profit_money) AS profit_money_sum,sid,agent_id,id FROM agent_profit_log WHERE create_time BETWEEN {$start_time} AND {$end_time} GROUP BY sid,agent_id ) tmp
ON tmp.agent_id=agent_details.agent_id AND tmp.sid = agent_details.sid
WHERE agent_details.player_count < (CASE WHEN agent_details.agent_level=1 THEN {$agent_level_rule['down'][2]['member']} WHEN agent_details.agent_level=2 THEN {$agent_level_rule['down'][3]['member']} ELSE 0 END)
AND (tmp.profit_money_sum < (CASE WHEN agent_details.agent_level=1 THEN {$agent_level_rule['down'][2]['profit']} WHEN agent_details.agent_level=2 THEN {$agent_level_rule['down'][3]['profit']} ELSE 0 END) OR tmp.profit_money_sum IS NULL)
ORDER BY tmp.profit_money_sum DESC,agent_details.player_count DESC
LIMIT {$offset},{$limit};";

            $list = $model->query($sql);
             $arr = [];
            foreach($list as $v){

                if($v['agent_level']==1){
                    $down_member = $agent_level_rule['down'][3]['member']>$v['player_count'];
                    $down_profit = $agent_level_rule['down'][3]['profit']>$v['profit_money_sum'];
                    if($down_member&&$down_profit){
                        $down_level = 3;
                    }else{
                        $down_level = 2;
                    }
                }else{
                    $down_level = 3;
                }

                $arr[]=[
                    'id' => $v['id'],
                    'sid' => $v['sid'],
                    'agent_id' => $v['agent_id'],
                    'agent_level' => $v['agent_level'],
                    'player_count' => $v['player_count'],
                    'profit_money_sum' => $v['profit_money_sum']/100,
                    'op_level' => $down_level,
                ];
            }

            //var_dump($total);
           // var_dump($arr);
            //exit;

            $result = array("total" => $total, "rows" => $arr);

            return json($result);
        }
        return $this->view->fetch();
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

}
