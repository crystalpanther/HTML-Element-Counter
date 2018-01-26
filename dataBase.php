<?php
/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/19/2018
 * Time: 12:40 PM
 */
//

session_start();

const USERNAME = 'root';
const PASSWORD = '';
const DBNAME   = 'elements_stat';
const SERVER   = 'localhost';

$link = @mysqli_connect(SERVER,USERNAME,PASSWORD,DBNAME) or die("no connect");
mysqli_set_charset($link, "utf8");


if (!empty($_GET['url']) && !empty($_GET['htmlElement'])) {
    $url = $_GET['url'];
    $htmlElement = $_GET['htmlElement'];
    $domain = $_GET['domain'];
    $duration = $_GET['duration'];


    $url = htmlspecialchars($url);
    $htmlElement = htmlspecialchars($htmlElement);
    $domain = htmlspecialchars($domain);
    $duration = (int)$duration;

    //echo  'url: ' .  $url . ' element: ' .  $htmlElement . ' domain: ' . $domain . ' duration: ' . $duration;

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

    $result = mysqli_query($link, "SELECT COUNT(id) FROM request WHERE domain_id = (SELECT id FROM domain WHERE name = '$domain')");
//    $tagTotal = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='$htmlElement'");
//    $tagTotalDomain = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='$htmlElement' AND url  LIKE '%$url%'");
//    $tagDay = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='$htmlElement' AND `date` >= DATE_SUB(CURRENT_DATE, INTERVAL 24 HOUR)");
//
    if (!$result) {
        echo mysqli_error($link);
    }
    else {
//        while ($row = $a->fetch_row()) {
//            echo $row[0];
//        }
        while ($row = mysqli_fetch_array($result)) {
            echo '<li>' .$row[0]. ' </li>';
        }
//        while ($row = mysqli_fetch_array($tagDay)) {
//            echo '<li>' .$row[0]. ' </li>';
//        }
//        while ($row = mysqli_fetch_array($tagTotalDomain)) {
//            echo '<li>' .$row[0]. ' </li>';
//        }
    }

}
else {
   echo "error";
}
mysqli_close($link);