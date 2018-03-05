<?php
/**
 * Created by PhpStorm.
 * User: soulgame0089
 * Date: 2017/9/6
 * Time: 11:38
 */
namespace fast;


use think\Request;
use think\Session;

class Func{

//统一取北京时间，使用格林威治标准时加8小时
    public static function date($s = '', $time = 0)
    {
        $time = ($time > 0 ? $time : time()) + 3600 * 8;
        return gmdate($s ? $s : 'Y-m-d H:i:s', $time);
    }


    public static function callback($ret = '', $ok = 0, $tiptype = '')
    {
        if ($ok === 'file') {
            $ret = '恭喜，发布成功【' . (is_array($ret) ? implode(',', $ret) : $ret) . '】，此文件直接生效！';
            $ok = 1;
        }
        if ($ret === true) {
            $ret = array();
            $ok = 1;
        } elseif ($ret === false) {
            $ret = array('msg' => 'error');
        } elseif (is_array($ret)) {
            $ok = 1;
        } else {
            $ret = array('msg' => $ret);
        }
        if (!isset($ret['num']) && isset($ret['loop']) && is_array($ret['loop'])) $ret['num'] = count($ret['loop']);//自动加上num数据总量count(loop)
        isset($ret['ok']) or $ret['ok'] = $ok;
        isset($ret['num']) && $ret['num'] = (int)$ret['num'];
        $tiptype && ($ret['tiptype'] = $tiptype);
        if (isset($ret['tiptype']) && $ret['tiptype']) $ret['tiptype'] = ($ret['tiptype'] === true ? 'Alert/Err' : $ret['tiptype']);
        self::ret($ret);
    }

    public static function ret($ret)
    {
        header('Content-type:application/x-javascript;charset=utf-8');
        header('Cache-Control:no-cache');
        if (defined('ORG_JSON')) {//使用普通的json格式，有些特殊字符要兼容。
            $ret = json_encode($ret);
        } else {
            $ret = self::json($ret);
        }
        $cb = isset($_GET['callback']) && $_GET['callback'] ? htmlspecialchars(addslashes($_GET['callback'])) : 0;
        if ($cb) {
            echo($cb . '(' . $ret . ')');
        } else {
            echo($ret);
        }
        self::fastcgi('exec');
        die();
    }

//通过unicode解码输出JSON，可以减小字符大小
    public static function json($s)
    {
        return json_encode($s, JSON_UNESCAPED_UNICODE);//PHP5.4以上版本支持
    }

    public static $fastcgi = array();

    public static function fastcgi()
    {
        $p = func_get_args();
        if ($p[0] === 'exec') {
            function_exists('fastcgi_finish_request') && fastcgi_finish_request(); //快速返回给客户端
            if (!self::$fastcgi) return 'nothing';
            $temp = self::$fastcgi;
            self::$fastcgi = array();//防止死循环
            $ret = array();
            foreach ($temp as $args) {
                $fn = array_shift($args);
                $p = $arg = array();
                if ($args) {
                    foreach ($args as $k => $v) {
                        $arg[$k] = $v;
                        $p[] = '$arg[' . $k . ']';
                    }
                }
                $fun = $fn . '(' . implode(',', $p) . ');';
                $ret[$fn]['fun'] = $fun;
                $ret[$fn]['arg'] = $arg;
                $php = '$ret[$fn]["ret"]=' . $fun;
                eval($php);
                self::log($ret[$fn], 'fastcgi');
            }
            return $ret;
        } else {
            self::$fastcgi[] = $p;
            return true;
        }
    }

//操作日志
    public static function log($msg, $path = '', $out = false)
    {

        $admin = Session::get('admin');
        $uid = $admin ? $admin->id : 0;
        $username = $admin ? $admin->username : __('Unknown');
        $path = $path ? $path . '/' : '';
        self::wlog($msg, $uid, LOG_PATH . self::date('Ym') . '/' . $path, $out);
    }

    private static function wlog($msg, $uid, $path, $out)
    {//cms、cmsapi通用
        if (is_array($msg)) $msg = self::json($msg);
        $log = sprintf('[%s] [UID:%s]  [%s] %s', self::date('m-d H:i:s'), $uid, request()->ip(), $msg);
        $date = self::date('Y-m-d');
        $file = $path . $date . '.php';
        $path = dirname($file);
        if (!is_dir($path)) mkdir($path, 0777, true);
        if (!is_file($file)) $log = "<?php (isset(\$_GET['p']) && (md5('&%$#'.\$_GET['p'].'**^')==='86d62a6f209c5e30eaa8290b7d239856')) or die();?>\n" . $log;
        file_put_contents($file, $log . "\n", FILE_APPEND);
        if ($out) {
            echo '<pre><b>Log</b>:' . $log;
            throw new Exception($msg);
        }
    }


    /**
     * 根据magic_quote判断是否为变量添加斜杠
     * @param mix $mixVar
     * @return mix
     */
    public static function magic_quote($mixVar)
    {
        if (!get_magic_quotes_gpc()) {
            if (is_array($mixVar)) {
                foreach ($mixVar as $key => $value) {
                    $temp[$key] = self::magic_quote($value);
                }
            } else {
                $temp = addslashes($mixVar);
            }
            return $temp;
        } else {
            return $mixVar;
        }
    }

    public static function rsync_key($type = '', $p1 = '', $p2 = 0)
    {

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //cms系统安全码
        //xxx::rsync_key('get', array('a'=>'aaa','b'=>'bbb'));//获取安全码数组
        //xxx::rsync_key('url', array('a'=>'aaa','b'=>'bbb'));//获得安全码URL串
        //xxx::rsync_key();//检测安全码
        switch ($type) {
            case 'get'://$p1是array(data)，$p2是自定义时间戳
                $data = $p1;
                $time = $p2 ? $p2 : time();
                if (is_array($data)) {
                    krsort($data);
                    $field = join(',', array_keys($data));
                } else {
                    $data = array();
                    $field = '';
                }

                $val = $time . serialize(self::key_data($data));
                $sig = md5(md5('*req%'.$val.'*bla#bla^').$val.'#');
                $ret = array('req_key' => $sig, 'req_time' => $time, 'req_field' => $field);
                if (isset($_GET['debug']) && $_GET['debug']) $ret['debug'] = $val;
                return $ret;
                break;
            case 'url'://参数同get
                $data = is_array($p1) ? $p1 : array();
                $ret = self::rsync_key('get', $data, $p2);
                return http_build_query($ret);
                break;
            default://$type是有效时间(s)，$p1、$p2无用
                $t = max((int)$type, 180);
                $req_time = (int)$_REQUEST['req_time'];
                (time() - $req_time > $t) && self::callback('Safe key timeout!');//默认3分钟
                $data = array();
                if ($field = $_REQUEST['req_field']) {
                    $field = explode(',', $field);
                    foreach ($field as $f) {
                        $data[$f] = self::magic_quote($_REQUEST[$f]);
                    }
                }
                $ret = self::rsync_key('get', $data, $req_time);
                ($ret['req_key'] !== $_REQUEST['req_key']) && self::callback('Safe key error!');
                break;
        }
    }
    private static function key_data($data){
        if(!is_array($data)) return trim($data);
        foreach($data as $k => $v){
            $data[$k] = self::key_data($v);
        }
        return $data;
    }


    //调试输出日志
    public static function ob_log(){
        $args = func_get_args();
        switch ($args[0]){
            case 'init':
                ob_start();
                var_dump($args);
                break;
            case 'out':
                $s = ob_get_clean()."\n";
                file_put_contents(LOG_PATH. $args[1], $s, FILE_APPEND);
                echo $s;
                break;
            default:
                var_dump($args);
        }
    }


    static public function gameApiRequest(Request $request,$action='',$extra_post= [])
    {
        if (is_null($request)) {
            $request = Request::instance();
        }
        $sGet = http_build_query($request->param(false));
        $url = config('cms_gate_url');
        $admin = Session::get('admin');
        $uid = $admin ? $admin->id : 0;
        $username = $admin ? $admin->username : __('Unknown');
        $post = array_merge(['adminId'=>$uid,'adminNmae'=>$username],$request->post("row/a",[]));
        $extra_post && $post = array_merge($post,$extra_post);
        parse_str(http_build_query($post),$output);//解决为空数组的bug
        $post = $output;
        $req_key = Func::rsync_key('url',$post);
        $sGet = implode('&',array_filter([$sGet,$req_key,'do='.$action]));
        $ret = Http::sendRequest($url.'?'.$sGet,$post);
        return  $ret;
    }

    static public function sendFile($file,$content)
    {
        $outfile = new OutFile();
        $outfile->php($file, $content);
        $send = new SendFile();
        return $send->file($file, '', false,config('send_url'));
    }


    static public function is_same_array($a,$b){
        return ( count( $a ) == count( $b ) && !array_diff( $a , $b ) ? true : false );
    }
}