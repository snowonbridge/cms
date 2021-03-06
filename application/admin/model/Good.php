<?php

namespace app\admin\model;

use think\Config;
use think\Model;

class Good extends Model
{
    // 表名
    protected $name = 'poker_goods';
    protected $connection = 'database.db_config1';

    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;

    // 追加属性
    protected $append = [
        'category_text',
        'ptype_text',
        'status_text',
        'isfast_text',
        'inroom_text',
    ];


    public function getInroomList()
    {
        return [
            '1' => __('Yes'),
            '0' => __('No'),
        ];
    }

    public function getCategoryList()
    {
        return [
            '1' => __('Ptype_id 1'),
            '2' => __('Ptype_id 2'),
            '3' => __('Ptype_id 3'),
            '4' => __('Ptype_id 4'),
            '5' => __('Ptype_id 5'),
            '6' => __('Ptype_id 6'),
            '7' => __('首充礼包'),
        ];
    }


    public function getStatusList()
    {
        return [
            'on' => __('On'),
            'off' => __('Off'),
        ];
    }


    public function getIsfastList()
    {
        return [
            'yes' => __('Yes'),
            'no' => __('No'),
        ];
    }

    public function getTableTypesList()
    {
        return [
            '0' => __('tabletypes_0'),
            '1' => __('tabletypes_1'),
            '2' => __('tabletypes_2'),
            '3' => __('tabletypes_3'),
            '4' => __('tabletypes_4'),
        ];
    }


    public function getCategoryTextAttr($value, $data)
    {
        $value = $value ? $value : $data['category'];
        $list = $this->getCategoryList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getPtypeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['ptype'];
        $list = $this->getCategoryList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : $data['status'];
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }
    public function getIsfastTextAttr($value, $data)
    {
        $value = $value ? $value : $data['isfast'];
        $list = $this->getIsfastList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getTabletypesTextAttr($value, $data)
    {
        $value = $value ? $value : $data['tabletypes'];
        $list = $this->getTableTypesList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    public function getInroomTextAttr($value, $data)
    {
        $value = $value ? $value : $data['inroom'];
        $list = $this->getInroomList();
        return isset($list[$value]) ? $list[$value] : '';
    }

}
