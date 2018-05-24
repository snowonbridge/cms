<?php

namespace app\admin\controller\friend;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 好友申请管理
 *
 * @icon fa fa-circle-o
 */
class Pokerfriendapply extends Backend
{
    
    /**
     * PokerFriendApply模型对象
     */
    protected $model = null;
    protected $user_model = null;
    protected $user_map_model = null;
    private $statusList;
    private $friendStatusList;
    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('PokerFriendApply');
        $this->statusList = $this->model->getStatusList();
        $this->friendStatusList = $this->model->getFriendStatusList();
        $this->user_model = model('User');
        $this->user_map_model = model('PokerUserMap');

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    /**
     * 生成查询所需要的条件,排序方式
     * @param mixed $searchfields 快速查询的字段
     * @param boolean $relationSearch 是否关联查询
     * @return array
     */
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
        foreach ($filter as $k => $v)
        {
            if($this->filterSearch &&  in_array($k,$this->filterSearch)) continue;
            $sym = isset($op[$k]) ? $op[$k] : '=';
            if (stripos($k, ".") === false)
            {
                $k = $tableName . $k;
            }
            $sym = isset($op[$k]) ? $op[$k] : $sym;
            if($k == 'funame')
            {
                $uid_arr = $this->user_model->where("uname",'=',"{$v}")->column('id');
                $k='fuid';
                $sym="IN";
                $v=implode(',', $uid_arr);
            }elseif($k == 'tuname')
            {
                $uid_arr = $this->user_model->where("uname",'=',"{$v}")->column('id');
                $k='tuid';
                $sym="IN";
                $v=implode(',', $uid_arr);
            }elseif($k == 'unbind_time')
            {
                $k='unbind_time';
                $sym=">=";
                $v=strtotime($v);
            }elseif($k == 'agree_time')
            {
                $k='agree_time';
                $sym=">=";
                $v=strtotime($v);
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
            foreach($list as $k=>&$item)
            {
                $map1 = $this->user_map_model->where("uid={$item['fuid']}")->find();
                //get mid,sid
                $user1 = $this->user_model->where("id={$map1['mid']}")->find();
                $map2 = $this->user_map_model->where("uid={$item['tuid']}")->find();

                $item['funame'] = empty($user)?'':$user1->uname;
                $user2 = $this->user_model->where("id={$map2['mid']}")->find();

                $item['tuname'] = empty($user)?'': $user2->uname;
                $channelList = config('unidsMap');
                $item['fchannel_id'] = $channelList[$user1['unid']]['unid_name']."({$user1['unid']})";
                $item['tchannel_id'] = $channelList[$user2['unid']]['unid_name']."({$user2['unid']})";
                //是否正在使用
            }

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }

}
