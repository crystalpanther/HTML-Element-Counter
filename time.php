<?php
/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/29/2018
 * Time: 11:33 AM
 */

CONST SERVER   = 'localhost';
CONST USERNAME = 'root';
CONST PASSWORD = '';
CONST DBNAME   = 'stat';

$link = @mysqli_connect(SERVER, USERNAME, PASSWORD, DBNAME) or die("no connect");
mysqli_set_charset($link, "utf8");



mysqli_query($link, "INSERT INTO request(duration) VALUES ('$duration')");

echo $duration;

mysqli_close($link);