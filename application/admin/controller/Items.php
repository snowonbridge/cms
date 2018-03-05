<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use fast\OutFile;
use fast\SendFile;

/**
 * 物品管理
 *
 * @icon fa fa-circle-o
 */
class Items extends Backend
{


    /**@var \app\admin\model\ItemsConfig */
    protected $model = null;

    const INTER_PROP_CFG = [
        11=>['id'=>11,'level'=>1,'price'=>[100,200,300]],
	    12=>['id'=>12,'level'=>1,'price'=>[100,200,300]],
	    13=>['id'=>13,'level'=>0,'price'=>[100,200,300]],
	    14=>['id'=>14,'level'=>0,'price'=>[100,200,300]],
	    15=>['id'=>15,'level'=>0,'price'=>[100,200,300]],
	    16=>['id'=>16,'level'=>0,'price'=>[100,200,300]],
        ];

    /**
     *
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('ItemsConfig');
        $this->view->assign("typeIdList", $this->model->getTypeidlist());
        $this->view->assign("toolTypeList", $this->model->getTooltypelist());
        $this->view->assign("usableList", $this->model->getUsablelist());
        $this->view->assign("showList", $this->model->getShowlist());
        $this->view->assign("rewardList", $this->model->getRewardlist());
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 查看
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

            $result = array("total" => $total, "rows" => $list);

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
                try
                {
                    //是否采用模型验证
                    if ($this->modelValidate)
                    {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }

                    if (isset($params['reward']) && is_array($params['reward']))
                    {
                        $params['reward'] = array_values($params['reward']);
                        $params['reward'] = $params['reward'] ? json_encode($params['reward'], JSON_UNESCAPED_UNICODE) : '';
                    }
                    else
                    {
                        $params['reward'] = '[]';
                    }
                    $result = $this->model->save($params);
                    if ($result !== false)
                    {
                        $this->success();
                    }
                    else
                    {
                        $this->error($this->model->getError());
                    }
                }
                catch (\think\exception\PDOException $e)
                {
                    $this->error($e->getMessage());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        return $this->view->fetch();
    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        $reward = json_decode($row['reward'], TRUE);
        $row['reward'] = $reward ? $reward : [];
        if (!$row)
            $this->error(__('No Results were found'));
        if ($this->request->isPost())
        {
            $params = $this->request->post("row/a");
            if ($params)
            {
                try
                {
                    //是否采用模型验证
                    if ($this->modelValidate)
                    {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    if (isset($params['reward']) && is_array($params['reward']))
                    {
                        $params['reward'] = array_values($params['reward']);
                        foreach($params['reward'] as $key => $item){
                            if(!$item['val']){
                                unset($params['reward'][$key]);
                            }
                        }
                        $params['reward'] = $params['reward'] ? json_encode($params['reward'], JSON_UNESCAPED_UNICODE) : '[]';
                    }
                    else
                    {
                        $params['reward'] = '[]';
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
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }


    /**
     * 发布
     */
    public function send($ids = "")
    {
        if ($ids)
        {
            $list = $this->model->where('tlid', 'in', $ids)->field('tlid,name,desc,cprc,type_id,tool_type,usable,show,keeptime,persitime,vip,m,mday,chgsmax,reward')->select();

            $ret = [];
            foreach($list as $item){
               $each['tlid'] =  (int)$item['tlid'];
               $each['name'] =  (string)$item['name'];
               $each['desc'] =  (string)$item['desc'];
               $each['cprc'] =  (int)$item['cprc'];
               $each['typeID'] =  (int)$item['type_id'];
               $each['toolType'] =  (int)$item['tool_type'];
               if($each['typeID']!=1){
                   $each['usable'] =  (int)$item['usable'];
                   $each['show'] =  (int)$item['show'];
                   $each['keeptime'] =  (int)$item['keeptime'];
                   $each['persitime'] =  (int)$item['persitime'];
                   $each['vip'] =  (int)$item['vip'];
                   $each['m'] =  (int)$item['m'];
                   $each['mday'] =  (int)$item['mday'];
                   $each['chgsmax'] =  (int)$item['chgsmax'];
                   $each['reward'] =  json_decode($item['reward'],true);
                   if(is_array($each['reward']) && !empty($each['reward'])){
                       array_walk($each['reward'],function(&$im,$k){
                           $im['id']= isset($im['id'])?$im['id']:0;
                       });
                   }
                   if(empty($each['reward'])){
                       unset($each['reward']);
                   }
               }
               if($each['typeID']==3){
                   $ret['bag'][$each['tlid']] = $each;
               }elseif($each['typeID']==1){
                   $ret['money'][$each['tlid']] = $each;
               }else{
                   $ret['tool'][$each['tlid']] = $each;
               }
               if( $each['toolType']==1){
                   $interProp[] =  $each['tlid'];
               }
            }
            $appenv = defined('APPENV')?  APPENV : 'product';
            $file = "cfg/".$appenv."/prop.php";
            if(isset($interProp) && !empty($interProp)){
                $oriInterProp = static::INTER_PROP_CFG;
                foreach($interProp as $tlid){
                    if(isset($oriInterProp[$tlid])){
                        $sendInterProp[$tlid] =  $oriInterProp[$tlid];
                    }
                }
            }
            isset($sendInterProp) && $ret['interProp'] = $sendInterProp;
            $outfile = new OutFile();
            $outfile->php($file, $ret);
            $send = new SendFile();
            $send->file($file, '', false,config('send_url'));
            $this->success();
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }








}
