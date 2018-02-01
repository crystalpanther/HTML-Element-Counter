<?php
/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/19/2018
 * Time: 12:40 PM
 */
//

session_start();

$seconds = 10;
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


    $url = htmlspecialchars($url);
    $htmlElement = strval ($htmlElement);
    $domain = htmlspecialchars($domain);

    $a = mysqli_query($link, "SELECT count(request.id) FROM request INNER JOIN domain WHERE 
    request.domain_id = domain.id AND domain.id = (SELECT id FROM domain WHERE domain.name = '$domain')");

    $b = mysqli_query($link, "SELECT count(request.id) FROM request WHERE request.url_id = (SELECT id FROM url WHERE name = '$domain')");

    $c = mysqli_query($link, "SELECT AVG(request.duration) FROM `request` WHERE domain_id = (SELECT id FROM domain WHERE name = '$domain') 
    AND `time` >= DATE_SUB(CURRENT_DATE, INTERVAL 24 HOUR)");

    $d = mysqli_query($link, "SELECT count(request.element_id) FROM request INNER JOIN domain 
    WHERE request.domain_id = domain.id AND domain.id = (SELECT id FROM domain WHERE domain.name = '$domain');");

    $e = mysqli_query($link, "SELECT COUNT(element_id) FROM request WHERE element_id = (SELECT id FROM element WHERE name = '$htmlElement')");


//    $tagTotal = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='$htmlElement'");
//    $tagTotalDomain = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='$htmlElement' AND url  LIKE '%$url%'");
//    $tagDay = mysqli_query($link, "SELECT COUNT(tag) FROM statistics WHERE statistics.tag='$htmlElement' AND `date` >= DATE_SUB(CURRENT_DATE, INTERVAL 24 HOUR)");
//
    if (!$a && !$b && !$c && !$d) {
        //echo mysqli_error($link);
    }
    else {
//        while ($row = $a->fetch_row()) {
//            echo $row[0];
//        }
        while ($row = mysqli_fetch_array($a)) {
            $start = $row[0];
        }
        while ($row = mysqli_fetch_array($b)) {
            $end = $row[0];
        }
        while ($row = mysqli_fetch_array($c)) {
            $avg = $row[0];
        }
        while ($row = mysqli_fetch_array($d)) {
            $elem = $row[0];
        }
        while ($row = mysqli_fetch_array($e)) {
            $totalElem = $row[0];
        }
        $diff = $start - $end;
        $total =  $totalElem - $elem;

        echo '<ul>' .
            '<li>' . '<span> ' . $diff .' </span>' . ' different URLs from ' . '<span> ' . $domain . ' </span>'  . ' have been fetched ' . '</li>' .
            '<li>' . 'Average fetch time from ' . '<span> ' . $domain .' </span>' . ' during the last 24 hours is ' . $avg . 'msec' . '</li>' .
            '<li> '. 'There was a total of ' . $elem . ' ' . $htmlElement . ' from ' . '<span> ' . $domain . ' </span>' . '</li>' .
            '<li>' . 'Total of ' . $totalElem . ' '  . $htmlElement .  ' counted in all requests ever made.' . '</li>'
           . '</ul>';
    }

}
else {
        echo "The server receive no data" . "\n";
}
mysqli_close($link);