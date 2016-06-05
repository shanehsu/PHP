<?php
	include("connect.php");
	 if (isset($_GET['id']))
        {
        	$result = $mysqli -> query("select * from images where id = " . intval($_GET['id']));
            $row = mysqli_fetch_row($result);
            unlink(".../images/".$row[2]);
        	$sql ="delete from images where id=".intval($_GET['id']);  //刪除資料
        }
		if (mysqli_query($mysqli, $sql)) {
            header('Location: statics.php');
        } else {
            echo "無法修改。";
            echo mysqli_error($mysqli);
        }
	include("close.php");
?>