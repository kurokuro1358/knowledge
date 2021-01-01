<?php include("header.php"); ?>

<?php
//MySQLに接続
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

//テーブルの作成
mysqli_query($db, "create table if not exists coordinate(
  number int auto_increment,
  img mediumblob not null,
  content text not null,
  primary key(number)
  )");

?>

<section id="sec03">
    <div class="inner">
        <h2>Coordinate</h2>
        <ul class="col3">
            <?php
            //テーブルからデータを抽出
            $sql = "select number, content from coordinate order by number desc";
            $result = mysqli_query($db, $sql);
            while ($data = mysqli_fetch_array($result)) {
                ?>
            <br>
            <div class="form2">
                <li>
                    <?php print("<img src=\"img_get_coordinate.php?number=" . $data[0] . "\">"); ?>
                </li><br>
                <li>
                    <p><?php echo nl2br($data[1]); ?></p>
                </li><br>
            </div>
            <?php
            } ?>
            <ul>
    </div>
</section>


<?php include("footer.php"); ?>