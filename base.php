<?php

/**
 * Created by PhpStorm.
 * User: elina
 * Date: 1/21/2018
 * Time: 4:58 PM
 */
class base
/*
 * Set constant class,
 * define parameters of connecting to the MySQL-server
 */
{
    const USERNAME = 'root';
    const PASSWORD = '';
    const DBNAME   = 'colnect';
    const SERVER   = 'localhost';


    // The constructor of the class setting  a connect with database

    function __construct($name = NULL)
    {
        if ($mysqli = new mysqli(self::SERVER, self::USERNAME,
            self::PASSWORD, self::DBNAME)) {
            $this->connection = $mysqli;
        }
        else
        {
            echo "Cannot to connect to the database";
            exit;
        }
        if ($name) {
            $this->name = $name;
            echo $name;
        }
    }
    // Define the method for insert to the base major data

    function statistics_of_requests($mysqli) {
        $url = $_GET['url'];
        $htmlElement = $_GET['htmlElement'];
        $time = $_GET['time'];

        mysqli_query ($mysqli, "INSERT INTO statistics (url, tag, time) VALUES ('$url', '$htmlElement', '$time') ");

        $result = mysqli_query($mysqli, "SELECT * FROM statistics");
        if (!$result) {
            echo mysqli_error($mysqli);
        }
        else {
            while ($row = mysqli_fetch_array($result)) {
                echo 'Data base error';
            }
        }

    }

    function connect_close() {
        $this->connection->close();
    }
}