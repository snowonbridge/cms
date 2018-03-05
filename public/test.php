<?php
/**
 * Created by PhpStorm.
 * User: soulgame0089
 * Date: 2017/9/4
 * Time: 14:52
 */

// 加载框架引导文件

//just test
namespace think;

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// [ 应用入口文件 ]
// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

// 判断是否安装FastAdmin

// ThinkPHP 引导文件
// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';
$dbname = Config::get('database.database');
$prefix = Config::get('database.prefix');

//检查主表
$table = 'items_config';
$table = stripos($table, $prefix) === 0 ? substr($table, strlen($prefix)) : $table;
$modelTableName = $tableName = $table;
$modelTableType = 'table';
$tableInfo = Db::query("SHOW TABLE STATUS LIKE '{$tableName}'", [], TRUE);