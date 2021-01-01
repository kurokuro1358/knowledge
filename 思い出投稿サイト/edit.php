<?php include("header.php"); ?>

<?php
//DB接続
$db = mysqli_connect($server, $user, $pass);
if (!$db) {
    echo "Cannot connect to MySQL.";
    exit;
}

//データベースの作成と接続
mysqli_query($db, "create database if not exists ".$database." default character set utf8");
if (!mysqli_select_db($db, $database)) {
    echo "Cannot connect to database.<br>";
}

//テーブルの作成
mysqli_query($db, "create table if not exists article(
    number int auto_increment,
    img1 mediumblob not null,
    img2 mediumblob not null,
    img3 mediumblob not null,
    content text not null,
    primary key(number)
)");
?>

<!-- EDIT -->
<?php if ($_SERVER['REQUEST_METHOD'] != "POST" && !isset($_POST['submit'])) { ?>
<br><br>
<section id="sec01">
    <header>
        <h2><span>管理</span></h2>
    </header>
    <div class="innerS">
        <form method="post" enctype="multipart/form-data" action="edit.php">
            <div class="center">
                <p><input type="file" name="upimage1" size="200" required></p>
                <p><input type="file" name="upimage2" size="200" required></p>
                <p><input type="file" name="upimage3" size="200" required></p>
                <p><textarea name="content" rows="40" cols="50" required></textarea></p>
                <p><button type="submit" name="submit">追加</button></p>
            </div>
        </form>
    </div>
</section>
<?php } ?>
<!-- // EDIT -->

<!-- ADD -->
<?php if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit'])) {
    $upimage1 = $_FILES['upimage1']['tmp_name'];
    $upimage2 = $_FILES['upimage2']['tmp_name'];
    $upimage3 = $_FILES['upimage3']['tmp_name'];
    $content = $_POST['content'];
    if ($upimage1 == "" || $upimage2 == "" || $upimage3 == "") {
        echo "Cannot upload images";
        exit;
    }

    //ファイル取得
    exec('/usr/bin/exiftool -all= '. $upimage1);
    $imgdat1 = file_get_contents($upimage1);
    $imgdat1 = mysqli_real_escape_string($db, $imgdat1);

    exec('/usr/bin/exiftool -all= '. $upimage2);
    $imgdat2 = file_get_contents($upimage2);
    $imgdat2 = mysqli_real_escape_string($db, $imgdat2);

    exec('/usr/bin/exiftool -all= '. $upimage3);
    $imgdat3 = file_get_contents($upimage3);
    $imgdat3 = mysqli_real_escape_string($db, $imgdat3);

    $sql = "insert into article (img1, img2, img3, content) values ('".$imgdat1."','".$imgdat2."','".$imgdat3."','".$content."')";

    $result = mysqli_query($db, $sql);
    if (!$result) {
        echo "Cannot execute sql";
        exit;
    } ?>
    <!-- MESSAGE -->
    <br><br>
    <section id="sec01">
        <header>
            <h2><span>追加完了</span></h2>
        </header>
        <div class="innerS">
            <div class="center">
                <a href="index.php">ホームに戻る</a>
            </div>
        </div>
    </section>
    <!-- // MESSAGE -->
    <?php
}?>
<!-- ADD -->

<footer id="footer">
    Copyright(c) 2016 Sample Inc. All Rights Reserved. Design by <a href="http://f-tpl.com"
        target="_blank">http://f-tpl.com</a><!-- ←クレジット表記を外す場合はシリアルキーが必要です http://f-tpl.com/credit/ -->
</footer>

</body>

</html>