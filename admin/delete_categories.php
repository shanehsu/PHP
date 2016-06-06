<?php
	include("./../util/connect.php");
	 if (isset($_GET['id']))
        {
        	$sql ="delete from categories where id=".intval($_GET['id']);  //刪除資料
        }
       mysqli_query($mysqli, $sql);
       header( "location:categories.php"); 
	include("./../util/close.php");
?>