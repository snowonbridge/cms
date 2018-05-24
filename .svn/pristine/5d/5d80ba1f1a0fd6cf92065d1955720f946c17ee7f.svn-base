<?php

namespace app\admin\controller\gameentrymain;

use app\common\controller\Backend;

use fast\Func;
use think\Controller;
use think\Db;
use think\Request;

/**
 * 游戏场次配置
 *
 * @icon fa fa-circle-o
 */
class Gameentry extends Backend
{
    
    /**
     * GameEntryConfig模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('GameEntryConfig');
        $this->view->assign("statusList", $this->model->getStatuslist());
        $this->view->assign("gameidsList", $this->model->getGameidsList());
        $this->view->assign("tabletypesList", $this->model->getTabletypesList());
        $this->view->assign("robotSwitch", $this->model->getRobotSwitch());
        $this->view->assign("setCardSwitch", $this->model->getSetCardSwitch());
        \app\admin\model\GameEntryConfig::event('after_write', function ($good) {
            $this->after();
        });
        \app\admin\model\GameEntryConfig::event('after_update', function ($good) {
            $this->after();
        });

        \app\admin\model\GameEntryConfig::event('after_delete', function ($user) {
            $this->after();
        });

    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */



    public function after()
    {
        $ret = Func::gameApiRequest($this->request,'freshGameEntry');
        $reqBack = false;
        if($ret['ret']==1){
            $reqBack = json_decode($ret['msg'], TRUE);
        }
        if(!$reqBack or $reqBack['code']!=1){
            return false;
        }
        return true;
    }
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

}
