<?php

namespace app\admin\model;

use think\Model;

class ItemsConfig extends Model
{
    // 表名
    protected $name = 'items_config';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'type_id_text',
        'tool_type_text',
        'usable_text',
        'show_text',
        'keeptime_text',
        'persitime_text'
    ];
    

    
    public function getTypeidlist()
    {
        return ['3' => __('Type_id 3'),'2' => __('Type_id 2'),'1' => __('Type_id 1')];
    }     

    public function getTooltypelist()
    {
        return ['4' => __('Tool_type 4'),'3' => __('Tool_type 3'),'2' => __('Tool_type 2'),'1' => __('Tool_type 1'),'0' => __('Tool_type 0')];
    }

    public function getUsablelist()
    {
        return ['0' => __('Usable 0'),'1' => __('Usable 1')];
    }

    public function getShowlist()
    {
        return ['0' => __('Show 0'),'1' => __('Show 1')];
    }
    public function getRewardlist()
    {
        return ['chip' => __('Tool chip'),'card' => __('Tool card'),'diamond' =>__('Tool diamond'),'prop' =>__('Tool prop'), 'bag' => __('Tool bag'), 'prestige' => __('Tool prestige'),];//礼包类型编号
    }



    public function getTypeidTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['type_id'];
        $list = $this->getTypeidList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTooltypeTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['tool_type'];
        $list = $this->getTooltypeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getUsableTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['usable'];
        $list = $this->getUsableList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getShowTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['show'];
        $list = $this->getShowList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getKeeptimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['keeptime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getPersitimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['persitime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setKeeptimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setPersitimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
