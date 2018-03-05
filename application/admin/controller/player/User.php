<?php

namespace app\admin\controller\player;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class User extends Backend
{
    
    /**
     * PlayerUser模型对象
     */
    protected $model = null;
    protected  $multiFields='ustatus';

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('PlayerUser');
        $this->view->assign("usexList", $this->model->getUsexlist());
        $this->view->assign("ustatusList", $this->model->getUstatuslist());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
