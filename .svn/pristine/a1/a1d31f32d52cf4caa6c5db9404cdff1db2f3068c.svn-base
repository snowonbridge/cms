<?php

namespace app\admin\controller\control;

use app\admin\model\CmsControlAppList;
use app\admin\model\CmsControlAreaSetting;
use app\admin\model\PokerUcCityInfo;
use app\common\controller\Backend;

use helper\Code;
use helper\Func;
use helper\Okey;
use think\Cache;
use think\Controller;
use think\Exception;
use think\Request;
use think\Session;

class Area extends Backend
//class Area extends Controller
{

    public $admin = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->admin = Session::get('admin');
        //todo 将管理员可操作的游戏平台id加入admin session
    }

    public function index(){

        $app_id =  (int)request()->param('app_id',0);

        //var_dump($this->request->isAjax());
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
            //if ($this->request->isPost())
        {

            return $this->getSetting($app_id);

        }

        $configModel = new CmsControlAppList();
        $selectGame = $configModel->getAppVersionList();

        $sidList = [];
        $arr = [];
        if(!empty($selectGame)){
            $sidList = array_column($selectGame,'sid_text','sid');
            $versionList = array_column($selectGame,'versionList');
            foreach($versionList as $v){
                foreach($v as $v1){
                    $arr[$v1['app_id']] = [
                        'sid'=>$v1['sid'],
                        'app_id'=>$v1['app_id'],
                        'version'=>$v1['version'],
                    ];
                }
            }
        }

        $redis = Cache::store('redis');
        $setting = $redis->get(Okey::rControlTimeCommonSetting());
        if (empty($setting)){
            $setting = [//支持多个时间段，默认8:00到20:00时间段不开
                ['00:00','08:00'],
                ['20:00','23:59']
            ];
        }
        $timeCommonSettingText = '';
        foreach ($setting as $k=>$v){
            $strv = ';'.implode('~',$v);
            $timeCommonSettingText = $timeCommonSettingText.$strv;
        }
        $timeCommonSettingText = trim($timeCommonSettingText,';');

        return $this->view->fetch('',['sidList'=>[0=>'未选择']+$sidList,
            'versionList'=>array_merge([0=>['sid'=>0, 'app_id'=>0, 'version'=>'未选择',]],$arr),'timeCommonSettingText'=>$timeCommonSettingText]);
    }


    public function selectGame(){

        $configModel = new CmsControlAppList();
        $arr = $configModel->getAppVersionList();


        $res = ['code'=>Code::SUCCESS,'msg'=>' 成功','data'=>$arr];
        return json($res);

    }


    public function getSetting($app_id=''){

       // $app_id =  (int)request()->param('app_id');
        $cmsControlAppListModel = new CmsControlAppList();
        $app = $cmsControlAppListModel->where(['status'=>$cmsControlAppListModel::STATUS_ON,'id'=>$app_id])->find();
        if(empty($app_id) || !$app ){
            $res = ['code'=>Code::SUCCESS,'msg'=>'没有数据','data'=>[], "total" => 0, "rows" => [],];
            return json($res);
        }

        $controlAreaSettingModel = new CmsControlAreaSetting();
        $areaList = $controlAreaSettingModel->getControlAreaList();

        $controlAreaSetting = $controlAreaSettingModel->where(['app_id'=>$app_id,'status'=>$controlAreaSettingModel::STATUS_ON])->select();
        if($controlAreaSetting){
            $controlAreaSettingArr = $controlAreaSetting->toArray();
            $controlAreaSettingArr = Func::array_index($controlAreaSettingArr,'control_area');
        }else{
            $controlAreaSettingArr = [];
        }

        $arr =[];

        foreach($areaList as $k => $v){
            $isControlShow = 1;
            $timeControl = 0;
            $ddz = 0;
            $ysz = 0;
            $lhd = 0;
            $mj = 0;
            $nn = 0;
            if(isset($controlAreaSettingArr[$k])){
                $isControlShow = $controlAreaSettingArr[$k]['is_control_show'];
                $timeControl = $controlAreaSettingArr[$k]['time_control'];
                $ddz = $controlAreaSettingArr[$k]['ddz'];
                $ysz = $controlAreaSettingArr[$k]['ysz'];
                $lhd = $controlAreaSettingArr[$k]['lhd'];
                $mj = $controlAreaSettingArr[$k]['mj'];
                $nn = $controlAreaSettingArr[$k]['nn'];

            }
            $arr[]= [
                'control_area'=>$k,
                'control_area_text'=>$controlAreaSettingModel->getControlAreaList()[$k],
                'is_control_show'=>$isControlShow,
                'time_control'=>$timeControl,
                'ddz'=>$ddz,
                'ysz'=>$ysz,
                'lhd'=>$lhd,
                'mj'=>$mj,
                'nn'=>$nn,
            ];

        }

        $result = array(
            "total" => count($arr),
            "rows" => $arr,
        );

        $res = array_merge(['code'=>Code::SUCCESS,'msg'=>' 成功','data'=>[]],$result);
        return json($res);

    }



    public function saveSetting(){

        $app_id =  (int)request()->param('app_id');
        $setting =  (array)request()->param('setting/a');

        if(empty($app_id) || empty($setting) || !is_array($setting)){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'参数不能为空','data'=>[]];
            return json($res);
        }
        $setting = Func::array_index($setting,'control_area');

        $controlAreaSettingModel = new CmsControlAreaSetting();
        $res = $controlAreaSettingModel->saveControlAreaSetting($app_id,$setting);
        return json($res);

    }

    

}
