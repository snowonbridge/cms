<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use fast\Func;
use think\Controller;
use think\Request;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Sysnotice extends Backend
{
    
    /**
     * SysnoticeConfig模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('SysnoticeConfig');
        $this->view->assign("tabList", $this->model->getTablist());
        $this->view->assign("typeIdList", $this->model->getTypeidlist());
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
                    if ($this->modelValidate) {
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
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }


    /**
     * 发布
     *
     */
    public function send($ids = "")
    {
        if ($ids)
        {
            $list = $this->model->where('id', 'in', $ids)->field('title,content,logo_image,tab,type_id,maxver,minver,mids,start_time,end_time,ctime')->select();
            $appenv = defined('APPENV')?  APPENV : 'product';
            $file = "cfg/".$appenv."/sysnotice.php";
            $ret = [];
            $flag = false;
            $time = time();
            foreach($list as $item){
                $each['title'] =  (string)$item['title'];
                $each['content'] =  (string)$item['content'];
                $each['startTime'] =  (string)$item['start_time'];
                $each['endTime'] =  (string)$item['end_time'];
                $each['minver'] =  (string)$item['minver'];
                $each['maxver'] =  (string)$item['maxver'];
                $each['mids'] =  (string)$item['mids'];
                $each['typeId'] =  (int)$item['type_id'];
                $each['ctime'] =  (int)$item['ctime'];
                $each['tab'] =  (int)$item['tab'];
                $each['logo'] =  (string)$item['logo_image'];
                //有效日期
                if (($each['startTime'] && strtotime($each['startTime']) > $time) || ($each['endTime'] && strtotime($each['endTime']) < $time)) {
                    continue;
                }
                $ret[] = $each;
            }
            $ret && ($flag = Func::sendFile($file,$ret));
            if($flag){
                $this->success();
            }
            $this->error(__('Send File %s  Failed!', 'ids'));
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }



}
