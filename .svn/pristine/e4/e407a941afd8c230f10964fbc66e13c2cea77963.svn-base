<?php
namespace fast;

use think\Config;

class File{
    //将$html里的baes64的图片转存并替换为链接
    public static function base64img($html, $code = true){
        if($code) $html = stripslashes($html);
        $e = preg_match_all('#<img src="data:image/([^;]*);base64,([^"]*)" \/>#isU', $html, $arr);
        if($e && $arr && $arr[2]){
            $dir = 'base64img/';
            foreach($arr[2] as $i => $b64){
                $img = base64_decode($b64);
                $type = $arr[1][$i];
                $src = date('Ym') .'/'. substr(md5($img), 0, 8) .'.'. $type;
                self::put($dir.$src, $img);
                $html = str_replace($arr[0][$i], '<img src="'. DATA_PATH . $dir . $src .'" />', $html);
            }
        }
        if($code) $html = addslashes($html);
        return $html;
    }

    //写文件
    public static function put($file, $s, $path = DATA_PATH, $append = NULL){
        $file = strpos($file, 'www/') !== false ? $file : $path.$file;
        return File::puts($file, $s, $append);
    }
    //写入文件(完整路径)
    public static function puts($file, $s, $append = NULL){
        $path = dirname($file);
        if(!is_dir($path)) mkdir($path, 0775, true);
        return file_put_contents($file, $s, $append);
    }

    //读文件
    public static function get($f, $bom = false){
        if(is_file($f)){
            $s = file_get_contents($f);
            if($s && $bom && ord(substr($s,0,1)) == 239 && ord(substr($s,1,1)) == 187 && ord(substr($s,2,1)) == 191){
                $s = substr($s, 3);
            }
        }else{
            $s = '';
        }
        return $s;
    }

    //备份
    public static function bak($file, $path = DATA_PATH){
        if(strpos($file,$path) === 0) $file = str_replace($path, '', $file);
        if(!is_file($path.$file)) return false;
        $arr = pathinfo($file);
        $ext = '.'.$arr['extension'];
        $admin = \think\Session::get('admin');
        $uid = $admin ? $admin->id : 0;
        $username = $admin ? $admin->username : __('Unknown');
        $new = str_replace($ext, '_'.OutFile::date('dHis').'_'.$uid.$ext, $file);
        return File::copy($path.$file, DATA_PATH .'bak/'. OutFile::date('Ym') .'/'. $new);
    }

    //复制文件
    public static function copy($from, $to, $code = 0775){
        $dir = dirname($to);
        if(!is_dir($dir)) mkdir($dir, $code, true);
        return copy($from, $to);
    }

    //原目录，复制到的目录
    public static function recurse_copy($src,$dst) {
        if($dir = opendir($src)){
            !is_dir($dst) && mkdir($dst, 0775, true);//无文件夹时新建
            while(false !== ( $file = readdir($dir)) ) {
                if (( $file != '.' ) && ( $file != '..' )) {
                    if ( is_dir($src . '/' . $file) ) {
                        File::recurse_copy($src . '/' . $file, $dst . '/' . $file);
                    }else {
                        copy($src . '/' . $file, $dst . '/' . $file);
                    }
                }
            }
        }
        closedir($dir);
    }

    //删除目录及目录下的所有文件
    public static function delAll($dirName){
        if(is_dir($dirName) && ($handle = opendir($dirName))){
            while(false!==($file = readdir($handle))){
                if($file != "." && $file != ".." ){
                    if(is_dir($dirName.'/'.$file)){
                        File::delDirAndFile($dirName.'/'.$file );
                    }else{
                        unlink($dirName.'/'.$file);
                    }
                }
            }
            closedir( $handle );
            rmdir( $dirName );
        }
    }

    //附件操作
    public static function attach($path, $add = false){
        if(!$path) return array();
        $url = Config::get('upload')['cdnurl'];
        if($add){
            $temp = $url . Config::get('upload_temp_val');
            File::recurse_copy($temp, $url.$path);//转移到新的目录
            File::delAll($temp);//删除临时目录
        }else{
            $dir = $url . $path;
            return File::getAll($dir, false, $dir);
        }
    }

    /**
     * 列出当前文件夹和文件
     * array(
     *	'path' => array(
     *		array("目录名","最后修改时间"),
     *		array("目录名","最后修改时间"),
     *	),
     *	'file' => array(
     *		array("文件名","最后修改时间"),
     *		array("文件名","最后修改时间"),
     *	),
     * )
     */
    public static function getList($defdir = '.', $full = false){
        $temp = array(
            "path" => array(),
            "file" => array()
        );
        if(is_dir($defdir)){
            $fh = opendir($defdir);
            while(($file = readdir($fh)) !== false){
                if(strcmp($file,'.') == 0 || strcmp($file,'..') == 0 || strcmp($file,'.svn') == 0) continue;
                $fs = $defdir.$file;
                $ret = $full ? $fs : $file;
                $time = date("Y-m-d H:i:s",filemtime($fs));
                if(is_dir($fs)){
                    $temp["path"][] = array($ret,$time);
                }else{
                    $temp["file"][] = array($ret,$time);
                }
            }
            closedir($fh);
        }
        return $temp;
    }

    //列出所有子文件，用来批量处理文件用
    public static function getAll($defdir = '.', $child = true, $del = ''){
        $temp = array();
        if(is_dir($defdir)){
            $fh = opendir($defdir);
            while(($file = readdir($fh)) !== false){
                if(strcmp($file,'.') == 0 || strcmp($file,'..') == 0) continue;
                $fs = $defdir."/".$file;
                $fs = str_replace("//","/",$fs);
                if(is_dir($fs)){
                    $child && $temp = array_merge($temp, File::getAll($fs,$child,$del));
                }else{
                    if($del) $fs = str_replace($del, '', $fs);
                    $temp[] = $fs;
                }
            }
            closedir($fh);
        }
        return $temp;
    }

    //列出文件及时间，后两参数都是函数递归需要的，对实际调用没多大意义
    public static function getTime($defdir, $child = true, $del = '', $temp = array()){
        $del = $del ? $del : $defdir;
        if(is_dir($defdir)){
            $fh = opendir($defdir);
            while(($file = readdir($fh)) !== false){
                if(strcmp($file,'.') == 0 || strcmp($file,'..') == 0) continue;
                $fs = $defdir."/".$file;
                $fs = str_replace("//","/",$fs);
                if(is_dir($fs)){
                    $child && ($temp = File::getTime($fs, $child, $del, $temp));
                }else{
                    $temp[str_replace($del, '', $fs)] = filemtime($fs);
                }
            }
            closedir($fh);
        }
        return $temp;
    }

    private static function delDirAndFile($filename,$withself = true)
    {
            return rmdirs($filename,$withself);
    }
}