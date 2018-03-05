<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use fast\Func;
use think\Controller;
use think\Request;
use think\Session;

/**
 * 用户生活照
 *
 * @icon fa fa-circle-o
 */
class Userphotos extends Backend
{
    
    /**
     * UserPhotos模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('UserPhotos');

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
                    $values['admin_id'] = $uid;
                    $values['optime'] = time();
                    $count = $this->model->where($this->model->getPk(), 'in', $ids)->update($values);
                    if ($count)
                    {
                        $ret = Func::gameApiRequest($this->request,'changeUserAvartar');
                        if($ret['ret']==1){
                            $reqBack = json_decode($ret['msg'], TRUE);
                            if($reqBack['code']==1){
                                $this->success();
                            }
                        }
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
     * 查看
     */
    public function index()
    {
        $this->relationSearch = true;
//        $this->searchFields = "userMap.mid";
        if ($this->request->isAjax())
        {
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                ->with("usermap")
                ->where($where)
                ->order($sort, $order)
                ->count();
            $list = $this->model
                ->with("usermap")
                ->where($where)
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();

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
