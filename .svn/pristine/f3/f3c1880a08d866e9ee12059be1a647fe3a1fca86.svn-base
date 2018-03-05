<?php
namespace app\admin\model;

use helper\Code;
use helper\Func;
use helper\Okey;
use think\Cache;
use think\Model;

class CmsControlAreaSetting extends Model
{
    //protected $connection = 'db_config_poker';

    // 表名
    protected $name = 'control_area_setting';

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

    public function getControlAreaList(){
        //$list = $this->select()->toArray();
        //$list = array_column($list,'region','region_id');
        $list  = array (
            110000 => '北京',
            310000 => '上海',
            440100 => '广州',
            440300 => '深圳',
            120000 => '天津',
            130000 => '河北',
            140000 => '山西',
            150000 => '内蒙古',
            210000 => '辽宁',
            220000 => '吉林',
            230000 => '黑龙江',
            320000 => '江苏',
            330000 => '浙江',
            340000 => '安徽',
            350000 => '福建',
            360000 => '江西',
            370000 => '山东',
            410000 => '河南',
            420000 => '湖北',
            430000 => '湖南',
            440000 => '广东',
            450000 => '广西',
            460000 => '海南',
            500000 => '重庆',
            510000 => '四川',
            520000 => '贵州',
            530000 => '云南',
            540000 => '西藏',
            610000 => '陕西',
            620000 => '甘肃',
            630000 => '青海',
            640000 => '宁夏',
            650000 => '新疆',
            710000 => '台湾',
            810000 => '香港',
            820000 => '澳门',
        );
        return $list;
    }


    public function saveControlAreaSetting($app_id,$setting){

        $controlAreaSettingModel = $this;
        $areaList = $this->getControlAreaList();

        $controlAreaSetting = $controlAreaSettingModel->where(['app_id'=>$app_id,'status'=>self::STATUS_ON])->select();
        if($controlAreaSetting){
            $controlAreaSettingArr = $controlAreaSetting->toArray();
            $controlAreaSettingArr = Func::array_index($controlAreaSettingArr,'control_area');
        }else{
            $controlAreaSettingArr = [];
        }

        $save = true;
        $controlAreaSettingModel->startTrans();
        $num = 0;
        foreach($areaList as $k => $v){
            $isControlShow = 0;
            $timeControl = 0;
            $ddz = 1;
            $ysz = 1;
            $lhd = 1;
            $mj = 0;
            $nn = 1;
            if(isset($controlAreaSettingArr[$k])){
                $isControlShow = $controlAreaSettingArr[$k]['is_control_show'];
                $timeControl = $controlAreaSettingArr[$k]['time_control'];
                $ddz = $controlAreaSettingArr[$k]['ddz'];
                $ysz = $controlAreaSettingArr[$k]['ysz'];
                $lhd = $controlAreaSettingArr[$k]['lhd'];
                $mj = $controlAreaSettingArr[$k]['mj'];
                $nn = $controlAreaSettingArr[$k]['nn'];
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

            $one = $controlAreaSettingModel->where(['control_area'=>$k,'app_id'=>$app_id,'status'=>1])->find();
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
                'control_area'=>$k,
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
                $save = (new CmsControlAreaSetting())->save($data,['control_area'=>$k,'app_id'=>$app_id]);
                if(!$save){
                    break;
                }else{
                    $num = $num+1;
                }
            }else{
                $save = (new CmsControlAreaSetting())->save($data);
                if(!$save){
                    break;
                }else{
                    $num = $num+1;
                }
            }
        }
        if($save){
            $controlAreaSettingModel->commit();

            $redis = Cache::store('redis');
            $redis->rm(Okey::rControlAreaSetting($app_id));

            $res = ['code'=>Code::SUCCESS,'msg'=>' 成功','data'=>['num'=>$num]];
        }else{
            $controlAreaSettingModel->rollback();
            $res = ['code'=>Code::CODE_ERR_PARAM,'msg'=>' 失败','data'=>[]];
        }
        return $res;
    }

}