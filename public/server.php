<?php
/**
 * Created by PhpStorm.
 * User: nihao
 * Date: 2018/5/8
 * Time: 16:38
 */

$context = stream_context_create();
$pemfile = 'server.pem';
// local_cert must be in PEM format
stream_context_set_option($context, 'ssl', 'local_cert', $pemfile);
stream_context_set_option($context, 'ssl', 'allow_self_signed', true);
stream_context_set_option($context, 'ssl', 'verify_peer', true);
stream_context_set_option($context, 'ssl', 'verify_peer_name', false);

// Create the server socket
$socket = stream_socket_server(
    'tcp://0.0.0.0:8800',
    $errno,
    $errstr,
    STREAM_SERVER_BIND|STREAM_SERVER_LISTEN
);
if($socket === false && $errno === 0)
{ echo $errstr;exit;}

while(1)
{
    $s_socket = stream_socket_accept($socket);
    if(is_resource($s_socket))
    {
        echo fgets($s_socket);
//        while ($motd = fgets($s_socket)) {
//            echo $motd;
//        }
        fclose($s_socket);
    }else{
        echo "超时啦";
    }

    sleep(1);
}