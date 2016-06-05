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
        靜態文件
    </h1>

    <!-- 內容 -->
    <form class="ui form" style="max-width: 20em; margin: 0 auto;">
        <div class="field">
            <label>檔案</label>
            <!-- 檢查副檔名是否為 .jpg 或 .jpeg -->
            <input type="file">
        </div>
        <div class="ui positive button" tabindex="0">上傳</div>
    </form>

</div>
</body>
</html>