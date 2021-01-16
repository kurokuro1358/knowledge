<?php
$server = "localhost";
$user = "kurokuro";
$password = "secret";
$database = "gather8980_gather";
$db = "";

function setMySQL($changeServer, $cahgeUser, $chagePassword){
    global $server, $user, $password;
    $server = $changeServer;
    $user = $cahgeUser;
    $password = $chagePassword;
}

function setDatabase($chageDatabase){
    global $database;
    $database = $chageDatabase;
}

function connectMySQL(){
    global $server, $user, $password, $database, $db;
    // mysqlに接続
    $db = mysqli_connect($server, $user, $password);
    if (!$db) {
        echo "Cannot connect to MySQL.<br>";
        exit();
    }

    //データベースの作成と接続
    mysqli_query($db, "create database if not exists ".$database." default character set utf8");
    if (!mysqli_select_db($db, $database)) {
        echo "Cannot connect to database.<br>";
    }
}

function mysqlQuery($query){
    global $server, $user, $password, $database, $db;
    mysqli_query($db, $query);
}

function getQuery($query){
    global $server, $user, $password, $database, $db;
    $array;

    $result = mysqli_query($db, $query);
    while ($data = mysqli_fetch_array($result)) {
        $array[] = $data;
    }

    return $array;
}


?>