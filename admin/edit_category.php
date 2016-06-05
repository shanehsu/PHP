<?php
include("connect.php");

if (isset($_GET['id']))
{
        $result = $mysqli -> query("select * from categories where id = " . intval($_GET['id']));
        $row = mysqli_fetch_row($result);        
        $id = intval($_GET['id']);

}


    if (isset($_POST['name'])) 
    {
        $sql ="update categories set name =".$_POST['name']."  where id = $id";
        if (mysqli_query($mysqli, $sql)) 
        {
            header('Location: categories.php');
        } 
        else 
        {
            echo "無法修改。";
            echo mysqli_error($mysqli);
        }
    }





include("close.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nameless Apps 收支管理系統</title>
    <link rel="stylesheet" type="text/css" href="../semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../scripts/jquery-2.2.2.js"></script>
    <script src="../semantic/semantic.js"></script>

    <script>

    </script>

    <style>

    </style>
</head>
<body>
<div class="ui container">
    <!-- 選單 -->
    <?php
    include 'navigation.php';
    ?>

    <!-- 標題 -->
    <h1 class="ui teal header">
        分類
    </h1>

    <form style="max-width: 30em; margin: 0 auto;" class="ui form" action="edit_post.php?id" method="POST">
        <div class="field">
            <label>類別名稱</label>
            <input type="text" name="name" placeholder="類別名稱">
        </div>
        <button  class="ui button" type="submit">更新</button>
    </form>
</div>
</body>
</html>