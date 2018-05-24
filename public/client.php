<?php
/**
 * Created by PhpStorm.
 * User: nihao
 * Date: 2018/5/8
 * Time: 16:40
 */
$host = '127.0.0.1';
$port = 8800;
$timeout = 2;
$cert = 'server.pem'; // Path to certificate
$context = stream_context_create([ 'ssl' => [
    'local_cert'        => '/vagrant/cms/public/server.pem',
//    'peer_fingerprint'  => openssl_x509_fingerprint(file_get_contents('/vagrant/cms/public/server.crt')),
    'verify_peer'       => true,
    'verify_peer_name'  => false,
    'allow_self_signed' => true,
    'verify_depth'      => 0 ]]);

if ($socket = stream_socket_client(
    'tcp://'.$host.':'.$port,
    $errno,
    $errstr,
    2,
    STREAM_CLIENT_CONNECT)
) {
//    stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_SSLv23_CLIENT);
    fwrite($socket, "USER god\r\n");
    fwrite($socket, "PASS secret\r\n");

    /* Turn off encryption for the rest */
    stream_socket_enable_crypto($socket, false);

//    while ($motd = fgets($socket)) {
//        echo $motd;
//    }

    fclose($socket);
} else {
    echo "ERROR: $errno - $errstr\n";
}