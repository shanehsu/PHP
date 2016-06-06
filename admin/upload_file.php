<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include("connect.php");

        $type = $_FILES['imageFile']['type'];

        if ($type == "image/jpeg") {
            $original=$_FILES['imageFile']['name'];
            $filename=substr(uniqid(), -3).".jpg";        
            $temp=$_FILES['imageFile']['tmp_name'];
            move_uploaded_file($_FILES["imageFile"]["tmp_name"],"./../images/" . $filename);

            $sql="insert into images (original, filename) values ('$original','$filename')";

            if (mysqli_query($mysqli, $sql)) {
                header('Location: statics.php');
            } else {
                ?>
                <script>
                    alert('無法新增！');
                    window.location.assign('statics.php')
                </script>
                <?php
            }
        }

        include("close.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>上傳圖檔</title>
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
        靜態文件
    </h1>

    <!-- 內容 -->
    <form class="ui form" style="max-width: 20em; margin: 0 auto;" action="upload_file.php" method="POST" enctype="multipart/form-data">
        <div class="field">
            <label>檔案</label>
            <!-- 檢查副檔名是否為 .jpg 或 .jpeg -->
            <input type="file" name="imageFile">
            <input type='hidden' name='MAX_FILE_SIZE' value='1024000'> 
        </div>
        <button class="ui positive button" tabindex="0" type="submit">上傳</button>
    </form>
</div>
</body>
</html>