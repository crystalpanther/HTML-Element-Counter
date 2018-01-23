<?php
/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/19/2018
 * Time: 12:33 PM
 */
//$url = $_POST['url'];

header('Access-Control-Allow-Origin: *');

function get_web_page( $url )
{
    $uagent = "Opera/9.80 (Windows NT 6.1; WOW64) Presto/2.12.388 Version/12.14";

    $ch = curl_init( $url );

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   // return webpage
    curl_setopt($ch, CURLOPT_HEADER, 0);           // do not return headers
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);   // moves on redirects
    curl_setopt($ch, CURLOPT_ENCODING, "");        // handles all encodings
    curl_setopt($ch, CURLOPT_USERAGENT, $uagent);  // useragent
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // timeout connection
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);        // timeout answer
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);       // stop after the 10th redirect

    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );

    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}
$result = get_web_page( 'http://php.net/manual/ru/function.empty.php' );

if (($result['errno'] != 0 )||($result['http_code'] != 200))
{
    echo $result['errmsg'];
}
else
{
    $page = $result['content'];
    echo $page;
}