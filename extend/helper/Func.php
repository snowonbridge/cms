<?php

namespace helper;

/**
 * 公共函数操作类
 */
class Func {

    /**
     * 组合数组成为一个字符串,数据组合方式为 array( a => '1', b => 'xxx' ); 转换成字符串 "|a:1||b:xxx|";
     * @param array $param 要组合的数组
     * @return string 组合后的字符串
     */
    static function join($param) {
        $str = '';
        foreach ($param as $k => $v) {
            $str .= "|$k:$v|";
        }
        return $str;
    }

    /**
     * 检查一个数组的签名的正确与否
     * @param array $param 要检查签名的数组
     * @param string $sign 当前的签名的结果
     * @param string $secret 加密用的私钥
     * @return bool
     */
    static function checksign($param, $sign, $secret) {
        if (empty($param) || !$sign || !$secret) {
            return false;
        }
        ksort($param);
        $str = Func::join($param);
        if (strcmp($sign, sha1($secret . $str)) === 0) { //签名正确
            return true;
        }
        return false;
    }

    /**
     * 生成一个数组的签名值
     * @param array $param 要签名的数组,注意此时不要放sign进来
     * @param string $secret 加密用的私钥
     * @return string 签名的结果
     */
    static function gensign($param, $secret) {
        if (empty($param) || !$secret) {
            return '';
        }
        ksort($param);
        $str = Func::join($param);
        return sha1($secret . $str);
    }



    //对PHP数组（类似MYSQL查出来的数据）进行排序，用法：Func::arr_sort($data, array('id','asc','num'), array('val','desc','num'));
    public static function arr_sort(){
        $p = func_get_args();
        $data = $p[0];
        if(!$data || !is_array($data)) return $data;
        unset($p[0]);
        if(!$p) return $data;
        $aTemp = array();
        foreach($data as $k => $rs){
            $aTemp['__key'][] = $k;
            foreach($p as $v){
                $aTemp[$v[0]][] = $rs[$v[0]];
            }
        }
        foreach($p as $v){
            $sc = $v[1] == 'desc' ? SORT_DESC : SORT_ASC;
            if($v[2] == 'num'){
                $tp = SORT_NUMERIC;
            }else if($v[2] == 'str'){
                $tp = SORT_STRING;
            }else{//保持原样
                $tp = SORT_REGULAR;
            }
            $par[] = &$aTemp[$v[0]];
            $par[] = $sc;
            $par[] = $tp;
        }
        $par[] = &$aTemp['__key'];
        call_user_func_array('array_multisort', $par);
        $ret = array();
        foreach($aTemp['__key'] as $i => $k){
            $ret[$k] = $data[$k];
        }
        return $ret;
    }


    /*
     * array unique_rand( int $min, int $max, int $num )
     * 生成一定数量的不重复随机数
     * $min 和 $max: 指定随机数的范围
     * $num: 指定生成数量
     */

    function unique_rand($min, $max, $num) {
        $count = 0;
        $return = array();
        while ($count < $num) {
            $return[] = mt_rand($min, $max);
            $return = array_flip(array_flip($return));
            $count = count($return);
        }
        shuffle($return);
        return $return;
    }

    //获取浏览器信息
    public function getUserBrowser() {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        if (empty($browser)) {
            return 'Unknow';
        }
        if (false !== strpos($browser, 'Chrome')) {
            return 'Chrome';
        }
        if (false !== strpos($browser, '360SE')) {
            return '360SE';
        }
        if (false !== strpos($browser, '360Chrome')) {
            return '360Chrome';
        }
        if (false !== strpos($browser, 'QQBrowser')) {
            return 'QQ';
        }
        if (false !== strpos($browser, 'LBBROWSER')) {
            return 'Liebao';
        }
        if (false !== strpos($browser, 'Maxthon')) {
            return 'AoYou';
        }
        if (false !== strpos($browser, '2345Explorer')) {
            return '2345Explorer';
        }
        if (false !== strpos($browser, 'UBrowser')) {
            return 'UC';
        }
        if (false !== strpos($browser, 'JuziBrowser')) {
            return 'Juzi';
        }
        if (false !== strpos($browser, 'Firefox')) {
            return 'Firefox';
        }
        if (false !== strpos($browser, 'BIDUBrowser')) {
            return 'Baidu';
        }
        if (false !== strpos($browser, 'MSIE 9.0')) {
            return 'Internet Explorer 9.0';
        }
        if (false !== strpos($browser, 'MSIE 8.0')) {
            return 'Internet Explorer 8.0';
        }
        if (false !== strpos($browser, 'MSIE 7.0')) {
            return 'Internet Explorer 7.0';
        }
        if (false !== strpos($browser, 'MSIE 6.0')) {
            return 'Internet Explorer 6.0';
        }
        if (false !== strpos($browser, 'Safari')) {
            return 'Safari';
        }
        if (false !== strpos($browser, 'Opera')) {
            return 'Opera';
        }
    }

    public static function safeBase64Encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);

        return $data;
    }

    public static function safeBase64Decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    /**
     * 加密
     * @param String $string 需要加密的字串
     * @author Soul <13798215432@126.com>
     * @date 2015-06-06 0:14
     * @return String
     */
    public function aesEncode($value, $secret = '') {
        if (!$value) {
            return false;
        }
        $text = http_build_query($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $secret, $text, MCRYPT_MODE_ECB, $iv);
        return trim(self::safeBase64Encode($crypttext));
    }

    /**
     * 解密
     * @param String $string 需要解密的字串
     * @author Soul <13798215432@126.com>
     * @date 2015-06-06 0:14
     * @return String
     */
    public static function aesDecode($value, $secret = '') {
        if (!$value) {
            return false;
        }
        $crypttext = self::safeBase64Decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $secret, $crypttext, MCRYPT_MODE_ECB, $iv);
        parse_str(trim($decrypttext), $ret);
        return $ret;
    }

    /**
     * 加密
     * @param String $string 需要加密的字串
     * @author Soul <13798215432@126.com>
     * @date 2015-06-06 0:14
     * @return String
     */
    public function stringEncode($param, $encodeKey = '') {
        $strArr = str_split(base64_encode(http_build_query($param)));
        $strCount = count($strArr);
        foreach (str_split($encodeKey) as $key => $value) {
            $key < $strCount && $strArr[$key].=$value;
        }
        return str_replace(array('=', '+', '/'), array('o000o', 'o0o0o', 'oo00o'), join('', $strArr));
    }

    /**
     * 解密
     * @param String $string 需要解密的字串
     * @author Soul <13798215432@126.com>
     * @date 2015-06-06 0:14
     * @return String
     */
    public function stringDecode($string = '', $encodeKey = '') {
        $req = array();
        $strArr = str_split(str_replace(array('o000o', 'o0o0o', 'oo00o'), array('=', '+', '/'), $string), 2);
        $strCount = count($strArr);
        foreach (str_split($encodeKey) as $key => $value) {
            $key <= $strCount && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
        }
        parse_str(base64_decode(join('', $strArr)), $req);
        return $req;
    }


    /**
     * 验证手机号是否正确
     * @param INT $mobile
     */
    public static function isMobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }

    /**
     * 验证码是否正确
     * @param INT $input
     * @param int $range
     * @return bool
     */
    public static function isNumber($input,$range = 6) {
        if (!is_numeric($input)) {
            return false;
        }
        return preg_match('#^[\d]{'.$range.'}$#', $input) ? true : false;
    }

    /**
     * 隐藏手机号
     * @param string $phone
     * @return <string>
     */
    public function hidTelNum($phone) {
        $IsWhat = preg_match('/(0[0-9]{2,3}[-]?[2-9][0-9]{6,7}[-]?[0-9]?)/i', $phone); //固定电话
        if ($IsWhat == 1) {
            return preg_replace('/(0[0-9]{2,3}[-]?[2-9])[0-9]{3,4}([0-9]{3}[-]?[0-9]?)/i', '$1****$2', $phone);
        } else {
            return preg_replace('/(1[34578]{1}[0-9])[0-9]{4}([0-9]{4})/i', '$1****$2', $phone);
        }
    }
    /**
     * 隐藏身份证号
     * @param string $idCard 身份证号
     * @param int $start 开始
     * @param int $lenth 长度
     * @param int $limit 标记长度
     * @param string $mark 标记符号
     * @return string
     */
    public function hidIdCard($idCard, $start = 6, $lenth = 7, $limit = 6, $mark = '*'){
        return substr_replace("$idCard",str_repeat($mark,$limit), $start, $lenth);
    }

    public static function HttpsPost($url,$data)
    {
        $ch = curl_init();
        // 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);  // 对证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1);  // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  // 使用自动跳转
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);   // 自动设置Referer
        curl_setopt($ch, CURLOPT_POST, 1);    // 发送一个 常规的Post请求
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  // Post提交的数据包
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);    // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_HEADER, 0);    // 显示返回的Header区域内容
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //获取的信息以文件流的形式返回

        $output = curl_exec($ch); // 执行操作
        if(curl_errno($ch))
        {
            echo "Errno".curl_error($ch);   // 捕抓异常
        }
        curl_close($ch);  // 关闭CURL
        return $output;
    }

    //以post方式发送json格式的请求
    static private function http_post_json($url, $jsonStr) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //去掉后，会一直返回false
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json; charset=utf-8',
                'Content-Length: ' . strlen($jsonStr)
            )
        );
        $response = curl_exec($ch);
//  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $response;
    }

    //调用腾讯短信接口
    public static function sendSms($phone,$msg) {
        strlen($msg) > 450 && $msg = substr($msg, 0, 450); //内容超过500会发送失败
        //$msg = iconv("UTF-8", "GBK",'【腾讯云】'. $msg); //【灵游互动】为签名标识必须加上
        $config = config()->get('config');
        $sig = md5($config['sms']['key'] . $phone);
        $random = rand(10000, 90000);
        $url = 'https://yun.tim.qq.com/v3/tlssmssvr/sendsms?sdkappid=' . $config['sms']['id'] . '&random=' . $random;
        $data = array('tel' => array('nationcode' => '86', 'phone' => "$phone"),
            'type' => '0',
            'msg' => $msg,
            'sig' => $sig,
            'extend' => '',
            'ext' => ''
        );
        $data = json_encode($data);
        $data = self::http_post_json($url, $data);
        $ret = 0;
        if(!empty($data)){
            if(stripos($data, 'OK')){
                $ret = 1;
            }
        }
        return $ret;
    }


    //类似yii2 ArrayHelper::array_index()函数
    public static function array_index($array,$key){
        $result = [];
        foreach ($array as $element) {
            if (is_object($element)) {
                $value = $element->$key;
            } elseif (is_array($element)) {
                $value = array_key_exists($key, $element) ? $element[$key] : null;
            } else {
                $value = null;
            }
            $result[$value] = $element;
        }
        return $result;
    }

    /**
     * 返回两个时间戳的相差天数
     * @param int $time1
     * @param int $time2
     * @param string $type day忽略当天的时分秒，time计算时分秒
     * @return mixed
     */
   public static  function getDaysByDateDiff($time1,$time2,$type='day'){
        if($type =='day'){
            $objectTime1 = date_create( date('Ymd',$time1).'23:59:59');
            $objectTime2 = date_create( date('Ymd',$time2).'23:59:59');
        }else{
            $objectTime1 = date_create( date('Ymd H:i:s',$time1));
            $objectTime2 = date_create( date('Ymd H:i:s',$time2));
        }
        $res=date_diff($objectTime2,$objectTime1);
        return $res->days;
    }

    /*生成唯一ID*/
    public static function creatUuid($prefix = ''){
        $prefix .= mt_rand(1,9999999);
        $num = sprintf('%-010s', crc32(uniqid($prefix,true)));
        $num = floor($num / 10);
        return date('ym').sprintf('%03s',date('z')).$num.mt_rand(0,9) + 0;
    }

    //获取指定日期所在周的开始日期与结束日期 周一为一周的开始
    public static function getWeekRange($date){
        $ret=array();
        $timestamp=strtotime($date);
        $w=strftime('%u',$timestamp);
        $ret['sdate']=date('Ymd',$timestamp-($w-1)*86400);
        $ret['edate']=date('Ymd',$timestamp+(7-$w)*86400);
        return $ret;
    }

    //获取指定日期所在月的开始日期与结束日期
    public static function getMonthRange($date){
        $ret=array();
        $timestamp=strtotime($date);
        $mdays=date('t',$timestamp);
        $ret['sdate']=date('Ym01',$timestamp);
        $ret['edate']=date('Ym'.$mdays,$timestamp);
        return $ret;
    }
}

