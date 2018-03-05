<?php
namespace app\admin\model;

use think\Model;

class PokerUser extends Model
{
    protected $connection = 'db_config_poker';

    //登录方式，1游客，2手机，3微信，4QQ
    const USER_TYPE_QUICK = 1 ;
    const USER_TYPE_MOBILE = 2 ;
    const USER_TYPE_WX = 3 ;
    const USER_TYPE_QQ = 4 ;

    //用户状态
    const STATUS_ON = 0 ;//正常

    //头像类型
    const AVARTAR_TYPE_URL = 1;//第三方
    const AVARTAR_TYPE_LOCAL = 2;//本地

    // 追加属性
    protected $append = [
        'avartar_url',
    ];

    public function getAvartarUrlAttr($value, $data)
    {
        $value = $value ? $value : $data['avartar'];
        if($data['avartar_type']==self::AVARTAR_TYPE_URL){
            $url = $value;
        }else{
            $num = sprintf('%02s', $value);
            $url = "/common/img/head/pic_head{$num}.png";
        }
        return $url;
    }

    public function getUserByUnionid($union_id)
    {
        return $this->where(['openid' => $union_id, 'usertype' => self::USER_TYPE_WX])->find();

    }

    public function getUserById($id)
    {
        return $this->where(['id' => $id,'ustatus'=>self::STATUS_ON])->find();
    }
}