<?php
/**
 * Created by PhpStorm.
 * User: nihao
 * Date: 2018/5/8
 * Time: 16:38
 */
$certificateData = array(
    "countryName" => "US",
    "stateOrProvinceName" => "Texas",
    "localityName" => "Houston",
    "organizationName" => "DevDungeon.com",
    "organizationalUnitName" => "Development",
    "commonName" => "DevDungeon",
    "emailAddress" => "nanodano@devdungeon.com"
);

// Generate certificate
$privateKey = openssl_pkey_new();
$certificate = openssl_csr_new($certificateData, $privateKey);
$certificate = openssl_csr_sign($certificate, null, $privateKey, 365);

// Generate PEM file
# Optionally change the passphrase from 'comet' to whatever you want, or leave it empty for no passphrase
//$pem_passphrase = 'abracadabra';
$pem = array();
openssl_x509_export($certificate, $pem[0]);
openssl_pkey_export($privateKey, $pem[1], null);
$pem = implode($pem);

// Save PEM file
$pemfile = './server.pem';
file_put_contents($pemfile, $pem);