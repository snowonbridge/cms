<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use fast\Func;
use fast\OutFile;
use fast\SendFile;
use think\Controller;
use think\Request;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Robotchat extends Backend
{
    
    /**
     * RobotchatConfig模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('RobotchatConfig');

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 发布
     */
    public function send($ids = "")
    {
        if ($ids)
        {
            $list = $this->model->where('id', 'in', $ids)->field('no,quest,anser,keyword')->select();

            $ret = $merge = $rules= [];
            foreach($list as $item){
                $no =  (string)$item['no'];
                $each['quest'] =  (string)$item['quest'];
                $each['anser'] =  (string)$item['anser'];
                $keyword =  (string)$item['keyword'];
                $keywords = str_replace(["\n", "，", " "], ",", trim($keyword));
                $aKeywords = explode(',',$keywords);
                $aFill = array_fill_keys($aKeywords, $no);
                $merge = array_merge_recursive($merge,$aFill);
                $retList[$no]= $each;
            }
            if($merge){
                foreach($merge as $k => $v){
                    $rules["_".$k."_"] = (array)$v;
                    foreach($rules as $kk => $vv){
                        if(trim($kk,"_") != $k && Func::is_same_array($vv,(array)$v)){
                            $rules[$kk.","."_".$k."_"] = $vv;
                            unset($rules[$kk],$rules["_".$k."_"]);
                        }
                    }
                }
            }

            if( isset($retList) && !empty($rules)){
                $appenv = defined('APPENV')?  APPENV : 'product';
                $file = "cfg/".$appenv."/chat_bot.php";
                $ret['list'] = $retList;
                $ret['rule'] = $rules;
                $outfile = new OutFile();
                $outfile->php($file, $ret);
                $send = new SendFile();
                $send->file($file, '', false,config('send_url'));
                $this->success();
            }
        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
    

}
