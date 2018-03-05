<?php

namespace app\admin\controller\agent;

use app\common\controller\Backend;

use think\Controller;
use think\Exception;
use think\Request;
use think\Session;

class Base extends Backend
{

    public $admin = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->admin = Session::get('admin');

        //todo 将管理员可操作的游戏平台id加入admin session
    }
    

}
