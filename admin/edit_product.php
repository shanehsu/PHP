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
        產品
    </h1>
    
    <table class="ui celled padded table">
        <thead>
        <tr>
            <th>ID</th>
            <th>縮圖</th>
            <th>名稱</th>
            <th>販售方式</th>
            <th>敘述</th>
            <th>分類</th>
            <th>動作</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td style="text-align: center;">
                1
            </td>
            <td>
                <img style="max-height: 6em; max-width: 6em;" src="/images.php?id=1">
            </td>
            <td class="single line">
                美國香蕉
            </td>
            <
            <td>
                5 個 $1000
            </td>
            <td>
                從台灣進口至美國的香蕉，經過美國軍方嚴密的檢查，保證不包含任何農藥。
            </td>
            <td>
                美國
            </td>
            <td class="center aligned">
                <a>編輯</a>
                <a>刪除</a>
            </td>
        </tr>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th class="right aligned" colspan="7">
                <a>新增產品</a>
            </th>
        </tr>
        </tfoot>
    </table>
</div>
</body>
</html>
