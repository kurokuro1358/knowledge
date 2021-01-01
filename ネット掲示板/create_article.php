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

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['author']) && isset($_POST['password']) && isset($_POST['title']) && isset($_POST['content'])) {
      $author = $_POST['author'];
      $password = $_POST['password'];
      $title = $_POST['title'];
      $content = $_POST['content'];
      $date = date('Y年m月d日');

      mysqli_query($db, "insert into article (date, author, password, title, content) values ('".$date."','".$author."','".$password."' ,'".$title."','".$content."')"); ?>
    <div class="row">
      <h1><strong>記事作成</strong></h1>
      <div class="col-10 offset-1">
        <section class="box style1">
          <h3>投稿完了！</h3>
          <p>パスワード<strong><?php echo " ".$password." "; ?></strong>は、投稿を削除する際に必要になります。大切に保存しておいてください。<p>
          <p>早速、記事を確認してみましょう！</p>
          <a href="index.php">記事を確認する</a>
        </section>
      </div>
    </div>
    <?php
  } else {
      ?>
    <h1 class="text-center"><strong>記事作成</strong></h1>
    <div class="row">
      <div class="col-10 offset-1">
        <section class="box style1">
          <form action="create_article.php" method="post">
            <div class="form_text"><label>氏名</label>
              <input type="text" name="author" required>
            </div><br>
            <div class="form_text"><label>パスワード</label>
              <input type="text" name="password" required>
            </div><br>
            <div class="form_text"><label>タイトル</label>
              <input type="text" name="title" required>
            </div><br>
            <div class="form_textarea"><label>内容</label>
              <textarea class="textarea" name="content" required></textarea>
            </div><br>
            <div class="form_submit">
              <button type="submit">投稿</button>
            </div>
          </form>
        </section>
      </div>
    </div>
    <?php
  }
  ?>

  <?php include("footer.php"); ?>

