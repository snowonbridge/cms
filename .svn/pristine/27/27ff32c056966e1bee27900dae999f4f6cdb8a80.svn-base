<?php

namespace app\admin\model;

use think\Model;

class UsergameLog extends Model
{
    // 表名
    protected $name = 'slog_usergame_log';
    protected $connection = 'database.db_config_slog';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'game_type_text',
        'gameid_text',
        'ttype_text',
        'currency_type_text',
        'win_type_text',
        'role_text',
        'is_owner_text',
        'play_time_text',
        'log_time_text'
    ];
    

    
    public function getGametypelist()
    {
        return ['48' => __('Game_type 48'),'47' => __('Game_type 47'),'46' => __('Game_type 46'),'45' => __('Game_type 45'),'43' => __('Game_type 43'),'42' => __('Game_type 42'),'41' => __('Game_type 41'),'40' => __('Game_type 40'),'39' => __('Game_type 39'),'38' => __('Game_type 38'),'37' => __('Game_type 37'),'36' => __('Game_type 36'),'35' => __('Game_type 35'),'32' => __('Game_type 32'),'31' => __('Game_type 31'),'30' => __('Game_type 30'),'29' => __('Game_type 29'),'28' => __('Game_type 28'),'26' => __('Game_type 26'),'25' => __('Game_type 25'),'21' => __('Game_type 21'),'20' => __('Game_type 20'),'19' => __('Game_type 19'),'16' => __('Game_type 16'),'15' => __('Game_type 15'),'14' => __('Game_type 14'),'13' => __('Game_type 13'),'12' => __('Game_type 12'),'11' => __('Game_type 11'),'0' => __('Game_type 0'),'10' => __('Game_type 10')];
    }     

    public function getTtypelist()
    {
        return ['0' => __('Ttype 0'),'3' => __('Ttype 3'),'2' => __('Ttype 2'),'1' => __('Ttype 1')];
    }     

    public function getCurrencytypelist()
    {
        return ['5' => __('Currency_type 5'),'4' => __('Currency_type 4'),'3' => __('Currency_type 3'),'2' => __('Currency_type 2'),'1' => __('Currency_type 1'),'0' => __('Currency_type 0')];
    }     

    public function getWintypelist()
    {
        return ['3' => __('Win_type 3'),'2' => __('Win_type 2'),'1' => __('Win_type 1'),'0' => __('Win_type 0')];
    }     

    public function getRolelist()
    {
        return ['4' => __('Role 4'),'3' => __('Role 3'),'2' => __('Role 2'),'0' => __('Role 0'),'1' => __('Role 1')];
    }     

    public function getIsownerlist()
    {
        return ['0' => __('Is_owner 0'),'1' => __('Is_owner 1')];
    }

    public function getGameidList()
    {
        return ['1001'=>__('Game_1001'),'1002'=>__('Game_1002'),'1003'=>__('Game_1003'),'1004'=>__('Game_1004'),'1005'=>__('Game_1005')];
    }


    public function getGametypeTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['game_type'];
        $list = $this->getGametypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }
    public function getGameidTextAttr($value, $data)
    {
        $value = $value ? $value : $data['gameid'];
        $list = $this->getGameidList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTtypeTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['ttype'];
        $list = $this->getTtypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCurrencytypeTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['currency_type'];
        $list = $this->getCurrencytypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getWintypeTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['win_type'];
        $list = $this->getWintypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getRoleTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['role'];
        $list = $this->getRoleList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getIsownerTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['is_owner'];
        $list = $this->getIsownerList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPlaytimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['play_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getLogtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['log_time'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setPlaytimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setLogtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
