<?php
/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/19/2018
 * Time: 12:33 PM
 */

header('Access-Control-Allow-Origin: *');

$url = $_POST['url'];
echo $url;


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
    curl_setopt($ch, CURLOPT_POST, 1);

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

$result = get_web_page( $url );


if (($result['errno'] != 0 )||($result['http_code'] != 200))
{
    echo $result['errmsg'];
}
else
{
    $page = $result['content'];
    //echo $page;
}

const USERNAME = 'root';
const PASSWORD = '';
const DBNAME   = 'elements_stat';
const SERVER   = 'localhost';


if (!empty($_POST['url']) && !empty($_POST['htmlElement'])) {

    $url = $_POST['url'];
    $htmlElement = $_POST['htmlElement'];

    function sendTo_db ($url, $htmlElement) {

        $link = @mysqli_connect(SERVER,USERNAME,PASSWORD,DBNAME) or die("no connect");
        mysqli_set_charset($link, "utf8");
        mysqli_set_charset($link, "utf8");

        $domain = $_POST['domain'];
        $duration = $_POST['duration'];

        $url = htmlspecialchars($url);
        $htmlElement = htmlspecialchars($htmlElement);
        $domain = htmlspecialchars($domain);
        $duration = (int)$duration;

        mysqli_query($link, "INSERT INTO url(name) VALUE ('$url')");
        mysqli_query($link, "INSERT INTO domain(name) VALUE ('$domain')");
        mysqli_query($link, "INSERT INTO element(name) VALUE ('$htmlElement')");

        mysqli_query($link, "INSERT INTO request(url_id, domain_id, element_id, duration) 
        VALUES (
        (SELECT id FROM url WHERE name = '$url'),
        (SELECT id FROM domain WHERE name = '$domain'),
        (SELECT id FROM element WHERE name = '$htmlElement'),
        '$duration'
        )");
        return 0;

    }
    $db_result = sendTo_db( $url, $htmlElement);

}
else {
    echo 'data base error';
}

