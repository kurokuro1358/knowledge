<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta name="description" content="ブティック　Gather">
	<meta name="viewport" content="width=device-width">
	<title>ブティック　Gather</title>
	<link rel="stylesheet" media="all" href="css/style.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
	<script src="js/script.js"></script>
</head>

<body>
	
	<nav id="mainnav">
		<p id="menuWrap"><a id="menu"><span id="menuBtn"></span></a></p>
		<div class="panel">
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="coordinate.php">Coordinate</a></li>
				<li><a href="catalog.php">Catalog</a></li>
				<li><a href="staff.php">ページ管理</a></li>
			</ul>
		</div>
	</nav>
	
	<header id="header">
		<img src="image/image4.jpg" alt="">
		<div id="slogan">
			<h1>ブティック　Gather</h1>
			<h2>Online Shop</h2>
		</div>
	</header>

	<?php
	include("template.php");
	// setMySQL("mysql1.php.xdomain.ne.jp", "gather8980_gest", "Kingu822"); // server, user, password
	// setDatabase("gather8980_gather"); // database
	
	?>
	