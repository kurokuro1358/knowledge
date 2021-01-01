<?php
$server = 'mysql1.php.xdomain.ne.jp';
$user = 'gather8980_gest';
$pass = 'Kingu822';
$database = 'gather8980_gather';

//DB接続
$db = mysqli_connect($server, $user, $pass);
if (!$db) {
    echo "Cannot connect to MySQL.<br>";
    exit();
}

//データベースの作成と接続
mysqli_query($db, "create database if not exists '".$database."' default character set utf8");
if (!mysqli_select_db($db, $database)) {
    echo "Cannot connect to database.<br>";
}

// 画像データ取得
$sql = "select img from catalog where number = '" . $_GET['number']."'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_row($result);

// 画像ヘッダとしてjpegを指定（取得データがjpegの場合）
header("Content-Type: image/jpeg");

// バイナリデータを直接表示
echo $row[0];
