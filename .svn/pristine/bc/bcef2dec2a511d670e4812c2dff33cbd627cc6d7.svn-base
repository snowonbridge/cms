<?php

namespace fast;

use CURLFile;
use think\Config;
use think\Session;

class SendFile
{
    public function __construct()
    {
    }

    //发送文件
    public function file($file, $path = '', $zip = true, $cgi = '')
    {
        return $this->curl([
            'file' => $file,
            'path' => $path,
            'zip' => $zip,
            'cgi' => $cgi,
            'cdn' => false,
        ]);
    }


    public function curl($opt)
    {
        if (!$opt || !is_array($opt)) Func::callback('[SendFile->curl]参数格式错误！');
        $p = [
            'file' => '',//文件列表
            'cdn' => false,//发到CDN
            'zip' => true,//压缩发布
            'path' => '',//源目录
            'cgi' => '',
            'target' => '',//目标目录
            'ret' => 1//是否返回错误信息 默认是直接callback了
        ];
        $p = array_merge($p, $opt);
        $p['file'] or Func::callback('SendFile->curl]p.file is error');


        if ($p['file'] && is_string($p['file']) && strpos($p['file'], ',') !== false) $p['file'] = explode(',', $p['file']);
        if (!is_array($p['file'])) $p['file'] = [$p['file']];
        $p['path'] = $p['path'] ? $p['path'] : DATA_PATH;
        foreach ($p['file'] as $k => $f) {
            if (!$f || !is_file($p['path'] . $f) && !is_dir($p['path'] . $f)) {
                if (OutFile::$cfg['phpsend']) echo '文件[<b>' . $p['path'] . $f . '</b>]不存在<br>';
                unset($p['file'][$k]);
            }
        }

        if (!$p['file']) {
            if (OutFile::$cfg['phpsend']) die('<b style="color:red">文件列表错误，发布失败！</b>');
            return false;
        }

        $admin = Session::get('admin');
        $uid = $admin ? $admin->id : 0;
        $tarName = $zipshell = $fileStrLog = '';
        $data = ['sendStr' => '|'];
        if ($p['zip']) {
            $fileStr = join(" ", $p['file']);
            $fileStrLog = join('|', $p['file']);
            $tarName = $uid . '.' . md5($fileStr) . '.cms.tar';
            $zipshell = 'cd ' . $p['path'] . ' && tar -zcf ' . $p['path'] . $tarName . ' ' . $fileStr;
            system($zipshell);
            $fs = $p['path'] . $tarName;
            $data['file0'] = $tarName;
            $data['md50'] = md5_file($fs);//验证文件完整性
            if (version_compare(phpversion(), '5.5.0') >= 0 && class_exists('CURLFile')) {
                $data['upload0'] = new CURLFile(realpath($fs));
            } else {
                $data['upload0'] = '@' . $fs;
            }
            $data['sendStr'] .= $tarName . '|';
        } else {
            foreach ($p['file'] as $i => $f) {
                $fs = $p['path'] . $f;
                $data['file' . $i] = $f;
                $data['md5' . $i] = md5_file($fs);//验证文件完整性
                if (version_compare(phpversion(), '5.5.0') >= 0 && class_exists('CURLFile')) {
                    $data['upload' . $i] = new CURLFile(realpath($fs));
                } else {
                    $data['upload' . $i] = '@' . $fs;
                }
                $data['sendStr'] .= $f . '|';
            }
        }

        $keypar = ['sendStr' => $data['sendStr']];
        if ($uid == 1) {
            $keypar['nologin'] = '1';
            $data['nologin'] = '1';
        }
        if (!$p['cgi']) {
            $p['cgi'] = Config::get('send_url');
        }
        $url = $p['cgi'] . 'ftp.php?' . Func::rsync_key('url', $keypar);
        if (isset($p['sendTo']) && $p['sendTo']) $data['sendTo'] = implode($p['sendTo'], '|');
        $ret = OutFile::curl_send($url, $data);
        if (OutFile::$cfg['debug']) {
            Func::ob_log('init', $url, $data, $ret);
            Func::ob_log('out', 'sendFileDebug.txt');
            echo '<pre>' . $url . '<br>';
            var_dump($ret, $data);
        }
        if (OutFile::$cfg['phpsend']) {//php运行发布
            $s = $ret[0] == $data['sendStr'] ? '<b style="color:green">【发布成功】</b>' : '<b style="color:red">【发布失败】</b>';
            echo '<b>' . $url . '</b><br>' . $s . '<pre>';
            print_r($p['file']);
            print_r($ret);
            die();
        }
        if ($ret[0] != $data['sendStr']) {
            $args = func_get_args();
            if (is_array($ret) && isset($ret[1])) {
                $s = 'SendFile->curl(' . json_encode($args) . ') ,' . $ret[1] . ',suc:' . $ret[0] . ',url:' . $url . ',dataStr:' . $data['sendStr'] . ',ret:' . json_encode($ret);
            } else {
                $s = 'Send->curl(' . json_encode($args) . '),return:' . json_encode($ret);
            }
            if ($p['zip']) $s .= ',zipshell:' . $zipshell;
            Func::log($s, $uid == 1 ? 'sendFileAs' : 'sendFileErr');
            if ($p['ret'] === true) return $s;//返回错误信息
            Func::callback($s);
        }
        Func::log(trim($ret[0], '|') . ($p['zip'] ? '=>' . $fileStrLog : ''), 'sendFile');
        if ($tarName) {
            $dir = DATA_PATH . Func::date('Ym') . '/sendFile_tar/';
            if (!is_dir($dir)) mkdir($dir, 0775, true);
            rename($p['path'] . $tarName, $dir . Func::date('dhis') . '_' . $tarName);
        }
        return true;
    }
}
