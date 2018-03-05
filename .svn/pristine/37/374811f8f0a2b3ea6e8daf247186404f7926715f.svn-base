<?php

namespace app\admin\model;

use think\Model;

class SysnoticeConfig extends Model
{
    // 表名
    protected $name = 'sysnotice_config';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';
    // 定义时间戳字段名
    protected $createTime = 'ctime';
    protected $updateTime = '';
    
    // 追加属性
    protected $append = [
        'tab_text',
        'type_id_text',
        'ctime_text'
    ];
    

    
    public function getTablist()
    {
        return ['2' => __('Tab 2'),'1' => __('Tab 1'),'0' => __('Tab 0')];
    }     

    public function getTypeidlist()
    {
        return ['2' => __('Type_id 2'),'1' => __('Type_id 1')];
    }     


    public function getTabTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['tab'];
        $list = $this->getTabList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getTypeidTextAttr($value, $data)
    {        
        $value = $value ? $value : $data['type_id'];
        $list = $this->getTypeidList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getCtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['ctime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setCtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
