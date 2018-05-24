<?php

namespace app\admin\controller\usertool;

use app\common\controller\Backend;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 道具操作记录管理
 *
 * @icon fa fa-circle-o
 */
class Tooloperatelog extends Backend
{
    
    /**
     * ToolOperateLog模型对象
     */
    protected $model = null;
    private $operateTypeList;
    private $getTypeList;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ToolOperateLog');
        $this->operateTypeList = $this->model->getOperateTypelist();
        $this->getTypeList = $this->model->getGetTypelist();

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
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
            foreach($list as $k=>&$item)
            {
                $item['get_type']= isset($this->getTypeList[$item['get_type']])?$this->getTypeList[$item['get_type']]:$item['get_type'];
                $item['operate_type']= $this->operateTypeList[$item['operate_type']];
            }

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
    

}
