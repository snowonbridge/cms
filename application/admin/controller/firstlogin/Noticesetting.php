<?php

namespace app\admin\controller\firstlogin;

use app\common\controller\Backend;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 公告
 *
 * @icon fa fa-circle-o
 */
class Noticesetting extends Backend
{
    
    /**
     * PokerNotice模型对象
     */
    protected $model = null;
    protected $versionList;
    protected $statusList;
    protected $typeList;
    protected $redirectList;
    protected $sidList;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('PokerNotice');
        $this->versionList=['1.0.0'=>'1.0.0','1.1.0'=>'1.1.0','1.2.0'=>'1.2.0'];
        $this->statusList=['0'=>'Hidden','1'=>'Normal'];
        $this->sidList=['10001'=>'线上版','10002'=>'线下版'];
        $this->typeList=['1'=>'登录前公告','2'=>'登录后公告'];//1@登录前公告,2@登录后公告
        $this->redirectList=Db::table('redirect_setting')->connect('db_config2')->column('title','id');

        $this->assign("versionList",$this->versionList);
        $this->assign("statusList",$this->statusList);
        $this->assign("sidList",$this->sidList);
        $this->assign("typeList",$this->typeList);
        $this->assign("redirectList",$this->redirectList);
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
            foreach ($list as $k=>&$item)
            {
                $item['type_text']= $this->typeList[$item['type']];
                $item['status_text']= $item['status']?'normal':'hidden';
                $item['sid_text']='';

                $t = explode(',',$item['sid']);
                foreach ($t as $v)
                {
                    $item['sid_text'] .= $this->sidList[$v].',';
                }
                $item['sid_text'] = rtrim($item['sid_text'],',');
                $item['status_text']= $item['status']?'normal':'hidden';
                $item['redirect_id_text']= isset($this->redirectList[$item['redirect_id']])?$this->redirectList[$item['redirect_id']]:'-';
                $item['channel_text'] = model('ActivityChannel')->where(['channel_id'=>$item['channel_id']])->value('channel_name');
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
                $params['img'] = !empty($params['img'])?$this->getImgUrl($params['img']):'';

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
    function getImgUrl($img_path)
    {
        $pageURL = 'http';
        if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on")
        {
            $pageURL .= "s";
        }
        $pageURL .= "://";

        if($_SERVER["SERVER_PORT"] != "80")
        {
            $pageURL .= $_SERVER["HTTP_HOST"] . ":" . $_SERVER["SERVER_PORT"] . $img_path;
        }
        else
        {
            $pageURL .= $_SERVER["HTTP_HOST"] . $img_path;
        }
        return $pageURL;
    }

}
