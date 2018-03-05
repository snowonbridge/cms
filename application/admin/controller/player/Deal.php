<?php

namespace app\admin\controller\player;

use app\admin\model\PlayerUsergame;
use app\common\controller\Backend;
use fast\Func;
use helper\Code;
use helper\Okey;
use think\Cache;
use think\Db;
use think\Exception;

/**
 * 单页管理
 *
 * @icon fa fa-circle-o
 * @remark 用于处理用户相关的数据
 */
class Deal extends Backend
{

    protected $model = null;
    protected $relationSearch = true;

    public function _initialize()
    {
        $actionname = strtolower($this->request->action());
        if($actionname == 'index' && $this->request->isAjax()){
            $this->layout = '';
        }
        parent::_initialize();
        $this->model = model('User');
    }

    /**
     * 查看
     */
    public function index()
    {

        $data = [];
        if ($this->request->isAjax()) {
            $do = $this->request->request('do');
            $ret = Func::gameApiRequest($this->request,$do);
            if(isset($ret['ret']) && $ret['ret'] == true){
                $data = json_decode($ret['msg'],true);
                if(!$data){
                    $this->error('Fail');
                }
                return json(json_decode($ret['msg'],true));
            }
            $this->error('Fail');
        }
        $this->view->assign('data', $data);
        return $this->view->fetch();
    }





}
