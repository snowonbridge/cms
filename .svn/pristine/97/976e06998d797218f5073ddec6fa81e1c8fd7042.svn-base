<?php

namespace app\admin\model;

use think\Config;
use think\Model;

class Order extends Model
{
    // 表名
    protected $name = 'poker_order';
    protected $connection = 'database.db_config1';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    
    // 追加属性
    protected $append = [
        'pstime_text',
        'petime_text'
    ];


    protected $rule = [];
    protected $info = [];
    protected $info_field = '';

    protected function initialize() {
        $this->get_month_submeter();

    }


    public function getPstimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['pstime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getPetimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['petime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setPstimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setPetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }



    /**
     * 按月分表
     * @param type $month_num
     */
    protected function get_month_submeter($search_time = '', $month_num = 3) {
        //分表规则
        $this->rule = [
            'type' => 'quarter', // 分表方式,按月分表
            'expr' => $month_num     // 按3月一张表分
        ];
        //分表数据
        $this->info = [
            'now_time' => $search_time? $search_time : $_SERVER['REQUEST_TIME']
        ];
        $this->info_field = 'now_time';
    }


    public function get_match_by_time($map,$partition_time, $field = '*'){
        $this->get_month_submeter($partition_time);
        return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->find();

    }


    /**
     * 分页数据
     * @param type $map
     * @param type $page
     * @param type $r
     * @param type $field
     * @param type $order
     * @return type
     */
    public function get_list($map,$partition_time, $offset = 1, $limit = 20, $field = '*', $sort,$order) {
        if(!$this->checkTableExists($partition_time)){
            return [];
        }
        $this->get_month_submeter($partition_time);
        $sql = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->order($sort,$order)->limit($offset,$limit)->fetchSql(true)->select();
        $list = $this->partition($this->info,$this->info_field,$this->rule)->where($map)->field($field)->order($sort,$order)->limit($offset,$limit)->select();
        return $list ? $list : [];
    }

    public function get_total_count($map = [],$partition_time){
        if(!$this->checkTableExists($partition_time)){
            return 0;
        }
        $this->get_month_submeter($partition_time);
        $resutl  = 	$this->partition($this->info,$this->info_field,$this->rule)
            ->where($map)
            ->count();
        return $resutl;

    }

    /**
     * 多条数据集
     * @param type $map
     * @param type $partition_time
     * @param type $field
     * @param type $order
     * @return type
     */
    public function get_data_list($map,$partition_time, $field = '*', $order = '') {
        $this->get_month_submeter($partition_time);
        $table2 = get_table_seq($partition_time)-1;
        $table_name2 = get_partition_sql_name($this->getTable(),$table2 ,$partition_time);

        $sql2    = $this::table($table_name2)->where($map)->field($field)->fetchSql(true)->select();

        $sql1  = 	$this->partition($this->info,$this->info_field,$this->rule)
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
     * @param type $map
     * @param type $param
     * @return type
     */
    public function update_match_data($map = [],$partition_time='', &$param) {
        $this->get_month_submeter($partition_time);
        return $this->partition($this->info,$this->info_field,$this->rule)->where($map)->update($param);
    }

    /**
     * 添加
     * @param type $param
     * @return type
     */
    public function insert_data(&$param) {
        return $this->partition($this->info,$this->info_field,$this->rule)->insert($param);
    }


    public function get_new_overtime_order_list($map,$partition_time, $page = 0, $limit = 20, $field = '*', $order = 'pstime desc'){
        $this->get_month_submeter($partition_time);
        $sql  = 	$this->partition($this->info,$this->info_field,$this->rule)
            ->field($field)
            ->where($map)
            ->fetchSql()
            ->select();
        $sql .= $this->order($order);
        $sql .= $this->limit($page, $limit);
        $list =  $this->query($sql);
        return $list;
    }

    public function checkTableExists($partition_time){
        $dbconfig= Config::get($this->connection);
        if(!isset($dbconfig['database'])){
            return false;
        }
        $db = $dbconfig['database'];
        $this->get_month_submeter($partition_time);
        $table = $this->getPartitionTableName($this->info,$this->info_field,$this->rule);
        $sql = "SELECT * FROM information_schema.tables WHERE table_schema = '{$db}' AND table_name = '{$table}' LIMIT 1;";
        return $this->query($sql);
    }



}
