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
?>

<?php if (!isset($_GET['number'])) { ?>


<!-- MESSAGE -->
<section id="sec01">
    <header>
        <h2><span>Profile</span></h2>
    </header>
    <div class="innerS">
        <div class="center">
            目標　お金をためて大きい車を買いたい
        </div>
    </div>
</section>
<!-- // MESSAGE -->


<!-- GALLERY -->
<section id="sec02">
    <header>
        <h2><span>Gallery</span></h2>
    </header>
    <div class="container">
        <div class="row">
        <?php
    //テーブルからデータを抽出
    $sql = "select number from article";
    $result = mysqli_query($db, $sql);
    while ($data = mysqli_fetch_array($result)) {
        ?>
                <div class="col-4 col-md-3">
                    <a href="index.php?number=<?php echo $data[0]; ?>">
                        <?php print("<img class=\"img-fluid\" src=\"img_get.php?number=" . $data[0] . "&what=img1\">"); ?>
                    </a>
                </div>
    <?php
    } ?>
        </div>
    </div>
</section>
<!-- // GALLERY -->
<?php } ?>

<?php if (isset($_GET['number'])) {
        $number = $_GET['number'];

        //テーブルからデータを抽出
        $sql = "select number, content from article where number=".$number;
        $result = mysqli_query($db, $sql); ?>

<?php
    while ($data = mysqli_fetch_array($result)) {
        ?>

<section id="sec01">
    <div class="innerS">
        <?php echo nl2br($data[1]); ?>
    </div>
</section>

<section id="sec02">
    <div class="container">
        <div class="row">
            <div class="col-4">
                <?php print("<img class=\"img-fluid\" src=\"img_get.php?number=" . $data[0] . "&what=img1\">"); ?>
            </div>
            <div class="col-4">
                <?php print("<img class=\"img-fluid\" src=\"img_get.php?number=" . $data[0] . "&what=img2\">"); ?>
            </div>
            <div class="col-4">
                <?php print("<img class=\"img-fluid\" src=\"img_get.php?number=" . $data[0] . "&what=img3\">"); ?>
            </div>
        </div>
    </div>
</section>

<?php
    }
    } ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<br><br><br><br>

</body>

</html>