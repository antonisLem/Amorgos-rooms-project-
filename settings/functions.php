<?php

require "config.php";

function dbConnect(){

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "contact_info";

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    if ($mysqli->connect_error != 0) {
        die("Connection failed: " . $mysqli->connect_error);
    }else{
        return $mysqli;
    }
}


function getAreas(){
    $mysqli = dbConnect();
    $result = $mysqli->query("SELECT DISTINCT area FROM room");
    while ($row = $result->fetch_assoc()) {
        $areas[] = $row;
    }

    return $areas;
}

function getRooms($int){

    $mysqli = dbConnect();
    $result = $mysqli->query("SELECT * FROM room ORDER BY rand() LIMIT $int");
    while( $row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}


function getRoomsByArea($area){

    $mysqli = dbConnect();

    $smtp = $mysqli->prepare("SELECT * FROM room WHERE area = ?");
    $smtp->bind_param("s", $area);
    $smtp->execute();
    $result = $smtp->get_result();
    $data = $result->fetch_all (MYSQLI_ASSOC);

    return $data;
}

function getDescByName($name){

    $mysqli = dbConnect();

    $smtp = $mysqli->prepare("SELECT * FROM room WHERE name = ?");
    $smtp->bind_param("s", $name);
    $smtp->execute();
    $result = $smtp->get_result();
    $data = $result->fetch_all (MYSQLI_ASSOC);

    return $data;

}

?>