<?php include("header.php"); ?>



<!-- DBの前処理---------------------------------->
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
  path text not null,
  content text not null,
  primary key(number)
  )");
?>

<!-- DBの前処理---------------------------------->




<!-- ログイン画面 -->
<?php
if (!($_SERVER[REQUEST_METHOD] == 'POST')) {
    ?>
<section id="sec01">
    <header>
        <h2>ログイン</h2>
    </header>
    <div class="vision">
        <div class="form1">
            <form action="staff.php" method="post">
                <label>ログインID</label><br>
                <input type="text" name="id" required><br>
                <label>パスワード</label><br>
                <input type="password" name="password" required><br>
                <button type="submit">ログイン</button>
            </form>
        </div>
        <br>
    </div>
</section>
<?php
}
?>
<!-- ログイン画面 -->




<!-- ログイン検証 -->
<?php
if ($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['id']) && isset($_POST['password'])) {
    $id = $_POST['id'];
    $password = $_POST['password'];

    //テーブルからデータを抽出
    $sql = "select id, password from login";
    $result = mysqli_query($db, $sql);
    while ($data = mysqli_fetch_array($result)) {
        if ($data[0] == $id) {
            $tmp = $data[1];
        }
    }
    if (isset($tmp) && $password == $tmp) {

            //編集画面の表示
            ?>
            <section id="sec01">
                <div class="vision">
                    <br>
                        <div class="form1">
                            <form action="staff.php" method="post">
                                <label>編集するものを選んでください</label><br>
                                <button type="submit" name="type" value="add_coordinate">Coordinate追加</button>
                                <button type="submit" name="type" value="add_catalog">Catalog追加</button><br>
                                <button type="submit" name="type" value="edit_coordinate">Coordinate編集</button>
                                <button type="submit" name="type" value="edit_catalog">Catalog編集</button><br>
                                <button type="submit" name="type" value="del_coordinate">Coordinate削除</button>
                                <button type="submit" name="type" value="del_catalog">Catalog削除</button><br>
                            </form>
                        </div>
                    <br>
                </div>
            </section>
    <?php
    } else { // IDとパスワードが間違っています
        ?>
        <section id="sec03">
            <div class="inner">
                IDとパスワードが間違っています。
            </div>
        </section>
    <?php
    } // IDとパスワードが間違っています
}
?>
<!-- ログイン検証 -->




<!-- 編集内容の表示 -->
<?php

if ($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['type'])) {
    $type = $_POST['type'];
    if ($type == 'add_coordinate' || $type == 'add_catalog') { // 追加の編集画面-------------------------------------
        if ($type == 'add_coordinate') { // coordinate追加の編集画面表示
            ?>
            <section id="sec01">
                <div class="vision">
                    <h2>Coordinate追加</h2>
                    <form method="post" enctype="multipart/form-data" action="staff.php" class="form2">
                        <label>画像<br>拡張子jpegのみ使用できます</label><br>
                        <input type="file" name="upimage" size="200" required><br><br>
                        <label>説明</label><br>
                        <textarea name="content" rows="20" cols="40" required></textarea><br>
                        <input type="hidden" name="add_type" value="coordinate">
                        <input type="hidden" name="add" value="add">
                        <button type="submit" name="submit">追加</button><br>
                    </form>
                    <br>
                </div>
            </section>
            <?php
            //テーブルからデータを抽出
            $sql = "select path content from catalog";
            $result = mysqli_query($db, $sql);
            // while ($data = mysqli_fetch_array($result))
        } else { // catalog追加の編集画面表示
            ?>
            <section id="sec01">
                <div class="vision">
                    <h2>Catalog追加</h2>
                    <form method="post" enctype="multipart/form-data" action="staff.php" class="form2">
                        <label>画像<br>拡張子jpegのみ使用できます<</label><br>
                        <input type="file" name="upimage" size="200" required><br><br>
                        <label>品名</label><br>
                        <input type="text" name="name" required><br>
                        <label>価格</label><br>
                        <input type="text" name="price" required><br>
                        <select name="category" required>
                            <option value="tops" selected>トップス</option>
                            <option value="pants">パンツ</option>
                            <option value="skirt">スカート</option>
                            <option value="onepiece">ワンピース</option>
                            <option value="jacket">ジャケット・コート</option>
                            <option value="other">その他</option>
                        </select><br>
                        <label>説明</label><br>
                        <textarea name="content" rows="20" cols="40" required></textarea><br>
                        <input type="hidden" name="add_type" value="catalog">
                        <input type="hidden" name="add" value="add">
                        <button type="submit" name="submit">追加</button><br>
                    </form>
                    <br>
                </div>
            </section>
            <?php
        }
    } elseif ($type == 'edit_coordinate' || $type == 'edit_catalog') { // 編集画面---------------------------------------------
        if ($type == 'edit_coordinate') {
            ?>
            <section id="sec03">
                <div class="inner">
                    <ul class="col3">
                        <?php
                        //テーブルからデータを抽出
                        $sql = "select number, content from coordinate";
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
                                <form action="staff.php" method="post">
                                    <input type="hidden" name="edit_num" value="<?php echo $data[0]; ?>">
                                    <div class="center">
                                        <button type="submit" name="edit" value="coordinate">編集</button>
                                    </div>
                                </form>
                            </div>
                        <?php
            } ?>
                    <ul>
                </div>
            </section>
            <?php
        } else {
            ?>
            <section id="sec03">
                <div class="inner">
                    <ul class="col3">
                        <?php
                        //テーブルからデータを抽出
                        $sql = "select number, name, price, category, content from catalog";
            $result = mysqli_query($db, $sql);
            while ($data = mysqli_fetch_array($result)) {
                ?>
                            <br>
                            <div class="form2">
                                <li>
                                    <p><?php echo "カテゴリー : ".$data[3]; ?></p>
                                    <?php print("<img src=\"img_get_catalog.php?number=" . $data[0] . "\">"); ?>
                                </li><br>
                                <li>
                                    <p><?php echo "品名 : ".$data[1]; ?></p>
                                    <p><?php echo "価格 : ".$data[2]; ?></p><br>
                                    <p><?php echo nl2br($data[4]); ?></p>
                                </li><br>
                                <form action="staff.php" method="post">
                                    <input type="hidden" name="edit_num" value="<?php echo $data[0]; ?>">
                                    <div class="center">
                                        <button type="submit" name="edit" value="catalog">編集</button>
                                    </div>
                                </form>
                            </div>
                        <?php
            } ?>
                    <ul>
                </div>
            </section>
            <?php
        }
    } else { // 削除の画面------------------------------------------
        if ($type == 'del_coordinate') {
            ?>
            <section id="sec03">
                <div class="inner">
                    <ul class="col3">
                        <?php
                        //テーブルからデータを抽出
                        $sql = "select number, content from coordinate";
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
                                <form action="staff.php" method="post">
                                    <input type="hidden" name="del_num" value="<?php echo $data[0]; ?>">
                                    <div class="center">
                                        <button type="submit" name="del" value="coordinate">削除</button>
                                    </div>
                                </form>
                            </div>
                        <?php
            } ?>
                    <ul>
                </div>
            </section>
            <?php
        } else {
            ?>
            <section id="sec03">
                <div class="inner">
                    <ul class="col3">
                        <?php
                        //テーブルからデータを抽出
                        $sql = "select number, name, price, category, content from catalog";
            $result = mysqli_query($db, $sql);
            while ($data = mysqli_fetch_array($result)) {
                ?>
                            <br>
                            <div class="form2">
                                <li>
                                    <p><?php echo "カテゴリー : ".$data[3]; ?></p>
                                    <?php print("<img src=\"img_get_catalog.php?number=" . $data[0] . "\">"); ?>
                                </li><br>
                                <li>
                                    <p><?php echo "品名 : ".$data[1]; ?></p>
                                    <p><?php echo "価格 : ".$data[2]; ?></p><br>
                                    <p><?php echo nl2br($data[4]); ?></p>
                                </li><br>
                                <form action="staff.php" method="post">
                                    <input type="hidden" name="del_num" value="<?php echo $data[0]; ?>">
                                    <div class="center">
                                        <button type="submit" name="del" value="catalog">削除</button>
                                    </div>
                                </form>
                            </div>
                        <?php
            } ?>
                    <ul>
                </div>
            </section>
            <?php
        }
    }
}

?>
<!-- 編集内容の表示 -->




<!-- 追加処理------------------------------->
<?php
if ($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['add'])) {
    $type =  $_POST['add_type'];
    
    if ($type == 'coordinate') { // coordinateの追加処理
        $upimage = $_FILES['upimage']['tmp_name'];
        $content = $_POST['content'];
        if ($upimage == "") {
            echo "Cannot upload images";
            exit;
        }

        //ファイル取得
        exec('/usr/bin/exiftool -all= '. $upimage);
        $imgdat = file_get_contents($upimage);
        $imgdat = mysqli_real_escape_string($db, $imgdat);

        //DB接続
        $db = mysqli_connect($server, $user, $pass);
        if (!$db) {
            echo "Cannot connect to MySQL.";
            exit;
        }

        //データベースの作成と接続
        mysqli_query($db, "create database if not exists '".$database."' default character set utf8");
        if (!mysqli_select_db($db, $database)) {
            echo "Cannot connect to database.<br>";
        }

        $sql = "insert into coordinate (img, content) values ('".$imgdat."','".$content."')";

        $result = mysqli_query($db, $sql);
        if (!$result) {
            echo "Cannot execute sql";
            exit;
        } ?>
        <section id="sec01">
            <div class="vision">
                <h2>追加が完了しました</h2>
                <div class="form2">
                    <form action="staff.php" method="post">
                        <input type="hidden" name="id" value="return">
                        <input type="hidden" name="password" value="nopassword">
                        <div class="center">
                            <button type="submit">戻る</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <br>
        <?php
    } else {  // catalogの追加処理
        $upimage = $_FILES['upimage']['tmp_name'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $content = $_POST['content'];
        if ($upimage == "") {
            echo "Cannot upload images";
            exit;
        }

        //ファイル取得
        exec('/usr/bin/exiftool -all= '. $upimage);
        $imgdat = file_get_contents($upimage);
        $imgdat = mysqli_real_escape_string($db, $imgdat);

        //DB接続
        $db = mysqli_connect($server, $user, $pass);
        if (!$db) {
            echo "Cannot connect to MySQL.";
            exit;
        }

        //データベースの作成と接続
        mysqli_query($db, "create database if not exists '".$database."' default character set utf8");
        if (!mysqli_select_db($db, $database)) {
            echo "Cannot connect to database.<br>";
        }

        $sql = "insert into catalog (img, name, price, category, content) values ('".$imgdat."','".$name."','".$price."','".$category."','".$content."')";

        $result = mysqli_query($db, $sql);
        if (!$result) {
            echo "Cannot execute sql";
            exit;
        } ?>
        <section id="sec01">
            <div class="vision">
                <h2>追加が完了しました</h2>
                <div class="form2">
                    <form action="staff.php" method="post">
                        <input type="hidden" name="id" value="return">
                        <input type="hidden" name="password" value="nopassword">
                        <div class="center">
                            <button type="submit">戻る</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <br>
        <?php
    }
}
?>
<!-- 追加処理------------------------------->



<?php
if ($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['del'])) {
    if ($_POST['del'] == 'coordinate') { // coordinateの消去処理-------------------------------
        mysqli_query($db, "delete from coordinate where number='".$_POST['del_num']."'");
    } else { // catalogの消去処理-------------------------------------
        mysqli_query($db, "delete from catalog where number='".$_POST['del_num']."'");
    }
    mysqli_query($db, "delete from coordinate where number=".$_POST['del']); ?>
    <br>
    <section id="sec01">
            <div class="vision">
                <div class="form1">
                    <form action="staff.php" method="post">
                        <input type="hidden" name="id" value="return">
                        <input type="hidden" name="password" value="nopassword">
                        <button type="submit">戻る</button>
                    </form>
                </div>
            </div>
    </section>
    <br>
    <?php
}
?>

<?php
if ($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['edit'])) { //編集処理-------------------------
    if ($_POST['edit'] == 'coordinate') { // coordinateの編集処理-----------------------------
        $sql = "select number, content from coordinate where number=".$_POST['edit_num'];
        $result = mysqli_query($db, $sql);
        while ($data = mysqli_fetch_array($result)) {
            ?>
        <section id="sec01">
            <div class="vision">
                <h2>Coordinate追加</h2>
                <form method="post" action="staff.php" class="form2">
                    <p>イメージは変更できません</p>
                    <?php print("<img src=\"img_get_coordinate.php?number=" . $data[0] . "\">"); ?>
                    <label>説明</label><br>
                    <textarea name="content" rows="20" cols="40" required><?php echo $data[1]; ?></textarea><br>
                    <input type="hidden" name="edit_num" value="<?php echo $data[0]; ?>">
                    <input type="hidden" name="edit_type" value="coordinate">
                    <input type="hidden" name="edit_add" value="edit_add">
                    <button type="submit" name="edit_deal">完了</button><br>
                </form>
                <br>
            </div>
        </section>
        <?php
        }
    } else { // catalogの編集処理--------------------------------------
        $sql = "select number, name, price, category, content from catalog where number=".$_POST['edit_num'];
        $result = mysqli_query($db, $sql);
        while ($data = mysqli_fetch_array($result)) {
            ?>
            <section id="sec01">
                <div class="vision">
                    <h2>Catalog追加</h2>
                    <form method="post"  action="staff.php" class="form2">
                        <p>イメージは変更できません</p>
                        <?php print("<img src=\"img_get_catalog.php?number=" . $data[0] . "\">"); ?>
                        <label>品名</label><br>
                        <input type="text" name="name" value="<?php echo $data[1]; ?>" required><br>
                        <label>価格</label><br>
                        <input type="text" name="price" value="<?php echo $data[2]; ?>" required><br>
                        <select name="category" required>
                            <option value="tops" <?php if ($data[3] == 'tops') {
                echo "selected";
            } ?>>トップス</option>
                            <option value="pants" <?php if ($data[3] == 'pants') {
                echo "selected";
            } ?>>パンツ</option>
                            <option value="skirt" <?php if ($data[3] == 'skirt') {
                echo "selected";
            } ?>>スカート</option>
                            <option value="onepiece" <?php if ($data[3] == 'onepiece') {
                echo "selected";
            } ?>>ワンピース</option>
                            <option value="jacket" <?php if ($data[3] == 'jacket') {
                echo "selected";
            } ?>>ジャケット・コート</option>
                            <option value="other" <?php if ($data[3] == 'other') {
                echo "selected";
            } ?>>その他</option>
                        </select><br>
                        <label>説明</label><br>
                        <textarea name="content" rows="20" cols="40" required><?php echo $data[4]; ?></textarea><br>
                        <input type="hidden" name="edit_num" value="<?php echo $data[0]; ?>">
                        <input type="hidden" name="edit_type" value="catalog">
                        <input type="hidden" name="edit_add" value="edit_add">
                        <button type="submit" name="edit_deal">完了</button><br>
                    </form>
                    <br>
                </div>
            </section>
            <?php
        }
    }
}

if ($_SERVER[REQUEST_METHOD] == 'POST' && isset($_POST['edit_deal'])) { //編集後の追加処理
    if ($_POST['edit_type'] == 'coordinate') {
        $content = $_POST['content'];
        $sql = "update coordinate set content='".$content."' where number=".$_POST['edit_num'];
        $result = mysqli_query($db, $sql); ?>
        <br>
        <section id="sec01">
            <div class="vision">
                <div class="form1">
                    <form action="staff.php" method="post">
                        <input type="hidden" name="id" value="return">
                        <input type="hidden" name="password" value="nopassword">
                        <p>編集が完了しました</p>
                        <button type="submit">戻る</button>
                    </form>
                </div>
            </div>
        </section>
        <br>
        <?php
    } else {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $content = $_POST['content'];
        $sql = "update catalog set name='".$name."', price='".$price."', category='".$category."', content='".$content."' where number=".$_POST['edit_num'];
        $result = mysqli_query($db, $sql); ?>
        <br>
        <section id="sec01">
            <div class="vision">
                <div class="form1">
                    <form action="staff.php" method="post">
                        <input type="hidden" name="id" value="return">
                        <input type="hidden" name="password" value="nopassword">
                        <p>編集が完了しました</p>
                        <button type="submit">戻る</button>
                    </form>
                </div>
            </div>
        </section>
        <br>
        <?php
    }
}
?>

<?php include("footer.php"); ?>