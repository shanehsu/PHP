<?php
include "AdminAuthenticationRequired.php";
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
        <?php
            include("./../util/connect.php");
            $result = $mysqli -> query("select * from images");
            $total = mysqli_num_rows($result);
            for($i = 0; $i < $total; $i++) {
                $row = mysqli_fetch_row($result);
        ?>
        <tr>
            <td style="text-align: center;">
                <?php
                    echo $row[0];
                ?>
            </td>
            <td>
                <img style="max-height: 6em; max-width: 6em;" src="<?php echo "/images.php?id={$row[0]}" ?>">
            </td>
            <td class="single line">
                <?php
                    echo $row[1];
                ?>
            </td>
            <td>
                <?php
                    echo $row[2];
                ?>
            </td>
            <td class="center aligned">
                <a href="<?php echo "statics_delete.php?id=$row[0]" ?>">刪除</a>
            </td>
        </tr>
        <?php
            }
            include("./../util/close.php");
        ?>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th class="right aligned" colspan="5">
                <a href="statics_new.php">上傳</a>
            </th>
        </tr>
        </tfoot>
    </table>

</div>
</body>
</html>

<!-- 用 http://php.net/manual/en/function.uniqid.php 生成亂數檔案名稱 -->