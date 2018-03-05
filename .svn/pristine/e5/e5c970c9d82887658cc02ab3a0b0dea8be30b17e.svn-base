<?php
namespace app\admin\model;

use helper\Code;
use helper\Func;
use helper\Okey;
use think\Cache;
use think\Model;

class CmsControlAppList extends Model
{
    //protected $connection = 'db_config_poker';

    // 表名
    protected $name = 'control_app_list';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = true;

    // 定义时间戳字段名
    protected $createTime = 'create_time';
    protected $updateTime = 'update_time';

    //状态
    const STATUS_ON = 1 ;//正常
    const STATUS_OFF = 0 ;



    // 追加属性
    protected $append = [
        'sid_text',
    ];

    public function getSidTextAttr($value, $data)
    {
        $config = config('sidList');
        if(isset($config[$data['sid']])){
            return $config[$data['sid']];
        }else{
            return '其他游戏';
        }
    }

    public function getAppList(){
        $list = $this->where(['status'=>self::STATUS_ON])->select();
        return $list;
    }

    public function getAppVersionList(){
        $list = $this->field('id,sid,version')->where(['status'=>self::STATUS_ON])->select();
        $config = config('sidList');
        $arr=[];
        foreach($list as $k=>$v){
            $arr[$v['sid']]['sid'] = $v['sid'];
            $arr[$v['sid']]['sid_text'] = $config[$v['sid']];
            $arr[$v['sid']]['versionList'][] = [
                        'sid'=> $v['sid'],
                        'app_id'=> $v['id'],
                        'version'=> $v['version'],
            ];
        }
        return array_values($arr);
    }

    public function addAppList($sid,$version){
        $data['sid'] = $sid;
        $data['version'] = $version;
        $data['status'] = self::STATUS_ON;
        $id = $this->save($data);
        if($id){

            $redis = Cache::store('redis');
            $redis->rm(Okey::rControlAppList($sid));

            $res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>['id'=>$this->id]];
        }else{
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'数据库更新失败','data'=>[]];
        }
        return $res;
    }

    public function delAppList($app_id){
        $app = $this->where(['id'=>$app_id,'status'=>self::STATUS_ON])->find();
        if($app){
            $data['status'] = self::STATUS_OFF;
            $save = $app->save($data);
            if($save){

                $controlStoreSettingModel = new CmsControlStoreSetting();
                $controlAreaSettingModel = new CmsControlAreaSetting();
                $data['update_time'] = time();
                $data['is_control_show'] = 1;
                $saveAreaList = $controlAreaSettingModel->save($data,['app_id'=>$app_id]);
                $saveStoreList = $controlStoreSettingModel->save($data,['app_id'=>$app_id]);

                $redis = Cache::store('redis');
                $redis->rm(Okey::rControlAppList($app['sid']));
                $redis->rm(Okey::rControlAreaSetting($app_id));
                $redis->rm(Okey::rControlStoreSetting($app_id));

                $res = ['code'=>Code::SUCCESS,'msg'=>'成功','data'=>[]];
            }else{
                $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'数据库更新失败','data'=>[]];
            }
        }else{
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>'不存在的该游戏应用','data'=>[]];
        }
        return $res;
    }
}