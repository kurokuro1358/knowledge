<?php include("header.php"); ?>

<?php
connectMySQL();

//テーブルの作成
$query = "create table if not exists coordinate(number int auto_increment, img mediumblob not null, content text not null, primary key(number))";
mysqlQuery($query);

?>

<section id="sec03">
    <div class="inner">
        <h2>Coordinate</h2>
        <ul class="col3">
<?php
            //テーブルからデータを抽出
            $query = "select number, content from coordinate order by number desc";
            $datas = getQuery($query);
            foreach($datas as $data){
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
            } 
?>
            <ul>
    </div>
</section>


<?php include("footer.php"); ?>