<?php
include("template.php");
setMySQL("mysql1.php.xdomain.ne.jp", "gather8980_gest", "Kingu822"); // server, user, password
setDatabase("gather8980_gather"); // database

//DB接続
connectMySQL();

// 画像データ取得
$sql = "select img from catalog where number = '" . $_GET['number']."'";
$result = mysqli_query($db, $sql);
$row = mysqli_fetch_row($result);

// 画像ヘッダとしてjpegを指定（取得データがjpegの場合）
header("Content-Type: image/jpeg");

// バイナリデータを直接表示
echo $row[0];
