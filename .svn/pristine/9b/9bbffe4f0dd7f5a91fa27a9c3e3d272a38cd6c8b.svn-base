<?php

namespace app\admin\controller\agent\settlement;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 代理商提现管理员操作日志管理
 *
 * @icon fa fa-circle-o
 */
class Agentsettlementorderlog extends Backend
{
    
    /**
     * AgentSettlementOrderLog模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('AgentSettlementOrderLog');

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
            $total = $this->model
                ->where($where)
                ->order($sort, $order)
                ->count();

            $list = $this->model
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

            foreach($list as $k=>&$v)
            {
                $v['before_money'] /= 100;
                $v['settlement_money'] /= 100;
                $v['after_money'] /= 100;
            }
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
        $this->error(__('You have no permission'));
    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $this->error(__('You have no permission'));
    }

    /**
     * 删除
     */
    public function del($ids = "")
    {

        $this->error(__('You have no permission'));
    }


}
