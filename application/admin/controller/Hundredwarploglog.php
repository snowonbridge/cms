<?php

namespace app\admin\controller;

use app\common\controller\Backend;

use think\Controller;
use think\Request;

/**
 * 百人场server日志管理
 *
 * @icon fa fa-circle-o
 */
class Hundredwarploglog extends Backend
{

    /**
     * HundredWarPlogLog模型对象
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('HundredWarPlogLog');

    }

    /**
     * 编辑
     */
    public function edit($ids = NULL)
    {
        $row = $this->model->get($ids);
        if (!$row)
            $this->error(__('No Results were found'));
        $data = json_decode($row['data'], true);
        $data['start'] = date('Y-m-d H:i:s', $row['start']);

        foreach ($data['bet_info']['robot'] as $key => $robotBet) {
            $playerBet = $data['bet_info']['player'][$key];
            $data['bet_info']['ratio'][$key] = $robotBet / ($playerBet + $robotBet);
        }

        $data['last'] = [
            'reward'=>['robot' => 0, 'player' => 0, 'ratio' => 0,]
        ];
        $lastRow = $this->model->where('id', '<', $ids)->order('id desc')->find();
        if($lastRow && !empty($lastRow['data'])){
            $lastData = json_decode($row['data'], true);
            $data['last']['reward']['robot'] =$lastData['reward']['robot'];
            $data['last']['reward']['player'] =$lastData['reward']['player'];
            $data['last']['reward']['ratio'] =$lastData['reward']['robot'] / ($lastData['reward']['robot'] + $lastData['reward']['player']);
        }


        $data['reward']['ratio'] = $data['reward']['robot'] / ($data['reward']['robot'] + $data['reward']['player']);

        $openes = [1 => '是', 2 => '否']; //1为开彩，2为不开
        $data['reward']['open'] = $openes[$data['reward']['open']];
        $typees = [1 => '普通', 2 => '无押分', 3 => '押分', 4 => '为杀，不走彩']; //1为普通，2为无押分，3为押分，4为杀，不走彩
        $data['reward']['type'] = $typees[$data['reward']['type']];
        //"action":1	//1为随机，2为杀，3为放
        $stategies = [1 => '随机', 2 => '杀', 3 => '放'];

        $data['strategy']['action'] = $stategies[$data['strategy']['action']] ?: '';
        $positions = ['天门', '地门', '玄门', '黄门', '庄家'];
        $pokerTmp = $pokerRetTmp = '';
        $colors = [4 => '&#9824;', 3 => '&#9829;', 2 => '&#9827;', 1 => '&#9830;'];
        foreach ($data['poker']['poker'] as $pos => $handcard) {
            $pokerTmp .= $positions[$pos] . ':';
            foreach ($handcard as $key => $val) {
                $colorKey = $val % 10;
                $color = $colors[$val % 10];
                $number = floor($val / 10);
                $fontColor = in_array($colorKey,[1,3])?  'red' : 'black';
                $pokerTmp .= '<span style="color:'.$fontColor.'">' . $color . $number . '</span>';
            }
            $pokerTmp .= '&nbsp;&nbsp;&nbsp;&nbsp;';
        }

        $data['poker']['poker'] =  rtrim($pokerTmp,',');

        foreach ($data['poker']['ret'] as $pos => $r) {
            $pokerRetTmp .= $positions[$pos] . ':';
            $pokerRetTmp .= $r ? '庄赢' : '庄输';
            $pokerRetTmp .='&nbsp;&nbsp;&nbsp;&nbsp;';
        }

        $data['poker']['ret'] = rtrim($pokerRetTmp,',');

        $data['banker']['uid'];
        $bankers = ['系统' => [1000], '电脑' => [1001, 10000], '玩家' => [10000, PHP_INT_MAX]];
        foreach ($bankers as $key => $val) {
            $cnt = count($val);
            if ($cnt == 1) {
                if ($data['banker']['uid'] == $val[0]) {
                    $data['banker']['uid'] = $key;
                    break;
                }
            } else {
                if ($data['banker']['uid'] >= $val[0] && $data['banker']['uid'] <= $val[1]) {
                    $data['banker']['uid'] = 10000 < $data['banker']['uid'] ? $key . '-' . $data['banker']['uid'] : $key;
                    break;
                }
            }
        }

        $this->view->assign("row", $data);
        return $this->view->fetch();
    }

    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个方法
     * 因此在当前控制器中可不用编写增删改查的代码,如果需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */


}
