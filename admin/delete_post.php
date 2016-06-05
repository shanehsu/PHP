<?php
	include("connect.php");
	 if (isset($_GET['id']))
        {
        	$sql ="delete from posts where id=".intval($_GET['id']);  //刪除資料
        }
       mysqli_query($mysqli, $sql);
       header( "location:posts.php"); 
	include("close.php");
?>