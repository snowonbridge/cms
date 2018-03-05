<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 百人场统计数据
 *
 * @icon fa fa-circle-o
 */
class Hundredwartotalstat extends Backend
{
    
    /**
     * HundredWarTotalStat模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('HundredWarTotalStat');

    }

    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            $stat =  $this->request->param("stat", '') ? $this->request->param("stat", '') : session('stat_hundred_war_total');
                $stat && empty(session('stat_hundred_war_total')) &&  session('stat_hundred_war_total',$stat);
            if ($this->request->request('pkey_name'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            if($stat == 'month'){
                $total = $this->model->field('id,left(k,8) as k,
sum(robot_banker_cnt) as robot_banker_cnt,
sum(player_banker_cnt) player_banker_cnt,
sum(system_banker_cnt) system_banker_cnt,
sum(player_in_chips) player_in_chips,
sum(robot_in_chips) robot_in_chips,
sum(robot_banker_in_chips) robot_banker_in_chips,
sum(system_banker_in_chips) system_banker_in_chips,
sum(player_banker_in_chips) player_banker_in_chips,
sum(robot_on_seats_cnt) robot_on_seats_cnt,
sum(player_on_seats_cnt) player_on_seats_cnt,
update_time') ->where($where)
                    ->order($sort, $order)
                    ->group('left(k,8)')
                    ->count();

                $list = $this->model
                    ->field('group_concat(id) id,left(k,8) as k,
sum(robot_banker_cnt) as robot_banker_cnt,
sum(player_banker_cnt) player_banker_cnt,
sum(system_banker_cnt) system_banker_cnt,
sum(player_in_chips) player_in_chips,
sum(robot_in_chips) robot_in_chips,
sum(robot_banker_in_chips) robot_banker_in_chips,
sum(system_banker_in_chips) system_banker_in_chips,
sum(player_banker_in_chips) player_banker_in_chips,
sum(robot_on_seats_cnt) robot_on_seats_cnt,
sum(player_on_seats_cnt) player_on_seats_cnt,
update_time')->where($where)
                    ->order($sort, $order)
                    ->group('left(k,8)')
                    ->limit($offset, $limit)
                    ->select();
            }else{
                //如果发送的来源是Selectpage，则转发到Selectpage
                if ($this->request->request('pkey_name'))
                {
                    return $this->selectpage();
                }
                list($where, $sort, $order, $offset, $limit) = $this->buildparams();
                $total = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->count();

                $list = $this->model
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->select();


            }
            $result = array("total" => $total, "rows" => $list);
            return json($result);
        }
        return $this->view->fetch();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
