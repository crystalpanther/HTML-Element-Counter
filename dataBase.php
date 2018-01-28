<?php
/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/19/2018
 * Time: 12:40 PM
 */
//



CONST USERNAME = 'root';
CONST PASSWORD = '';
CONST DBNAME   = 'stat';
CONST SERVER   = 'localhost';

$link = @ mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME) or die("MySQL connect error");
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

    $result = mysqli_query($link, "SELECT COUNT(id) FROM request WHERE url_id = (SELECT id FROM url WHERE name = '$url')");
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
            echo '<li>' . 'General Statistics' .
                '<li>' . $row[0]. ' </li>';
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
       // echo "The server receive no data" . "\n";
}
mysqli_close($link);