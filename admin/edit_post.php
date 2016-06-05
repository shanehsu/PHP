<?php
    include("connect.php");
    /*if($_SERVER['REQUEST_METHOD'] == 'POST'){

    }*/
    if (isset($_GET['id'])){
        $result = $mysqli -> query("select * from posts where id = " . intval($_GET['id']));
        $row = mysqli_fetch_row($result);        
        $id = intval($_GET['id']);
    }

    if (isset($_POST['title'])) {
        $sql ="update posts set title=".$_POST['title'].",related_product=".$_POST['related_product']."  where id = $id";
        if (mysqli_query($mysqli, $sql)) {
            header('Location: posts.php');
        } else {
            echo "無法修改。";
            echo mysqli_error($mysqli);
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>編輯公告</title>
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
        編輯公告
    </h1>
    <form class="ui form" action="edit_post.php?id=<?php echo $id; ?>" method="POST">
        <div class="field">
            <label>公告內容</label>
            <input type="text" name="title" value="<?=$row[1]?>" >
        </div>
        <div class="field">
            <label>相關產品 ID</label>
            <input type="text" name="related_product" value="<?=$row[3]?>" >
        </div>
        <button class="ui button" type="submit">編輯</button>
        <?php
            include("close.php");
        ?>
    </form>
</div>
</body>
</html>