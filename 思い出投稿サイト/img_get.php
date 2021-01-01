<?php
    $server = "mysql1.php.xdomain.ne.jp";
    $user = "tora3blog_worker";
    $pass = "Kingu822";
    $database = "tora3blog_myblog";

//DB接続
$db = mysqli_connect($server, $user, $pass);
if (!$db) {
    echo "Cannot connect to MySQL.<br>";
    exit();
}

//データベースの作成と接続
mysqli_query($db, "create database if not exists ".$database." default character set utf8");
if (!mysqli_select_db($db, $database)) {
    echo "Cannot connect to database.<br>";
}

if ($_GET['what'] == 'img1') {
    // 画像データ取得
    $sql = "select img1 from article where number = '".$_GET['number']."'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);

    // 画像ヘッダとしてjpegを指定（取得データがjpegの場合）
    header("Content-Type: image/jpeg");

    // バイナリデータを直接表示
    echo $row[0];
} elseif ($_GET['what'] == 'img2') {
    // 画像データ取得
    $sql = "select img2 from article where number = '".$_GET['number']."'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);

    // 画像ヘッダとしてjpegを指定（取得データがjpegの場合）
    header("Content-Type: image/jpeg");

    // バイナリデータを直接表示
    echo $row[0];
} else {
    // 画像データ取得
    $sql = "select img3 from article where number = '".$_GET['number']."'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_row($result);

    // 画像ヘッダとしてjpegを指定（取得データがjpegの場合）
    header("Content-Type: image/jpeg");

    // バイナリデータを直接表示
    echo $row[0];
}
