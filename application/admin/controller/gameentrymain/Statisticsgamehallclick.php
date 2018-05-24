<?php

namespace app\admin\controller\gameentrymain;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 
 *
 * @icon fa fa-circle-o
 */
class Statisticsgamehallclick extends Backend
{
    
    /**
     * StatisticsGameHallClick20182模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('StatisticsGameHallClick');

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


    /**
     * 查看
     */
    public function index()
    {
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('pkey_name'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();

            $partition_time = $_SERVER['REQUEST_TIME'];
            $filter = $this->request->get("filter", '');
            $filter = json_decode($filter, TRUE);
            $filter = $filter ? $filter : [];


            if(isset($filter['quarter']) && !empty($filter['quarter'])){

                list($year,$quarter) = explode(" ",$filter['quarter'],2);
                $jd_year = $year ? $year : date("Y",time());
                switch ($quarter) {
                    case 1:
                        $partition_time =  strtotime("$jd_year-02-01");
                        break;
                    case 2:
                        $partition_time =  strtotime("$jd_year-05-01");
                        break;
                    case 3:
                        $partition_time =  strtotime("$jd_year-08-01");
                        break;
                    case 4:
                        $partition_time =  strtotime("$jd_year-11-01");
                        break;
                }
            }

            $list = $this->model->get_list($where,$partition_time, $offset, $limit, '*', $sort,$order);
            $total = $this->model->get_total_count($where,$partition_time);

            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
    

}
