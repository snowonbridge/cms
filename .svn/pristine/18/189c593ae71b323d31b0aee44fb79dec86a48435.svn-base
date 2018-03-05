<?php

namespace app\admin\controller\player;

use app\admin\model\PlayerUsergame;
use app\common\controller\Backend;
use helper\Code;
use helper\Okey;
use think\Cache;
use think\Db;
use think\Exception;

/**
 * 单页管理
 *
 * @icon fa fa-circle-o
 * @remark 用于管理普通的单页面,通常用于关于我们、联系我们、商务合作等单一页面
 */
class Detail extends Backend
{

    protected $model = null;
    protected $relationSearch = true;

    public function _initialize()
    {
        $actionname = strtolower($this->request->action());
        if($actionname == 'index' && $this->request->isAjax()){
            $this->layout = '';
        }
        parent::_initialize();
        $this->model = model('User');
    }

    /**
     * 查看
     */
    public function index()
    {

        $data = [];
        if ($this->request->isAjax()) {
            $uid = $this->request->request('keyword');
            $list = Db::connect('database.db_config1')
                ->view('poker_usergame', 'id,uid,chip,ulevel,exp,vip,roomcard,diamond,activetime,
                invite,ldays,cldays,prestige,gameid,charge,prestige_level,mentercount,
                wincnt,losecnt,drawcnt,lwincnt,subsidy_count,novitiate_receive_count,
                sid_regtime,player_type,player_type_force', null, 'LEFT')
                ->view('poker_user_map', 'sid,mid', 'poker_user_map.uid=poker_usergame.uid', 'LEFT')
                ->view('poker_user', 'openid,usertype,unid,usex,uname,avartar,avartar_type,gid,ustatus,uemail,devid,regtime,region_id,city_id',
                    'poker_user.id=poker_user_map.mid', 'LEFT')
                ->view('poker_online', 'olkey,ollogintime,refreshtime,area,gameid,tid,svid,usertype,unid,ip', 'poker_online.uid=poker_user_map.uid', 'LEFT')
                ->where('poker_usergame.uid', '=', $uid)
                ->find();
            if($list){
                if($list['avartar_type']==2 && strpos($list['avartar'],'http')==false){
                    $list['avartar'] = '/common/img/head/pic_head'.($list['avartar'] < 10 ? '0'.$list['avartar'] : $list['avartar']).'.png';
                }
                if($list['ip']){
                    $list['ip'] = long2ip($list['ip']);
                }
                if($list['sid']){
                    $list['sid'] = isset(config('sidList')[$list['sid']]) ? config('sidList')[$list['sid']] : '未知平台';
                }

                if(isset($list['ustatus'])){
                    $list['ustatus'] = ($list['ustatus']!=0) ? '被封' : '正常';
                }
                if(isset($list['sid_regtime']) && $list['sid_regtime']){
                    $list['regtime'] = $list['sid_regtime'];
                }
                if(isset($list['player_type']) && $list['player_type']){
                    $player_type = $list['player_type_force'] > 0 ? $list['player_type_force']:$list['player_type'];//强制优先
                    $list['player_type_text'] = $player_type < 2 ? '普通玩家' : '高级玩家';
                }
                $list['location_info'] = '其他';
                if(!empty($list['region_id']) && !empty($list['city_id'])){
                    $PokerUcCityInfoModel = model('PokerUcCityInfo');
                    $regionList = $PokerUcCityInfoModel->getRegionList();
                    $cityList = $PokerUcCityInfoModel->getCityList();
                    $region = isset($regionList[$list['region_id']]) ? $regionList[$list['region_id']] : '';
                    $city = isset($cityList[$list['city_id']]) ? $cityList[$list['city_id']] : '';
                    $list['location_info'] = $region.$city;
                }
            }

            $this->view->assign('data', $list);
            return $this->view->fetch('base');
        }
        $this->view->assign('data', $data);
        return $this->view->fetch();
    }



    /**
     * Selectpage的实现方法
     *
     * 当前方法只是一个比较通用的搜索匹配,请按需重载此方法来编写自己的搜索逻辑,$where按自己的需求写即可
     * 这里示例了所有的参数，所以比较复杂，实现上自己实现只需简单的几行即可
     *
     */
    public function selectpage()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags', 'htmlspecialchars']);

        //搜索字段
//        'poker_user.uname', 'poker_user.id', 'poker_user_map.uid'
        $searchfield = $this->request->request("type/s");

        //搜索关键词
        $word = $this->request->request("q_word/a");
        $word = $word[0]; //只取一个

        $page = $this->request->request("page");
        //分页大小
        $pagesize = $this->request->request("per_page");
        //搜索条件
//        $andor = $this->request->request("and_or");
        //排序方式
        $orderby = (array)$this->request->request("order_by/a");

        $order = [];
        foreach ($orderby as $k => $v) {
            $order[$v[0]] = $v[1];
        }

        $list = [];
        $total = 0;
        if(!$word){
            return json(['list' => $list, 'totalRow' => $total]);
        }

        //显示的字段
        $field = $this->request->request("field");
        //主键
        $primarykey = 'id';

        $op = strpos($word,'%') ? 'like' : '=';
        $sVal = $op === 'like' ? $word.'%' : $word;
        $field = $field ? $field : 'uname';
        $total = Db::connect('database.db_config1')
            ->view('poker_user_map', 'uid,sid,mid', null, 'LEFT')
            ->view('poker_user', 'id,uname', 'poker_user_map.mid=poker_user.id', 'LEFT')
            ->where($searchfield,$op,$sVal)
            ->count();
        if ( $total > 0) {
            $list = Db::connect('database.db_config1')
                ->view('poker_user', 'id,uname', null, 'LEFT')
                ->view('poker_user_map', 'uid,sid,mid', 'poker_user_map.mid=poker_user.id', 'LEFT')
                ->order($order)
                ->page($page, $pagesize)
                ->field("{$primarykey},{$field}")
                ->where($searchfield,$op,$sVal)
                ->select();
        }

        //这里一定要返回有list这个字段,total是可选的,如果total<=list的数量,则会隐藏分页按钮
        return json(['list' => $list, 'totalRow' => $total]);
    }

    public function changeplayertype($uid,$mid){

        $model = new PlayerUsergame();
        $row = $model->where(['uid'=>intval($uid)])->find();
        if (!$row || empty($mid))
            $this->error(__('No Results were found'));
        if ($this->request->isPost())
        {
            $uid = (int)request()->param('uid');
            $player_type_force = (int)request()->param('player_type_force');

            if ($uid && isset($player_type_force))
            {
                if($player_type_force != $row->player_type_force){
                    $row->player_type_force = $player_type_force;
                    try
                    {
                        $result = $row->save();

                        if ($result == Code::SUCCESS)
                        {
                            $redis = Cache::store('redis')->handler();
                            $r_player_type_force = $redis->hGet(Okey::rU($uid),'player_type_force');
                            if($r_player_type_force !== false){//存在则更新玩家缓存
                                $redis->hSet(Okey::rU($uid),'player_type_force',$player_type_force);
                            }
                            $this->success();
                        }
                        else
                        {
                            $this->error('数据库保存失败');
                        }
                    }
                    catch (Exception $e)
                    {
                        $this->error($e->getMessage());
                    }
                }else{
                    $this->success();
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        //$player_type = $row['player_type_force'] > 0 ? $row['player_type_force']:$row['player_type'];//强制优先
        $row['mid'] = $mid;
        $this->view->assign("row", $row);
        return $this->view->fetch('',['playerTypeList'=>[0=>'不强制',1=>'普通玩家',2=>'高级玩家']]);
    }


}
