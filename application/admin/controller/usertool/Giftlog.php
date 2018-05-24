<?php

namespace app\admin\controller\usertool;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 礼物操作日志
 *
 * @icon fa fa-circle-o
 */
class Giftlog extends Backend
{
    
    /**
     * GiftLog模型对象
     */
    protected $model = null;
    protected $user_model;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('GiftLog');
        $this->user_model = model('User');

        $this->operateTypeList = $this->model->getOperateTypeList();
        $this->mtypeList = $this->model->getMTypeList();
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    private $operateTypeList;
    private $mtypeList;



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
            $giftList = config('friend_gift_list');
            $channelList = config('unidsMap');

            foreach($list as $k=>&$item)
            {
                $user = $this->user_model->where("id={$item['mid']}")->find();
                $item['uname'] = $user ?$user->uname:'';
                $user = $this->user_model->where("id={$item['give_mid']}")->find();
                $item['give_uname'] = $user ?$user->uname:'';
                $channel_name = isset( $channelList[$item['channel_id']])?$channelList[$item['channel_id']]['unid_name']:'';
                //渠道名称
                $item['channel_id'] = $channel_name."({$item['channel_id']})";

                $item['m_type']= isset($this->mtypeList[$item['m_type']])?$this->mtypeList[$item['m_type']]:0;
                $item['operate_type']= isset($this->operateTypeList[$item['operate_type']])?$this->operateTypeList[$item['operate_type']]:0;
                $item['gift_name'] = isset($giftList[$item['gift_id']])?$giftList[$item['gift_id']]['name']:'';
            }

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

}
