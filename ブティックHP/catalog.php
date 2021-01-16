<?php include("header.php"); ?>


<!-- カテゴリー選択画面----------------------------------------------->
<?php
if (!($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['category']))) {
    ?>

<section id="sec01">
    <div class="vision">
    <h2>Category</h2>
        <div class="form3">
            <form action="catalog.php" method="post">
            <div class="container">
                <div class="row">
                    <button class="col-10 col-md-4 offset-1 offset-md-1 " type="submit" name="category" value="tops">トップス</button>
                    <button class="col-10 col-md-4 offset-1 offset-md-2 " type="submit" name="category" value="pants">パンツ</button>
                    <button class="col-10 col-md-4 offset-1 offset-md-1 " type="submit" name="category" value="skirt">スカート</button>
                    <button class="col-10 col-md-4 offset-1 offset-md-2 " type="submit" name="category" value="jacket">ジャケット</button>
                    <button class="col-10 col-md-4 offset-1 offset-md-1 " type="submit" name="category" value="onepiece">ワンピース</button>
                    <button class="col-10 col-md-4 offset-1 offset-md-2 " type="submit" name="category" value="other">その他</button>
                </div>
            </div>
            </form>
        </div>
    <br><br>
    </div>
</section>
<?php
}
?>
<!-- カテゴリー選択画面----------------------------------------------->




<!-- カテゴリー処理--------------------------------------------------->
<?php
if ($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['category'])) {
    $category = $_POST['category'];

    connectMySQL();
?>
    <section id="sec03">
        <div class="inner">
            <h2><?php echo $category; ?></h2>
            <ul class="col3">
<?php
                $query ="select number, name, price, content from catalog where category='".$category."' order by number desc";
                $datas = getQuery($query);
                foreach($datas as $data){
?>
                <br>
                <div class="form2">
                <li>
                    <br>
                    <?php print("<img src=\"img_get_catalog.php?number=" . $data[0] . "\">"); ?>
                </li><br>
                <li>
                    <p><?php echo "品名 : ".$data[1]; ?></p>
                    <p><?php echo "価格 : ".$data[2]; ?></p><br>
                    <p><?php echo nl2br($data[3]); ?></p>
                </li><br>
                </div>
<?php
                } 
?>
            <ul>
    </div>
</section>
<?php
}
?>
<!-- カテゴリー処理--------------------------------------------------->



<?php include("footer.php"); ?>