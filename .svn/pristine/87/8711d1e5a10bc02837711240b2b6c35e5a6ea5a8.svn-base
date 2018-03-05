<?php

namespace app\admin\controller\control;

use app\admin\model\CmsControlAppList;
use app\admin\model\PokerUcCityInfo;
use app\common\controller\Backend;

use helper\Code;
use helper\Okey;
use think\Cache;
use think\Controller;
use think\Exception;
use think\Request;
use think\Session;

class App extends Backend
//class App extends Controller
{

    public $admin = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->admin = Session::get('admin');
        //todo 将管理员可操作的游戏平台id加入admin session
    }

    public function index(){

        $model =  new CmsControlAppList();
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
            //if ($this->request->isPost())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('pkey_name'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $total = $model
                ->where($where)
                ->where(['status'=>$model::STATUS_ON])
                ->order($sort, $order)
                ->count();

            $list = $model
                ->where($where)
                ->where(['status'=>$model::STATUS_ON])
                ->order($sort, $order)
                ->limit($offset, $limit)
                ->select();


            $result = array(
                "total" => $total,
                "rows" => $list,
            );

            return json($result);
        }
        return $this->view->fetch();

    }

    /**
     * 添加
     */
    public function add()
    {
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
                    $sid = $params['sid'];
                    $version = $params['version'];

                    $configModel = new CmsControlAppList();
                    $version = trim($version);
                    if(!in_array($sid,array_keys(config('sidList')))){
                        $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'游戏sid不存在','data'=>[]];
                        return json($res);
                    }
                    $ex_version = explode('.',$version);
                    foreach($ex_version as $v){
                        if(!is_numeric($v)){
                            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'请输入正确的版本号格式，如：1.0.0 ','data'=>[]];
                            return json($res);
                        }
                    }

                    $isExist = $configModel->where(['sid'=>$sid,'version'=>$version,'status'=>1])->find();
                    if($isExist){
                        $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'该游戏版本已存在','data'=>[]];
                        return json($res);
                    }
                    $result = $configModel->addAppList($sid,$version);

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
        return $this->view->fetch('',['sidList'=>config('sidList')]);
    }

    /**
     * 编辑等级
     */
    public function edit($ids = NULL)
    {
        $model = new CmsControlAppList();
        $row = $model->get($ids);
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

                $old_sid = $row['sid'];
                $sid = intval($params['sid']);
                $version =  trim($params['version']);
                if(!in_array($sid,array_keys(config('sidList')))){
                    $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'游戏sid不存在','data'=>[]];
                    return json($res);
                }
                $ex_version = explode('.',$version);
                foreach($ex_version as $v){
                    if(!is_numeric($v)){
                        $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'请输入正确的版本号格式，如：1.0.0 ','data'=>[]];
                        return json($res);
                    }
                }

                try
                {
                    $row->sid = $sid;
                    $row->version = $version;
                    $row->update_time = time();
                    $result = $row->save();

                    if ($result)
                    {
                        $redis = Cache::store('redis');
                        $redis->rm(Okey::rControlAppList($old_sid));
                        $redis->rm(Okey::rControlAppList($sid));

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
        $this->view->assign("row", $row);
        return $this->view->fetch('',['sidList'=>config('sidList')]);
    }


    /**
     * 删除
     */
    public function del($ids = "")
    {

        $model = new CmsControlAppList();
        $row = $model->get($ids);

        if (!$row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost())
        {
                try
                {
                    $configModel = new CmsControlAppList();
                    $result = $configModel->delAppList($ids);

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
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }


    public function getAppList(){
        $configModel = new CmsControlAppList();
        $res = $configModel->getAppList();

        $result = array(
            "total" => count($res),
            "rows" => $res,
        );

        $res = array_merge(['code'=>Code::SUCCESS,'msg'=>' 成功','data'=>[]],$result);
        return json($res);
    }


    public function addApp($sid,$version){

        $configModel = new CmsControlAppList();
        $version = trim($version);
        if(!in_array($sid,array_keys(config('sidList')))){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'游戏sid不存在','data'=>[]];
            return json($res);
        }
        $ex_version = explode('.',$version);
        foreach($ex_version as $v){
            if(!is_numeric($v)){
                $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'请输入正确的版本号格式，如：1.0 ','data'=>[]];
                return json($res);
            }
        }

        $isExist = $configModel->where(['sid'=>$sid,'version'=>$version,'status'=>1])->find();
        if($isExist){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'该游戏版本已存在','data'=>[]];
            return json($res);
        }
        $res = $configModel->addAppList($sid,$version);
        return json($res);
    }

    public function delApp($app_id){
        $configModel = new CmsControlAppList();
        $res = $configModel->delAppList($app_id);
        return json($res);
    }

}
