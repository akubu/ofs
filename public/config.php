<?php

function db_config(){

    $hostname = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "p2scategories";

    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if (!$conn) {
        die('Could not connect: ' . mysqli_error());
    }
    return $conn;

}
function db_location_config(){
    $hostname = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "master_db";

     //connection to the database
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if (!$conn) {
        die('Could not connect: ' . mysqli_error());
    }

    return $conn;
}

function db_bazaar_config(){
    $hostname = "103.25.172.167";
    $username = "mmm";
    $password = "mmmmq@123";
    $dbname = "bazaar";

    //connection to the database
    $conn = mysqli_connect($hostname, $username, $password, $dbname);
    if (!$conn) {
        die('Could not connect: ' . mysqli_error());
    }

    return $conn;
}
?>