<?php include("header.php"); ?>

<?php
//MySQLに接続
$db = mysqli_connect($server, $user, $pass);
if (!$db) {
    echo "Cannot connect to MySQL<br>";
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['number'])) {
    $number = $_POST['number'];
    $sql = "select date, author, title, content from article where number=".$number;
    $result = mysqli_query($db, $sql);
    while ($data = mysqli_fetch_array($result)) { ?>
    <article id="work" class="wrapper style2">
      <div class="container">
          <div class="row">
            <div class="col-10 offset-1">
              <section class="box style1">
                <header>
                  <h1><strong><?php echo $data[2];?></strong></h1>
                </header>
                <p class="date"><?php echo $data[1]." ".$data[0];?></p>
                <p class="content"><?php echo nl2br($data[3]);?></p>
              </section>
            </div>
            <div class="col-10 offset-1">
              <section class="box style1">
                <form action="delete_article.php" method="post">
                  <label>パスワード</label>
                  <input type="hidden" name="number" value="<?php echo $number; ?>">
                  <input type="text" name="password" required>
                  <label>投稿時に指定したパスワードを記入してください</label><br>
                  <button type="submmit">削除</button>
                </form>
              </section>
            </div>
          </div>
          <?php
        } ?>
      </div>
    </article>


    <?php
} else {
            ?>
  <article id="work" class="wrapper style2">
    <div class="container">
        <div class="row">
          <div class="col-10 offset-1">
            <section class="box style1">
              <p>ページを再送すると、記事が表示されません。お手数ですが、以下のリンクより、もう一度記事を選び直してください。</p>
              <a href="index.php">ホームに戻る</a>
            </section>
          </div>
        </div>
      </div>
    </article>
  <?php
        }
?>

<?php include("footer.php"); ?>

