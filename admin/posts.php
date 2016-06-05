<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>公告修改或新增</title>
    <link rel="stylesheet" type="text/css" href="../semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../scripts/jquery-2.2.2.js"></script>
    <script src="../semantic/semantic.js"></script>

    <style>
    </style>
</head>
<body>
<div class="ui container">
    <?php
    include 'navigation.php';
    ?>

    <h1 class="ui teal header">
        公告
        <div class="ui right floated positive button"><a href="new_post.php">新增</a></div>
    </h1>
    <div class="ui items">
        <?php
            include("connect.php");
            $result = $mysqli -> query("select * from posts");
            $total = mysqli_num_rows($result);
            for($i = 0; $i < $total; $i++) {
                $row = mysqli_fetch_row($result);
        ?>
        <div class="item">       
            <div class="ui tiny image">
                <img src="<?php echo "/images.php?id={$row[3]}" ?> " />
            </div>
            <div class="middle aligned content">
                <a class="header">
                    <?php
                            echo $row[1]; 
                    ?>
                </a>
                <div class="extra">
                    <div class="ui right floated buttons">
                        <div class="ui button"><a href="<?php echo "edit_post.php?id=$row[0]" ?>">編輯</a></div>
                        <div class="ui negative button"><a href="<?php echo "delete_post.php?id=$row[0]" ?>">刪除</a></div>
                    </div>
                </div>
            </div> 
        </div>
        <?php
            }
            include("close.php");
        ?>
    </div>
</div>
</body>
</html>