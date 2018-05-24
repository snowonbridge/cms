<?php

namespace app\admin\controller\exchange;

use app\common\controller\Backend;

use think\Controller;
use think\Request;
use think\Session;

/**
 * 兑换商城配置管理
 *
 * @icon fa fa-circle-o
 */
class Userexchangeapply extends Backend
{
    
    /**
     * UserExchangeApply模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('UserExchangeApply');
        $this->view->assign("statusList", $this->model->getStatuslist());
    }

    /**
     * 批量更新
     */
    public function multi($ids = "")
    {
        $ids = $ids ? $ids : $this->request->param("ids");
        if ($ids)
        {
            if ($this->request->has('params'))
            {
                parse_str($this->request->post("params"), $values);
                $values = array_intersect_key($values, array_flip(is_array($this->multiFields) ? $this->multiFields : explode(',', $this->multiFields)));
                if ($values)
                {
                    $admin = Session::get('admin');
                    $uid = $admin ? $admin->id : 0;
                    $values['opt_admin_id'] = $uid;
                    $values['opt_time'] = time();
                    $values['opt_admin_name'] =  $admin ? $admin->username : __('Unknown');;
                    $count = $this->model->where($this->model->getPk(), 'in', $ids)->update($values);
                    if ($count)
                    {
                        $this->success();
                    }
                }
                else
                {
                    $this->error(__('You have no permission'));
                }
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
