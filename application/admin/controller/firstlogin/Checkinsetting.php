<?php

namespace app\admin\controller\firstlogin;

use app\common\controller\Backend;

use think\Controller;
use think\Log;
use think\Request;

/**
 * 签到奖励配置
 *
 * @icon fa fa-circle-o
 */
class Checkinsetting extends Backend
{
    
    /**
     * CheckinSetting模型对象
     */
    protected $model = null;
    protected $registerList;
    protected $systemList;
    protected $ruleList;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('CheckinSetting');
        $this->registerList = $this->model->registerText();
        $this->systemList = $this->model->systemText();
        $this->ruleList = $this->model->ruleText();
        $this->assign("registerList",$this->registerList);
        $this->assign("systemList",$this->systemList);
        $this->assign("ruleList",$this->ruleList);

    }
//    public function registerText()
//    {
//        return ['1'=>'游客','2'=>'手机','3'=>'微信','4'=>'QQ','5'=>'灵游'];
//    }
//    public function systemText()
//    {
//        return ['1'=>'安卓','2'=>'IOS','3'=>'PC'];
//
//    }
//    public function ruleText()
//    {
//        return ['1'=>'连续制','2'=>'非连续制'];
//    }
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
            foreach ($list as $k=>&$item)
            {
                $item['system_text']='';

                $t = explode(',',$item['platform_id']);
                foreach ($t as $v)
                {
                    $item['system_text'] .= $this->systemList[$v].',';
                }
                $item['system_text'] = rtrim($item['system_text'],',');
                $t = explode(',',$item['register_way_id']);
                $item['register_text']='';
                foreach ($t as $v)
                {
                    $item['register_text'] .= $this->registerList[$v].',';
                }
                $item['register_text'] = rtrim($item['register_text'],',');
                $item['rule_text'] = $this->ruleList[$item['rule_id']];
                $item['channel_text'] = model('ActivityChannel')->where(['channel_id'=>$item['channel_id']])->value('channel_name');
            }
            $result = array("total" => $total, "rows" => $list);


            return json($result);
        }
        return $this->view->fetch();
    }
    /**
     * row[channel_id_text:
    row[channel_id]:28
    row[rule_id]:1
    row[register_way_id]:4
    row[register_way_id]:5
    row[platform_id]:1
    row[platform_id]:2
    row[platform_id]:3
    row[days]:7
    row[gift_content]:[{
    row[update_time]:2018-03-27 15:48:31
    row[create_time]:2018-03-27 15:48:31
     */
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

    public function getGiftList()
    {
        $data=model('GiftContentSetting')->field(['id','name'])->select();
        return json($data);
    }
    public function changeName()
    {
        $id = $this->request->post('id',0);
        $day_nd = $this->request->post('day_nd',0);
        $gift_id = $this->request->post('gift_id',0);
        $row = $this->model->find($id);
        $gift_list = json_decode($row['gift_content'],true);
        $result=[];
        foreach($gift_list as &$item)
        {
            if($item['day_nd'] == $day_nd)
            {
                $item['list'][0]['id'] = $gift_id;
                $item['list'][0]['name'] = model('GiftContentSetting')->where(['id'=>$gift_id])->value('name');
                $result = $item;
                break;
            }
        }
        $gift_content = json_encode($gift_list);
        $ret = $this->model->where(['id'=>$id])->update(['gift_content'=>$gift_content,'update_time'=>time()]);
        if($ret ===false)
        {
            return json(['error'=>'更新数据失败','data'=>[]]);
        }
        return json($result);
    }
    public function changeNum()
    {
        $id = $this->request->post('id',0);
        $day_nd = $this->request->post('day_nd',0);
//        $gift_id = $this->request->post('gift_id',2);
        $gift_num = $this->request->post('gift_num',0);
        $row = $this->model->find($id);
        $gift_list = json_decode($row['gift_content'],true);
        $result=[];
        foreach($gift_list as &$item)
        {
            if($item['day_nd'] == $day_nd)
            {
                $item['list'][0]['num'] = $gift_num;
                $result = $item;
                break;
            }
        }
        $gift_content = json_encode($gift_list);

        $ret = $this->model->where(['id'=>$id])->update(['gift_content'=>$gift_content,'update_time'=>time()]);
        if($ret ===false)
        {
            return json(['error'=>'更新数据失败','data'=>[]]);
        }
        return json($result);
    }

}
