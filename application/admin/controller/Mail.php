<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use Exception;
use fast\Func;
use fast\Http;
use fast\OutFile;
use fast\SendFile;
use think\Controller;
use think\Log;
use think\Request;

/**
 *
 *
 * @icon fa fa-circle-o
 */
class Mail extends Backend
{

    /**
     * MailConfig模型对象
     */
    protected $model = null;

    protected $noNeedLogin = ['mail'];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('MailConfig');
        $this->view->assign("conTypeList", $this->model->getContypelist());
        $this->view->assign("TypeList", $this->model->getTypelist());
        $this->view->assign("statusList", $this->model->getStatuslist());
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 添加
     */
    public function add()
    {
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.add' : true) : $this->modelValidate;
                        $this->model->validate($validate);
                    }

                    if (isset($params['reward']) && is_array($params['reward'])) {
                        $params['reward'] = array_filter($params['reward'], function ($v, $k) {
                            return $v['id'] && $v['num'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $params['reward'] = array_values($params['reward']);
                        $params['reward'] = $params['reward'] ? json_encode($params['reward'], JSON_UNESCAPED_UNICODE) : '[]';
                    } else {
                        $params['reward'] = '[]';
                    }
                    $result = $this->model->save($params);
                    if ($result !== false) {
                        $list[$result] = ['id'=>$this->model->getLastInsID(),'reward'=>json_decode($params['reward'],true),'type'=>$params['type'],'uids'=>isset($params['uids']) ? $params['uids'] : '','sendTime'=>strtotime($params['sendtime']),'conType'=>$params['con_type']];
                        try {
                            $list && ($ret = Func::gameApiRequest($this->request, 'sendMsg',['list'=>$list]));
                        } catch (Exception $e) {
                            Log::record($e->getMessage());
                        }
                        $this->success();
                    } else {
                        $this->error($this->model->getError());
                    }
                } catch (\think\exception\PDOException $e) {
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
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                try {
                    //是否采用模型验证
                    if ($this->modelValidate) {
                        $name = basename(str_replace('\\', '/', get_class($this->model)));
                        $validate = is_bool($this->modelValidate) ? ($this->modelSceneValidate ? $name . '.edit' : true) : $this->modelValidate;
                        $row->validate($validate);
                    }
                    if (isset($params['reward']) && is_array($params['reward'])) {
                        $params['reward'] = array_filter($params['reward'], function ($v, $k) {
                            return $v['id'] && $v['num'];
                        }, ARRAY_FILTER_USE_BOTH);
                        $params['reward'] = array_values($params['reward']);
                        $params['reward'] = $params['reward'] ? json_encode($params['reward'], JSON_UNESCAPED_UNICODE) : '[]';
                    } else {
                        $params['reward'] = '[]';
                    }

                    $result = $row->save($params);
                    if ($result !== false) {
                        $list[$result] = ['id'=>$ids,'reward'=>json_decode($params['reward'],true),'type'=>$params['type'],'uids'=>isset($params['uids']) ? $params['uids'] : '','sendTime'=>strtotime($params['sendtime']),'conType'=>$params['con_type']];
                        try {
                            $list && ($ret = Func::gameApiRequest($this->request, 'sendMsg',['list'=>$list]));
                        } catch (Exception $e) {
                            Log::record($e->getMessage());
                        }
                        $this->success();
                    } else {
                        $this->error($row->getError());
                    }
                } catch (\think\exception\PDOException $e) {
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
    public function send()
    {
//        if ($ids)
//        {
            $list = $this->model->field('id,title,uids,type,content,con_type,keepday,sendtime,reward')->select();
            $appenv = defined('APPENV')?  APPENV : 'product';
            $file = "cfg/".$appenv."/notice_msg.php";
            $all  = [];
            foreach($list as $item){
                $each['id'] =  (int)$item['id'];
                $each['title'] =  (string)$item['title'];
                $each['desc'] =  (string)$item['content'];
                $each['uids'] =  ($item['type']==1) ? (string)$item['uids'] : '';
                $each['type'] =  (int)$item['type'];
                $each['conType'] =  (int)$item['con_type'];
                $each['day'] =  (int)$item['keepday'];
                $each['time'] =  (int)$item['sendtime'];
                if($item['con_type']!=0){
                    $each['award'] =  json_decode($item['reward'],true);
                    if(empty($each['reward'])){
                        unset($each['reward']);
                    }
                }
                $all[$each['id']] =  $each;
            }
            $outfile = new OutFile();
            $outfile->php($file, $all);
            $send = new SendFile();
            $send->file($file, '', false,config('send_url'));
            $this->success();
//        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }

}
