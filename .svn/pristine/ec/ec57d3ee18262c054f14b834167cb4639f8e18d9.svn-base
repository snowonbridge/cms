<?php
namespace app\admin\model;

use helper\Code;
use helper\Func;
use helper\Okey;
use think\Cache;
use think\Model;

class CmsControlStoreSetting extends Model
{
    //protected $connection = 'db_config_poker';

    // 表名
    protected $name = 'control_store_setting';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    //状态
    const STATUS_ON = 1 ;//正常
    const STATUS_OFF = 0 ;



    // 追加属性
   /* protected $append = [
        'avartar_url',
    ];

    public function getAvartarUrlAttr($value, $data)
    {

    }*/

    public function getControlStoreList(){
        $model = new CmsAppConfig();
        $list = $model->getOnlineStoreList();
        $arr = array_column($list,'unid_name','unid');
        return $arr;
    }


    public function saveSetting($app_id,$setting){

        $controlStoreSettingModel = $this;
        $areaList = $this->getControlStoreList();

        $controlStoreSetting = $controlStoreSettingModel->where(['app_id'=>$app_id,'status'=>self::STATUS_ON])->select();
        if($controlStoreSetting){
            $controlStoreSettingArr = $controlStoreSetting->toArray();
            $controlStoreSettingArr = Func::array_index($controlStoreSettingArr,'control_store');
        }else{
            $controlStoreSettingArr = [];
        }

        $save = true;
        $controlStoreSettingModel->startTrans();
        $num = 0;
        foreach($areaList as $k => $v){
            $isControlShow = 0;
            $timeControl = 0;
            $ddz = 1;
            $ysz = 1;
            $lhd = 1;
            $mj = 0;
            $nn = 1;
            if(isset($controlStoreSettingArr[$k])){
                $isControlShow = $controlStoreSettingArr[$k]['is_control_show'];
                $timeControl = $controlStoreSettingArr[$k]['time_control'];
                $ddz = $controlStoreSettingArr[$k]['ddz'];
                $ysz = $controlStoreSettingArr[$k]['ysz'];
                $lhd = $controlStoreSettingArr[$k]['lhd'];
                $mj = $controlStoreSettingArr[$k]['mj'];
                $nn = $controlStoreSettingArr[$k]['nn'];
            }
            if(isset($setting[$k])){
                $isControlShow = $setting[$k]['is_control_show'];
                $timeControl = $setting[$k]['time_control'];
                $ddz = $setting[$k]['ddz'];
                $ysz = $setting[$k]['ysz'];
                $lhd = $setting[$k]['lhd'];
                $mj = $setting[$k]['mj'];
                $nn = $setting[$k]['nn'];
            }

            $one = $controlStoreSettingModel->where(['control_store'=>$k,'app_id'=>$app_id,'status'=>1])->find();
            if(empty($one)){//新建默认开启
                $isControlShow = 0;
                $timeControl = 0;
                $ddz = 1;
                $ysz = 1;
                $lhd = 1;
                $mj = 0;
                $nn = 1;
            }

            $data = [
                'app_id'=>$app_id,
                'control_store'=>$k,
                'is_control_show'=>$isControlShow,
                'time_control'=>$timeControl,
                'ddz'=>$ddz,
                'ysz'=>$ysz,
                'lhd'=>$lhd,
                'mj'=>$mj,
                'nn'=>$nn,
            ];

            if($one){
                $data = array_merge($data,['update_time'=>time(),]);
                $save = (new CmsControlStoreSetting())->save($data,['control_store'=>$k,'app_id'=>$app_id]);
                if(!$save){
                    break;
                }else{
                    $num = $num+1;
                }
            }else{

                $save = (new CmsControlStoreSetting())->save($data);

                if(!$save){
                    break;
                }else{
                    $num = $num+1;
                }
            }
        }
        if($save){
            $controlStoreSettingModel->commit();

            $redis = Cache::store('redis');
            $redis->rm(Okey::rControlStoreSetting($app_id));

            $res = ['code'=>Code::SUCCESS,'msg'=>' 成功','data'=>['num'=>$num]];
        }else{
            $controlStoreSettingModel->rollback();
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>' 失败','data'=>[]];
        }
        return $res;
    }


}