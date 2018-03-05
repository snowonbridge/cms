<?php
namespace app\admin\model;

use helper\Code;
use helper\Func;
use helper\Okey;
use think\Cache;
use think\Model;

class CmsAppConfig extends Model
{
    //protected $connection = 'db_config_poker';

    // 表名
    protected $name = 'app_config';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

    //状态
    const STATUS_ON = 1 ;//正常
    const STATUS_OFF = 0 ;

    //name
    const STORE = 'store';


    // 追加属性
   /* protected $append = [
        'avartar_url',
    ];

    public function getAvartarUrlAttr($value, $data)
    {

    }*/

    public function getSelectStoreList(){
        $unidsMap = config('unidsMap');
        unset($unidsMap[1]);//去除苹果渠道
        return (array)$unidsMap;
    }

    public function getOnlineStoreList(){
        $res = $this->getConfig(self::STORE);
        $list = \GuzzleHttp\json_decode($res,true);
        return (array)$list;
    }


    public function addOnlineStore($unid){

        $list = $this->getOnlineStoreList();
        $store_id_arr = array_column($list,'unid');
        $unidsMap = config('unidsMap');
        $rule_unid = array_column($unidsMap,'unid');

        if(!in_array($unid,$rule_unid)){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'渠道id不对','data'=>[]];
            return $res;
        }

        if(in_array($unid,$store_id_arr)){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'渠道已存在，请勿重复添加','data'=>[]];
            return $res;
        }

        $add_arr = [['unid'=>$unid,'unid_name'=>$unidsMap[$unid]['unid_name'],'unid_no'=>$unidsMap[$unid]['unid_no']]];
        $set_arr = array_merge($list,$add_arr);
        $set_res = $this->setConfig(self::STORE,json_encode($set_arr,JSON_UNESCAPED_UNICODE));
        if($set_res){

            $res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>[]];
        }else{
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'数据库更新失败','data'=>[]];
        }
        return $res;
    }

    public function delOnlineStore($unid){

        $list = $this->getOnlineStoreList();
        $store_id_arr = array_column($list,'unid');

        $unidsMap = config('unidsMap');
        $rule_unid = array_column($unidsMap,'unid');

        if(!in_array($unid,$rule_unid)){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'渠道id不对','data'=>[]];
            return $res;
        }

        if(!in_array($unid,$store_id_arr)){
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'该渠道已下架','data'=>[]];
            return $res;
        }

        foreach($list as $k=>$v){
            if($unid == $v['unid']){
                unset($list[$k]);
            }
        }

        $set_arr = array_values($list);
        $set_res = $this->setConfig(self::STORE,json_encode($set_arr,JSON_UNESCAPED_UNICODE));
        if($set_res){

            $controlStoreSettingModel = new CmsControlStoreSetting();

            $appList = $controlStoreSettingModel->field('app_id')->where(['status'=>1,'control_store'=>$unid])->select();
            if($appList){
                $redis = Cache::store('redis');
                foreach($appList as $v){
                    $redis->rm(Okey::rControlStoreSetting($v['app_id']));
                }

            }

            $data['update_time'] = time();
            $data['is_control_show'] = 1;
            $data['status'] = 0;
            $saveList = $controlStoreSettingModel->save($data,['control_store'=>$unid]);


            $res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>[]];
        }else{
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'数据库更新失败','data'=>[]];
        }
        return $res;
    }

    public function getConfig($name){
        $res =  $this->field('value')->where(['name'=>$name])->find();
        return $res['value'];
    }

    public function setConfig($name,$value){
        $isSet = $this->getConfig($name);
        if($isSet){
            $res = $this->save(['value'=>$value],['name'=>$name,]);
        }else{
            $res = $this->save(['name'=>$name,'value'=>$value]);
        }
        return $res;
    }


}