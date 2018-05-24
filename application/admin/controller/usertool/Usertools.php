<?php

namespace app\admin\controller\usertool;

use app\common\controller\Backend;

use app\common\model\Config;
use think\Controller;
use think\Request;

/**
 * 用户道具管理
 *
 * @icon fa fa-circle-o
 */
class Usertools extends Backend
{
    
    /**
     * PokerUsertoolsView模型对象
     */
    protected $model = null;
    protected $user_model = null;
    protected $map_model = null;
    protected $tool_model = null;


    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('PokerUsertoolsView');
        $this->map_model = model('PokerUserMap');
        $this->user_model = model('User');
        $this->tool_model = model('ItemsConfig');

    }
    protected function buildparams($searchfields = null, $relationSearch = null)
    {
        $searchfields = is_null($searchfields) ? $this->searchFields : $searchfields;
        $relationSearch = is_null($relationSearch) ? $this->relationSearch : $relationSearch;
        $search = $this->request->get("search", '');
        $filter = $this->request->get("filter", '');
        $op = $this->request->get("op", '', 'trim');
        $sort = $this->request->get("sort", "id");
        $order = $this->request->get("order", "DESC");
        $offset = $this->request->get("offset", 0);
        $limit = $this->request->get("limit", 0);
        $filter = json_decode($filter, TRUE);
        $op = json_decode($op, TRUE);
        $filter = $filter ? $filter : [];
        $where = [];
        $tableName = '';
        if ($relationSearch)
        {
            if (!empty($this->model))
            {
                $class = get_class($this->model);
                $name = basename(str_replace('\\', '/', $class));
                $tableName = $this->model->getQuery()->getTable($name) . ".";
            }
            $sort = stripos($sort, ".") === false ? $tableName . $sort : $sort;
        }
        if ($search)
        {
            $searcharr = is_array($searchfields) ? $searchfields : explode(',', $searchfields);
            foreach ($searcharr as $k => &$v)
            {
                $v = stripos($v, ".") === false ? $tableName . $v : $v;
            }
            unset($v);
            $where[] = [implode("|", $searcharr), "LIKE", "%{$search}%"];
        }
        foreach($filter as $k=>$v)
        {

        }
        foreach ($filter as $k => $v)
        {

            if($this->filterSearch &&  in_array($k,$this->filterSearch)) continue;
            $sym = isset($op[$k]) ? $op[$k] : '=';
            if (stripos($k, ".") === false)
            {
                $k = $tableName . $k;
            }
            $sym = isset($op[$k]) ? $op[$k] : $sym;
            /**
             * 添加代码
             */
            if($k == 'mid')
            {
                $r_uid = $this->map_model->where("mid={$v}")->find();
                $k='uid';
                $v=$r_uid->uid;
            }elseif($k == 'uname')
            {
                $r_mid = $this->user_model->where("uname",'=',"{$v}")->column('id');
                $uid_arr = $this->map_model->where("mid",'IN',$r_mid)->where("sid",'=',10001)->column('uid');
                $k='uid';
                $sym="IN";
                $v=implode(',', $uid_arr);
            }elseif($k == 'channel_name')
            {//值为ID值
                $r_mid = $this->user_model->where("unid",'=',"{$v}")->column('id');
                $uid_arr = $this->map_model->where("mid",'IN',$r_mid)->where("sid",'=',10001)->column('uid');
                $k='uid';
                $sym="IN";
                $v=implode(',', $uid_arr);
            }elseif($k == 'tool_name')
            {
                $tlid_arr = $this->tool_model->where('name','LIKE','%'.$v.'%')->column('tlid');
                $k='tlid';
                $sym="IN";
                $v=implode(',', $tlid_arr);
            }elseif($k == 'is_using')
            {
                $cur = time();
                if(intval($v) == 1)
                {
                    $where[] = ['usetime', '<=', time()];
                    $where[] = ['expire', '>=', time()];
                }else if(intval($v) == 0){
                    $where[] = "usetime > $cur or expire<$cur";
                }
                continue;
            }elseif($k == 'valid_duration')
            {
                $where[] = '(CAST(expire AS SIGNED ) -CAST(usetime AS SIGNED )) >= '. intval($v);
                continue;
            }elseif($k == 'gettime')
            {
                $where[] = [$k, '>=', strtotime($v) ];continue;
            }elseif($k == 'expire')
            {
                $where[] = [$k, '>=', strtotime($v) ];continue;
            }

            switch ($sym)
            {
                case '=':
                case '!=':
                case 'LIKE':
                case 'NOT LIKE':
                    $where[] = [$k, $sym, (string) $v];
                    break;
                case '>':
                case '>=':
                case '<':
                case '<=':
                    $where[] = [$k, $sym, intval($v)];
                    break;
                case 'IN':
                case 'IN(...)':
                case 'NOT IN':
                case 'NOT IN(...)':
                    $where[] = [$k, str_replace('(...)', '', $sym), explode(',', $v)];
                    break;
                case 'BETWEEN':
                case 'NOT BETWEEN':
                    $arr = array_slice(explode(',', $v), 0, 2);
                    if (stripos($v, ',') === false || !array_filter($arr))
                        continue;
                    //当出现一边为空时改变操作符
                    if ($arr[0] === '')
                    {
                        $sym = $sym == 'BETWEEN' ? '<=' : '>';
                        $arr = $arr[1];
                    }
                    else if ($arr[1] === '')
                    {
                        $sym = $sym == 'BETWEEN' ? '>=' : '<';
                        $arr = $arr[0];
                    }
                    $where[] = [$k, $sym, $arr];
                    break;
                case 'LIKE':
                case 'LIKE %...%':
                    $where[] = [$k, 'LIKE', "%{$v}%"];
                    break;
                case 'NULL':
                case 'IS NULL':
                case 'NOT NULL':
                case 'IS NOT NULL':
                    $where[] = [$k, strtolower(str_replace('IS ', '', $sym))];
                    break;
                default:
                    break;
            }
        }
        $where = function($query) use ($where) {
            foreach ($where as $k => $v)
            {
                if (is_array($v))
                {
                    call_user_func_array([$query, 'where'], $v);
                }
                else
                {
                    $query->where($v);
                }
            }
        };
        return [$where, $sort, $order, $offset, $limit];
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
            $channelList = config('unidsMap');
            foreach($list as $k=>&$item)
            {
                $item['id'] = $item['ttid'];
                //get mid,sid
                $r_mid = $this->map_model->where("uid={$item['uid']}")->find();
                $item['mid'] = $r_mid?$r_mid->mid:0;
                $item['sid'] = $r_mid?$r_mid->sid:0;
                //渠道id
                $user = $this->user_model->where("id={$item['mid']}")->find();
                $unid = $user?$user->unid:0;
                $item['uname'] = $user?$user->uname:'';
                $channel_name = isset($channelList[$unid])?$channelList[$unid]['unid_name']:'';
                //渠道名称
                $item['channel_name'] = $channel_name."($unid)";
                //道具名称
                $item['tool_name'] = $this->tool_model->getName($item['tlid']);
                //是否正在使用
                $item['is_using'] = $item['usetime']<=time()&&time()<=$item['expire'] ?'是':'否';
                $item['valid_duration'] = $item['expire']-$item['usetime'];



            }

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }



}
