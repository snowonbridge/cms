<?php

namespace app\admin\controller\monthcard;

use app\common\controller\Backend;

use fast\OutFile;
use fast\SendFile;
use think\Controller;
use think\Request;

/**
 * 月卡配置管理
 *
 * @icon fa fa-circle-o
 */
class Monthcardsetting extends Backend
{
    
    /**
     * MonthCardSetting模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('MonthCardSetting');
        $this->view->assign("statusList", $this->model->getStatuslist());
        $this->view->assign("ptypesList", $this->model->getPtypeslist());
    }





    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */



    /**
     * 发布
     */
    public function send()
    {
//        if ($ids)
//        {
        $list = $this->model->field('goodid,name,desc,status,diamond_price,roomcard_price,cash_price,ptypes,mday,day,card_image,total,ratio,order')->where('status','=','on')->select();
        $appenv = defined('APPENV')?  APPENV : 'product';
        $file = "cfg/".$appenv."/month_card.php";
        $all  = [];
        foreach($list as $each){
            $row = $each->getData();
            unset($row['status']);
            $all[$each['goodid']] =  $row ;
        }
        $outfile = new OutFile();
        $outfile->php($file, $all);
        $send = new SendFile();
        $send->file($file, '', false,config('send_url'));
        $this->success();
//        }
        $this->error(__('Parameter %s can not be empty', 'ids'));
    }
}
