<?php

namespace app\admin\controller\firstlogin;

use app\common\controller\Backend;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 首充礼包配置
 *
 * @icon fa fa-circle-o
 */
class Firstchargesetting extends Backend
{
    
    /**
     * FirstchargeSetting模型对象
     */
    protected $model = null;
    protected $systemList;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('FirstchargeSetting');
        $this->systemList = $this->model->systemText();
        $this->assign("systemList",$this->systemList);
        $this->statusList = ["0"=>"关闭","1"=>"正常"];
        $this->assign("statusList",$this->statusList);
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
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
            foreach ($list as $k=>&$item)
            {
                $item['system_text']='';

                $t = explode(',',$item['platform_id']);
                foreach ($t as $v)
                {
                    $item['system_text'] .= $this->systemList[$v].',';
                }
                $item['system_text'] = rtrim($item['system_text'],',');
                $item['goods_name'] = Db::table('poker_goods')->connect(config('db_config_poker'))->where(["goodid"=>$item['goods_id']])->value('name');
                $item['status_text'] = $item['status']?'normal':'hidden';
                $item['channel_text'] = model('ActivityChannel')->where(['channel_id'=>$item['channel_id']])->value('channel_name');
            }
            $result = array("total" => $total, "rows" => $list);


            return json($result);
        }
        return $this->view->fetch();
    }
    public function changeName()
    {
        $id = $this->request->post('id',0);
        $gift_id = $this->request->post('gift_id',0);
        $gift_old_id = $this->request->post('gift_old_id',0);
        $row = $this->model->find($id);
        $gift_list = json_decode($row['base_gift_content'],true);
        $result=[];
        foreach($gift_list as &$item)
        {
            if($item['id'] == $gift_old_id)
            {
                $item['id'] = $gift_id;
                $item['name'] = model('GiftContentSetting')->where(['id'=>$gift_id])->value('name');
                $result = $item;
                break;
            }
        }
        $gift_content = json_encode($gift_list);
        $ret = $this->model->where(['id'=>$id])->update(['base_gift_content'=>$gift_content,'update_time'=>time()]);
        if($ret ===false)
        {
            return json(['error'=>'更新数据失败','data'=>[]]);
        }
        return json($result);
    }
    public function changeNum()
    {
        $id = $this->request->post('id',0);
        $gift_old_id = $this->request->post('gift_old_id',0);
        $gift_num = $this->request->post('gift_num',0);
        $row = $this->model->find($id);
        $gift_list = json_decode($row['base_gift_content'],true);
        $result=[];
        foreach($gift_list as &$item)
        {
            if($item['id'] == $gift_old_id)
            {
                $item['num'] = $gift_num;
                $result = $item;
                break;
            }
        }
        $gift_content = json_encode($gift_list);

        $ret = $this->model->where(['id'=>$id])->update(['base_gift_content'=>$gift_content,'update_time'=>time()]);
        if($ret ===false)
        {
            return json(['error'=>'更新数据失败','data'=>[]]);
        }
        return json($result);
    }
    public function changeExtraName()
    {
        $id = $this->request->post('id',0);
        $gift_id = $this->request->post('gift_id',0);
        $gift_old_id = $this->request->post('gift_old_id',0);
        $row = $this->model->find($id);
        $gift_list = json_decode($row['extra_gift_content'],true);
        $result=[];
        foreach($gift_list as &$item)
        {
            if($item['id'] == $gift_old_id)
            {
                $item['id'] = $gift_id;
                $item['name'] = model('GiftContentSetting')->where(['id'=>$gift_id])->value('name');
                $result = $item;
                break;
            }
        }
        $gift_content = json_encode($gift_list);
        $ret = $this->model->where(['id'=>$id])->update(['extra_gift_content'=>$gift_content,'update_time'=>time()]);
        if($ret ===false)
        {
            return json(['error'=>'更新数据失败','data'=>[]]);
        }
        return json($result);
    }
    public function changeExtraNum()
    {
        $id = $this->request->post('id',0);
        $gift_old_id = $this->request->post('gift_old_id',0);
        $gift_num = $this->request->post('gift_num',0);
        $row = $this->model->find($id);
        $gift_list = json_decode($row['extra_gift_content'],true);
        $result=[];
        foreach($gift_list as &$item)
        {
            if($item['id'] == $gift_old_id)
            {
                $item['num'] = $gift_num;
                $result = $item;
                break;
            }
        }
        $gift_content = json_encode($gift_list);

        $ret = $this->model->where(['id'=>$id])->update(['extra_gift_content'=>$gift_content,'update_time'=>time()]);
        if($ret ===false)
        {
            return json(['error'=>'更新数据失败','data'=>[]]);
        }
        return json($result);
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
        $row['channel_text'] = model('ActivityChannel')->where(['channel_id'=>$row['channel_id']])->value('channel_name');
        $this->view->assign("row", $row);
        return $this->view->fetch();
    }
}
