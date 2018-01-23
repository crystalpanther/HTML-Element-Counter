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
const DBNAME   = 'colnect';
const SERVER   = 'localhost';

$link = @mysqli_connect(SERVER,USERNAME,PASSWORD,DBNAME) or die("no connect");
mysqli_set_charset($link, "utf8");


//if (isset($_GET['url']) || isset($_GET['htmlElement']) || isset($_GET['time'])   ) {
    $url = $_GET['url'];
    $htmlElement = $_GET['htmlElement'];
    $time = $_GET['time'];


    $url = htmlspecialchars($url);
    $htmlElement = htmlspecialchars($htmlElement);
    $time = htmlspecialchars($time);

    echo $url . $htmlElement . $time;

    mysqli_query ($link, "INSERT INTO statistics (url, tag, time) VALUES ('$url', '$htmlElement', '$time') ");

    $result = mysqli_query($link, "SELECT COUNT(url) FROM statistics WHERE url LIKE '%addphp.ru%'");
    $tagTotal = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='img'");
    $tagTotalDomain = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='img' AND url  LIKE '%addphp.ru%'");
    $tagDay = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='img' AND DATE_SUB(CURRENT_DATE, INTERVAL 1 DAY)");

    if (!$tagTotal || !$result) {
        echo mysqli_error($link);
    }
    else {
        while ($row = $tagTotal->fetch_row()) {
            echo $row[0];
        }
        while ($row = mysqli_fetch_array($result)) {
            echo '<li>' .$row[0]. ' </li>';
        }
        while ($row = mysqli_fetch_array($tagDay)) {
            echo '<li>' .$row[0]. ' </li>';
        }
        while ($row = mysqli_fetch_array($tagTotalDomain)) {
            echo '<li>' .$row[0]. ' </li>';
        }
    }

//}

mysqli_close($link);