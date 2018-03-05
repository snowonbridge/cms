<?php

namespace app\admin\controller\control;

use app\admin\model\CmsAppConfig;
use app\admin\model\CmsControlStoreSetting;
use app\admin\model\PokerUcCityInfo;
use app\common\controller\Backend;

use helper\Code;
use think\Controller;
use think\Exception;
use think\Request;
use think\Session;

class Config extends Backend
//class Config extends Controller
{

    public $admin = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->admin = Session::get('admin');
        //todo 将管理员可操作的游戏平台id加入admin session
    }

    public function index(){
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
            //if ($this->request->isPost())
        {
            return $this->getOnlineStoreList();
        }
        return $this->view->fetch();
    }


    /**
     * 添加
     */
    public function add()
    {
        $configModel = new CmsAppConfig();
        $getSelectStoreList = $configModel->getSelectStoreList();
        if ($this->request->isPost())
        {
            $unid =  (int)request()->param('unid');
            if ($unid)
            {
                try
                {
                    $configModel = new CmsAppConfig();
                    $result = $configModel->addOnlineStore($unid);

                    if ($result['code'] == Code::SUCCESS)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($result['msg']);
                    }
                }
                catch (Exception $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch('',['selectStoreList'=>$getSelectStoreList]);
    }


    /**
     * 删除
     */
    public function del($ids = "")
    {

        if ($this->request->isPost())
        {
            try
            {
                $configModel = new CmsAppConfig();
                $result = $configModel->delOnlineStore(intval($ids));

                if ($result['code'] == Code::SUCCESS)
                {

                    $this->success();
                }
                else
                {
                    $this->error($result['msg']);
                }
            }
            catch (Exception $e)
            {
                $this->error($e->getMessage());
            }

        }

        return $this->view->fetch();
    }



    public function getOnlineStoreList(){
        $configModel = new CmsAppConfig();
        $res = $configModel->getOnlineStoreList();

        $result = array(
            "total" => count($res),
            "rows" => $res,
        );

        $res = array_merge(['code'=>Code::SUCCESS,'msg'=>' 成功','data'=>[]],$result);

        return json($res);
    }


    public function addOnlineStore($unid){
        $configModel = new CmsAppConfig();
        $res = $configModel->addOnlineStore($unid);
        return json($res);
    }

    public function delOnlineStore($unid){
        $configModel = new CmsAppConfig();
        $res = $configModel->delOnlineStore($unid);
        return json($res);
    }
    

}
