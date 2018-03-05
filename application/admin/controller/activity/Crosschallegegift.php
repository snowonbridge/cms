<?php

namespace app\admin\controller\activity;

use app\admin\model\ActivityTabSetting;
use app\admin\model\GiftContentSetting;
use app\admin\model\RedirectSetting;
use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 牌局关卡活动
 *
 * @icon fa fa-circle-o
 */
class Crosschallegegift extends Backend
{
    
    /**
     * CrossChallegeGift模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('CrossChallegeGift');

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);

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
                    //是否采用模型验证
                    if ($this->modelValidate)
                    {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    $result = $row->save($params);
                    if ($result !== false)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($row->getError());
                    }
                }
                catch (\think\exception\PDOException $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $this->view->assign('gift_list',(new GiftContentSetting())->where(["status"=>1])->field('id,name')->select());
        $this->view->assign('tab_list',(new ActivityTabSetting())->where(["status"=>1])->field('id,title')->select());
        $this->view->assign('redirect_list',(new RedirectSetting())->field('id,title')->select());

        $this->view->assign("row", $row);
        return $this->view->fetch();
    }

}
