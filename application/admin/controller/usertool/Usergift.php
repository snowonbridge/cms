<?php

namespace app\admin\controller\usertool;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 用户礼物管理
 *
 * @icon fa fa-circle-o
 */
class Usergift extends Backend
{
    
    /**
     * PokerUserGift模型对象
     */
    protected $model = null;
    protected $user_model;
    protected $map_model;
    private $mtypeList;
    private $refList;
    private $giftList;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('PokerUserGift');
        $this->user_model = model('User');
        $this->map_model = model('PokerUserMap');

        $this->mtypeList = $this->model->getMTypeList();
        $this->refList = $this->model->getRefList();
        $this->giftList = config('friend_gift_list');
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
            $giftList = $this->giftList;
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
                $r_mid = $this->map_model->where("uid={$item['uid']}")->find();

                $item['mid'] = $r_mid?$r_mid->mid:'0';
                $item['sid'] = $r_mid?$r_mid->sid:'异常';
                //渠道id
                $user = $this->user_model->where("id={$item['mid']}")->find();
                $item['uname'] = $user ?$user->uname:"用户异常(uid:{$item['uid']})";

                $channel_name = isset($channelList[$item['unid']])?$channelList[$item['unid']]['unid_name']:'';
                //渠道名称
                $item['unid'] = $channel_name."({$item['unid']})";

                $item['gift_name'] = $giftList[$item['gid']]['name'];
                $item['m_type'] = isset($this->mtypeList[$item['m_type']])?$this->mtypeList[$item['m_type']]:$item['m_type'];
                $item['ref'] = isset($item['ref'])?$this->refList[$item['ref']]:$item['ref'];
                $item['discount_rate'] = $item['discount_rate'].'%';
            }

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
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
                $r_mid = $this->user_model->where("uname",'LIKE',"{$v}%")->column('id');
                $uid_arr = $this->map_model->where("mid",'IN',$r_mid)->where("sid",'=',10001)->column('uid');
                $k='uid';
                $sym="IN";
                $v=implode(',', $uid_arr);
            }elseif($k == 'gettime')
            {
                $where[] = [$k, '>=', strtotime($v) ];continue;
            }elseif($k == 'gift_name')
            {
                $ids = [];
                foreach($this->giftList as $id=>$item)
                {
                    if(false !== strstr($item['name'],$v))
                    {
                        $ids[] = $id;
                    }
                }
                $k='gid';
                $sym="IN";
                $v=implode(',', $ids);
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
}
