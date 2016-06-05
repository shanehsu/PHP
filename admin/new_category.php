<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    include("connect.php");
            $result = $mysqli -> query("select * from posts");
            $total = mysqli_num_rows($result);
            $new_id = $total + 1;
    
    if (isset($_POST['name'])) 
    {
        $sql="insert into categories (id, name ,parent) values ('" . $new_id . "','" . $_POST['name']. "','" . $parent"')";
        if (mysqli_query($mysqli, $sql)) {
            header('Location: categories.php');
    } 
    else 
    {
            echo "無法新增。";
            echo mysqli_error($mysqli);
    }
        
    include("close.php");
}


else
{
    include("connect.php");

     if (isset($_GET['id']))
        {
            $parent =  intval($_GET['id']);  //紀錄parent
        }

    
     
    include("close.php");


}
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

    <form style="max-width: 30em; margin: 0 auto;" class="ui form" action="new_category.php" method="POST">
        <div class="field">
            <label>類別名稱</label>
            <input type="text" name="name" placeholder="類別名稱">
        </div>
        <button  class="ui button" type="submit">新增</button>
    </form>
</div>
</body>
</html>