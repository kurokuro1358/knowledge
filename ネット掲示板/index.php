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
mysqli_query($db, "create table if not exists article(
  number int auto_increment,
  date varchar(20) not null,
  author varchar(50) not null,
  password varchar(255) not null,
  title varchar(100) not null,
  content text not null,
  primary key(number)
  )");
  ?>

  <article id="work" class="wrapper style2">
    <div class="container">
      <header>
        <h2>ブログ一覧</h2>
      </header>

      <?php
      //テーブルからデータを抽出
      $sql = "select number, title, author, date from article order by number desc";
      $result = mysqli_query($db, $sql);
      while ($data = mysqli_fetch_array($result)) {
          ?>
        <div class="row">
          <div class="col-10 offset-1 py-4">
            <section class="box style1">
              <form action="article.php" method="post">
                <input type="hidden" name="number" value="<?php echo $data[0]; ?>">
                <h3>
                  <button class="button" type="submit" style="width: 80%;"><?php echo $data[1]; ?></button>
                </h3><br>
                <p class="black_p"><?php echo "著者:".$data[2]."<br>作成日:".$data[3]; ?></p>
              </form>
            </section>
          </div>
        </div>
        <?php
      }
      ?>
    </div>
  </article>

  <?php include("footer.php"); ?>
