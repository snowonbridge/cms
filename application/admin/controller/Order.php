<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use fast\Func;
use think\Controller;
use think\Log;
use think\Request;

/**
 * 订单管理
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{
    /** @var  \app\admin\model\Order */
    protected $model = null;
    protected $searchFields = 'pid';
    protected $filterSearch = ['quarter','year'];

    public function _initialize()
    {
        parent::_initialize();

        $this->model = model('Order');

    }

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

    public function sendorder()
    {
        if ($this->request->isAjax()) {
            $pid = $this->request->request('ids');
            if (!$pid) {
                $this->error(__('No Results were found'));
            }
            /*$state = $this->sdkPayStatus($pid);
            if (!$state[0]) {
                $this->error($state[1]);
            }*/
            $ret = Func::gameApiRequest($this->request, 'sendGood', ['pid' => $pid]);
            if ($ret['ret'] == 1) {
                $reqBack = json_decode($ret['msg'], TRUE);
            }
            if (!$reqBack['code']){
                $this->error($reqBack['msg']);
            }
            $this->success('发货成功');
        }
        $this->error(__('No Results were found'));
    }

    // 判断订单是否扣费了 文档地址: http://showdoc.soulgame.mobi/index.php?s=/9&page_id=263
    private function sdkPayStatus($pid)
    {
        $ch = curl_init("http://uc.soulgame.mobi/smspay/zjh/ordercheck?order_id={$pid}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($ch);
        $error_no = curl_errno($ch);
        $error_msg = curl_error($ch);
        curl_close($ch);
        if ($error_no != 0) {
            return [false, $error_msg];
        }
        $responseArr = json_decode($response, true);
        if ($responseArr['code'] != 2000) {
            return [false, $responseArr['msg']];
        }
        return [true, ""];
    }
}
