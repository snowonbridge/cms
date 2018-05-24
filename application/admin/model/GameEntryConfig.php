<?php

namespace app\admin\model;

use think\Config;
use think\Model;

class GameEntryConfig extends Model
{
    // 表名
    protected $connection = 'database.db_config1';
    protected $name = 'poker_game_entry_config';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'status_text',
        'game_cate_text',
        'game_level_text',
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $row->save(['weigh' => $row['id']]);
        });
    }

    
    public function getStatuslist()
    {
        return ['on' => __('On'),'off' => __('Off')];
    }
    public function getSetCardSwitch()
    {
        return ['yes' => __('Yes'),'no' => __('No')];
    }
    public function getRobotSwitch()
    {
        return ['yes' => __('Yes'),'no' => __('No')];
    }


    public function getGameidsList()
    {
        //游戏ID[1001=>'炸金花',1002=>'龙虎斗',1003=>'牛牛',1004=>'斗地主',10005=>'麻将']; 示例:{...,"param":
        return Config::get('gameCategory');
    }

    public function getTabletypesList()
    {
        return [ '1' => __('tabletypes_1'), '2' => __('tabletypes_2'), '3' => __('tabletypes_3')];
    }


    public function getStatusTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getGameCateTextAttr($value, $data)
    {
        $value = $value ? $value : $data['game_cate'];
        $list = $this->getGameidsList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getGameLevelTextAttr($value, $data)
    {
        $value = $value ? $value : $data['game_level'];
        $list = $this->getTabletypesList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
