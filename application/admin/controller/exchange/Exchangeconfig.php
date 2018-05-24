<?php

namespace app\admin\controller\exchange;

use app\common\controller\Backend;

use fast\Func;
use think\Controller;
use think\Request;

/**
 * 兑换商城配置管理
 *
 * @icon fa fa-circle-o
 */
class Exchangeconfig extends Backend
{
    
    /**
     * ExchangeConfig模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ExchangeConfig');
        $this->view->assign("typeList", $this->model->getTypelist());
        $this->view->assign("statusList", $this->model->getStatuslist());
        $this->view->assign("loopList", $this->model->getLooplist());
        $this->view->assign("broadscastList", $this->model->getBroadscastlist());

        \app\admin\model\ExchangeConfig::event('after_write', function ($good) {
            $this->after();
        });
        \app\admin\model\ExchangeConfig::event('after_update', function ($good) {
            $this->after();
        });

        \app\admin\model\ExchangeConfig::event('after_delete', function ($user) {
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
        $ret = Func::gameApiRequest($this->request,'freshExchangeGoods');
        $reqBack = false;
        if($ret['ret']==1){
            $reqBack = json_decode($ret['msg'], TRUE);
        }
        if(!$reqBack or $reqBack['code']!=1){
            return false;
        }
        return true;
    }


}
