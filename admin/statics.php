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
        <!--                                                                  新的頂層類別不會有 ?id=xx -->
        <div class="ui right floated positive button" onclick="add_new('new')">新增</div>
    </h1>

    <!-- 內容 -->
    <table class="ui celled padded table">
        <thead>
            <tr>
                <th>ID</th>
                <th>圖片</th>
                <th>原始檔名</th>
                <th>伺服器檔名</th>
                <th>動作</th>
            </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: center;">
                <p>1</p>
            </td>
            <td>
                <img style="max-height: 6em; max-width: 6em;" src="/images.php?id=1">
            </td>
            <td class="single line">
                <p>高麗菜.jpg</p>
            </td>
            <td>
                <p>ksl329cns8.jpg</p>
            </td>
            <td class="center aligned">
                <a>刪除</a>
            </td>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th class="right aligned" colspan="5">
                <a>上傳</a>
            </th>
        </tr>
        </tfoot>
    </table>

</div>
</body>
</html>

<!-- 用 http://php.net/manual/en/function.uniqid.php 生成亂數檔案名稱 -->