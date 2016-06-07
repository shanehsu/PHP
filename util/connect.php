<?php
// $mysqli = new mysqli("php.caituglxwkil.ap-northeast-1.rds.amazonaws.com","root","12345678","group_12");
$mysqli = new mysqli("127.0.0.1", "root", "12345678", "group_12");

$mysqli -> query("SET CHARACTER SET utf8");
$mysqli -> query("SET collation_connection = 'utf8_unicode_ci'");

if ($mysqli -> connect_errno) {
	die("資料庫連線失敗");
}

?>