<?php
include "AdminAuthenticationRequired.php";
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("./../util/connect.php");
    // date_default_timezone_set('Asia/Taipei');
    if (isset($_POST['title'])) {
        if ($_POST['related_product']) {
            $sql="insert into posts (title, related_product) values ('" . $_POST['title'] . "','" . $_POST['related_product']. "')";
        } else {
            $sql="insert into posts (title, related_product) values ('" . $_POST['title'] . "', NULL)";
        }

        if (mysqli_query($mysqli, $sql)) {
            header('Location: posts.php');
        } else {
            echo "無法新增。";
            echo mysqli_error($mysqli);
        }
        // echo mysqli_error($mysqli);
    }
    include("./../util/close.php");
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

    <style>
    </style>
</head>
<body>
<div class="ui container">
    <div class="ui seven item menu">
        <a class="active item">公告</a>
        <a class="item">靜態圖片</a>
        <a class="item">首頁輪播</a>
        <a class="item">分類</a>
        <a class="item">產品</a>
        <a class="item">會員</a>
        <a class="item">管理者</a>
    </div>
    <h1 class="ui teal header">
        新增公告
    </h1>
    <form class="ui form" action="post_new.php" method="POST">
        <div class="field">
            <label>公告內容</label>
            <input type="text" name="title" placeholder="公告內容">
        </div>
        <div class="field">
            <label>相關產品 ID</label>
            <input type="text" name="related_product" placeholder="1">
        </div>
        <button class="ui button" type="submit">新增</button>
    </form>
</div>
</body>
</html>