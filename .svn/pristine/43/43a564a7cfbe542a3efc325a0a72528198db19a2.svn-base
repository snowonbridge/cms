<?php

namespace app\admin\controller\agent\manage;

use app\admin\controller\agent\Base;

use app\admin\model\AgentProfitLog;
use helper\Func;
use think\Controller;
use think\Db;
use think\Request;

class Profitlog extends Base
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
        //收益类型（1直属玩家 2下级代理 3下级代理直属玩家 4隔代代理 5隔代直属玩家 6全线业绩 7代理自身充值）
        $profit_type_str = request()->param('profit_type_str','1,2,3,4,5,6,7');//从代理、玩家详情页跳转增加的处理
        $profit_type_arr = explode(',',$profit_type_str);

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

        $model = new AgentProfitLog();

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
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $model->where($where)
                ->where(['profit_type'=>['in',$profit_type_arr]])
                ->where(['create_time'=>['between',[$start_time,$end_time]]])
                ->order($sort, $order)
                ->count();

            $list = $model->where($where)
                ->where(['profit_type'=>['in',$profit_type_arr]])
                ->where(['create_time'=>['between',[$start_time,$end_time]]])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            if(empty($list)){
                $profit_money = 0;
                $order_money = 0;
            }else{
                $profit_money = $model->where($where)->where(['profit_type'=>['in',$profit_type_arr]])->where(['create_time'=>['between',[$start_time,$end_time]]])->sum('profit_money');
                $subQuery = Db::connect('db_config_agent')->table('agent_profit_log')->field('order_id,order_money')->where($where)->where(['profit_type'=>['in',$profit_type_arr]])->where(['create_time'=>['between',[$start_time,$end_time]]])->group('order_id')->buildSql();
                $order_money = Db::connect('db_config_agent')->table($subQuery.' a')->sum('a.order_money');
            }

            $result = array("total" => $total, "rows" => $list,'profit_money'=>number_format($profit_money/100,2),'order_money'=>number_format($order_money/100,2),);
            return json($result);
        }
        return $this->view->fetch();
    }

}
