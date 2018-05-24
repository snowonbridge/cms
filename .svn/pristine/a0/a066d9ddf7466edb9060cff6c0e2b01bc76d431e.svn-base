<?php
/**
 * Created by PhpStorm.
 * User: soulgame0089
 * Date: 2018/5/11
 * Time: 9:36
 */
namespace app\admin\model\Traits;

use think\Config;

trait PartitionsByQuarter{
    /**
     * 按月分表
     * @param string $search_time
     * @param int $month_num
     */
    protected  $partiRule=null;
    protected  $parti_info=null;
    protected  $parti_info_field=null;
    protected function get_month_submeter($search_time = '', $month_num = 3) {
        //分表规则
        $this->partiRule = [
            'type' => 'quarter', // 分表方式,按月分表
            'expr' => $month_num     // 按3月（1个季度）一张表分
        ];
        //分表数据
        $this->parti_info = [
            'now_time' => $search_time? $search_time : $_SERVER['REQUEST_TIME']
        ];
        $this->parti_info_field = 'now_time';
    }


    public function get_match_by_time($map,$partition_time, $field = '*'){
        $this->get_month_submeter($partition_time);
        return $this->partition($this->parti_info,$this->parti_info_field,$this->partiRule)->where($map)->field($field)->find();

    }


    /**
     * 分页数据
     * @param $map
     * @param $partition_time
     * @param int $offset
     * @param int $limit
     * @param string $field
     * @param $sort
     * @param $order
     * @return array
     */
    public function get_list($map,$partition_time, $offset = 1, $limit = 20, $field = '*', $sort,$order) {
        if(!$this->checkTableExists($partition_time)){
            return [];
        }
        $this->get_month_submeter($partition_time);
        $list = $this->partition($this->parti_info,$this->parti_info_field,$this->partiRule)->where($map)->field($field)->order($sort,$order)->limit($offset,$limit)->select();
        return $list ? $list : [];
    }


    /**
     * @param array $map
     * @param $partition_time
     * @return int
     */
    public function get_total_count($map = [],$partition_time){
        if(!$this->checkTableExists($partition_time)){
            return 0;
        }
        $this->get_month_submeter($partition_time);
        $resutl  = 	$this->partition($this->parti_info,$this->parti_info_field,$this->partiRule)
            ->where($map)
            ->count();
        return $resutl;

    }

    /**
     * 多条数据集
     * @param $map
     * @param $partition_time
     * @param string $field
     * @param string $order
     * @return array
     */
    public function get_data_list($map,$partition_time, $field = '*', $order = '') {
        $this->get_month_submeter($partition_time);
        $table2 = get_table_seq($partition_time)-1;
        $table_name2 = get_partition_sql_name($this->getTable(),$table2 ,$partition_time);

        $sql2    = $this->table($table_name2)->where($map)->field($field)->fetchSql(true)->select();

        $sql1  = 	$this->partition($this->parti_info,$this->parti_info_field,$this->partiRule)
            ->field($field)
            ->where($map)
            ->fetchSql()
            ->select();

        $sqlall = "( {$sql1} ) UNION ( {$sql2} ) ";

        $list =  $this->query($sqlall);

        if ($list) {
            //返回数组
            return get_array_to_object($list);
        }
        return [];
    }

    /**
     * 更新数据
     * @param array $map
     * @param string $partition_time
     * @param $param
     * @return
     */
    public function update_match_data($map = [],$partition_time='', &$param) {
        $this->get_month_submeter($partition_time);
        return $this->partition($this->parti_info,$this->parti_info_field,$this->partiRule)->where($map)->update($param);
    }

    /**
     * 添加
     * @param $param
     * @return
     */
    public function insert_data(&$param) {
        return $this->partition($this->parti_info,$this->parti_info_field,$this->partiRule)->insert($param);
    }


    /**
     * @param $map
     * @param $partition_time
     * @param int $page
     * @param int $limit
     * @param string $field
     * @param string $order
     * @return mixed
     */
    public function get_new_overtime_order_list($map, $partition_time, $page = 0, $limit = 20, $field = '*', $order = 'pstime desc'){
        $this->get_month_submeter($partition_time);
        $sql  = 	$this->partition($this->parti_info,$this->parti_info_field,$this->partiRule)
            ->field($field)
            ->where($map)
            ->fetchSql()
            ->select();
        $sql .= $this->order($order);
        $sql .= $this->limit($page, $limit);
        $list =  $this->query($sql);
        return $list;
    }

    /**
     * @param $partition_time
     * @return bool
     */
    public function checkTableExists($partition_time){
        $dbconfig= Config::get($this->connection);
        if(!isset($dbconfig['database'])){
            return false;
        }
        $db = $dbconfig['database'];
        $this->get_month_submeter($partition_time);
        $table = $this->getPartitionTableName($this->parti_info,$this->parti_info_field,$this->partiRule);
        $sql = "SELECT * FROM information_schema.tables WHERE table_schema = '{$db}' AND table_name = '{$table}' LIMIT 1;";
        return $this->query($sql);
    }
}
