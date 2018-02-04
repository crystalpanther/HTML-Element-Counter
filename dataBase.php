<?php
/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/19/2018
 * Time: 12:40 PM
 */


session_start();

//define the MySQL server main proprieties
CONST USERNAME = 'root';
CONST PASSWORD = '';
CONST DBNAME   = 'stat';
CONST SERVER   = 'localhost';

$link = @mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME) or die("MySQL connect error");
mysqli_set_charset($link, "utf8");


//check if information from the client is available
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

    $d = mysqli_query($link, "SELECT SUM(request.element_count) FROM request INNER JOIN domain 
    WHERE request.domain_id = domain.id AND domain.id = (SELECT id FROM domain WHERE domain.name = '$domain') 
    AND request.element_id = (SELECT id FROM element WHERE name='$htmlElement');");

    $e = mysqli_query($link, "SELECT SUM(request.element_count) FROM request
    WHERE element_id = (SELECT id FROM element WHERE name = '$htmlElement')");

    $start = 0;
    $end = 0;
    $totalElem = 0;
    $totalElem = 0;
    $elem = 0;
    $avg = 0;

    if (!$a && !$b && !$c && !$d) {
        //echo mysqli_error($link);
    }
    else {
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

        /** @var int $avg */

        echo '<ul>' .
            '<li>' . '<span> ' . $diff .' </span>' . ' different URLs from ' . '<span> ' . $domain . ' </span>'  . ' have been fetched ' . '</li>' .
            '<li>' . 'Average fetch time from ' . '<span> ' . $domain .' </span>' . ' during the last 24 hours is ' . round ($avg) . 'msec' . '</li>' .
            '<li> '. 'There was a total of ' . $elem . ' ' . '<span> ' . '&lt;' . $htmlElement . '&gt;' . ' </span>' . ' from ' . '<span> ' . $domain . ' </span>' . '</li>' .
            '<li>' . 'Total of ' . $totalElem . ' ' . '<span> ' . '&lt;' . $htmlElement  . '&gt;' . ' </span>' . ' counted in all requests ever made.' . '</li>'
            . '</ul>';


    }

}
else {
    echo "The server receive no data" . "\n";
}
mysqli_close($link); //close the session