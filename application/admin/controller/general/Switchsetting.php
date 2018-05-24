<?php

namespace app\admin\controller\general;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Switchsetting extends Backend
{
    
    /**
     * PokerSwitchSetting模型对象
     */
    protected $model = null;
    protected $systemList;
    protected $registerList;
    protected $loginList;
    protected $payList;
    protected $versionList;
    protected $statusList;
    protected $warnList;
    protected $gameList;
    protected $gamesList=[
        10=>'扎金花金币场',
//        11=>'扎金花房卡场',
        12=>'扎金花百人场',
        13=>'扎金花必下场',
//        14=>'扎金花保留',
//        15=>'扎金花棋牌室',
        16=>'扎金花私人房间',

        20=>'斗牛经典金币场',//拼十
        21=>'斗牛抢庄金币场',
//        25=>'斗牛房卡场',
//        26=>'斗牛抢庄房卡场',
//        28=>'斗牛棋牌室',
//        29=>'斗牛抢庄棋牌室',

        30=>'斗地主经典金币场',
        31=>'斗地主换3张金币场',
        32=>'斗地主癞子金币场',
//        33=>'保留',
//        34=>'斗地主换3张棋牌室',
//        35=>'斗地主经典房卡场',
//        36=>'斗地主换3张房卡场',
//        37=>'斗地主癞子房卡场',
//        38=>'斗地主经典棋牌室',
//        39=>'斗地主癞子棋牌室',


        40=>'麻将血战金币场',
        41=>'麻将血战换3张金币场',
        42=>'麻将血流金币场',
        43=>'麻将血流换3张金币场',
//        45=>'麻将血战房卡场',
//        46=>'麻将血战棋牌室',
//        47=>'麻将血流房卡场',
//        48=>'麻将血流棋牌室',
    ];
    public function getGameList()
    {
        return json($this->gamesList);
    }
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('PokerSwitchSetting');
        $this->systemList = ['1'=>'android','2'=>'IOS','3'=>'PC'];
        $this->registerList = ['1'=>'游客','2'=>'手机','3'=>'微信','4'=>'QQ','5'=>'灵游'];//:1游客,2手机,3微信,4QQ,5灵游
        $this->loginList = ['1'=>'游客','2'=>'手机','3'=>'微信','4'=>'QQ','5'=>'灵游'];//:1游客,2手机,3微信,4QQ,5灵游
        $this->payList=['1'=>'微信','2'=>'支付宝'];
        $this->versionList=['1.0.0'=>'1.0.0','1.1.0'=>'1.1.0','1.2.0'=>'1.2.0'];
        $this->statusList=['0'=>'隐藏','1'=>'正常'];
        $this->warnList=['1'=>'邮件通知'];
        $this->assign("versionList",$this->versionList);
        $this->assign("systemList",$this->systemList);
        $this->assign("registerList",$this->registerList);
        $this->assign("loginList",$this->loginList);
        $this->assign("payList",$this->payList);
        $this->assign("statusList",$this->statusList);
        $this->assign("warnList",$this->warnList);
        $this->assign("gamesList",$this->gamesList);

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    public function getChannelList()
    {
        $list = model('ActivityChannel')->column("channel_name",'channel_id');
        return json($list);
    }
    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
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
            foreach ($list as &$item)
            {
                $item['channel_text'] = model('ActivityChannel')->where(['channel_id'=>$item['channel_id']])->value('channel_name');
                $item['system_text']='';
                $t = explode(',',$item['platform_id']);
                foreach ($t as $v)
                {
                    $item['system_text'] .= $this->systemList[$v].',';
                }
                $item['system_text'] = rtrim($item['system_text'],',');
                $item['register_text']='';
                if(!empty($item['register']))
                {
                    $t = explode(',',$item['register']);

                    foreach ($t as $v)
                    {
                        $item['register_text'] .= $this->registerList[$v].',';
                    }
                    $item['register_text'] = rtrim($item['register_text'],',');
                }

                $item['login_text']='';
                if(!empty($item['login']))
                {
                    $t = explode(',',$item['login']);

                    foreach ($t as $v)
                    {
                        $item['login_text'] .= $this->loginList[$v].',';
                    }
                    $item['login_text'] = rtrim($item['login_text'],',');
                }

                $item['pay_text']='';
                if(!empty($item['pay_way']))
                {
                    $t = explode(',',$item['pay_way']);
                    foreach ($t as $v)
                    {
                        $item['pay_text'] .= $this->payList[$v].',';
                    }
                    $item['pay_text'] = rtrim($item['pay_text'],',');
                }
                $item['show_primary_text']='';
                if(!empty($item['show_primary']))
                {
                    $t = explode(',',$item['show_primary']);
                    foreach ($t as $v)
                    {
                        if(isset($this->gamesList[$v]))
                            $item['show_primary_text'] .= $this->gamesList[$v].',';
                    }
                    $item['show_primary_text'] = rtrim($item['show_primary_text'],',');
                }
                $item['show_more_text']='';
                if(!empty($item['show_more']))
                {
                    $t = explode(',',$item['show_more']);
                    foreach ($t as $v)
                    {
                        if(isset($this->gamesList[$v]))
                            $item['show_more_text'] .= $this->gamesList[$v].',';
                    }
                    $item['show_more_text'] = rtrim($item['show_more_text'],',');
                }
                $item['status_text'] = $item['status']?'normal':'hidden';
                $item['show_charge_text'] = $item['show_charge']?'normal':'hidden';

            }
            $result = array("total" => $total, "rows" => $list);
            return json($result);
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

        $notify_way = json_decode($row['warning'],true);
        $row['notify_way'] = $notify_way['notify_way'];
        $row['ceil'] = $notify_way['ceil'];
        $row['new_ceil'] = $notify_way['new_ceil'];
        $row['to'] = isset($notify_way['to'])?$notify_way['to']:'';
        $this->view->assign("row", $row);
        $this->view->assign("gameList", json_decode($row['game'],true));
        return $this->view->fetch();
    }

    /**
     * 改变游戏序列
     * elseif($operate_type == 'start')
    {
    $data=["quick_start_tame"=>$game_id_str];
    }
     * @return \think\response\Json
     */
    public function changeGames()
    {
        $id = $this->request->post('pk');
        $game_arr =  input('post.value/a');

        $operate_type =  $this->request->post('operate');
        $g = array_flip($this->gamesList);
        $game_id_str='';
        if($game_arr)
        {
            foreach ($game_arr as $game)
            {
                if(isset($g[$game]))
                    $game_id_str .=$g[$game].',';
            }
            $game_id_str = rtrim($game_id_str,',');
        }
        if($operate_type == 'primary')
        {
            $data=["show_primary"=>$game_id_str];
        }elseif ($operate_type == 'more'){
            $data=["show_more"=>$game_id_str];
        }else{
            return json(['msg'=>'修改失败,操作类型不符合','data'=>$_POST]);
        }
        $ret = model("PokerSwitchSetting")->where(['id'=>$id])->update($data);
        return json(['msg'=>'修改成功','data'=>$_POST]);
    }

}
