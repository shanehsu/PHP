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

    <?php
    include './../util/connect.php';
    ?>

    <?php
    // 取得產品列表

    $stmt = $mysqli->prepare('SELECT id, name FROM categories');
    $stmt->bind_result($catID, $catName);
    $stmt->execute();

    $categories = array();
    while ($stmt -> fetch()) {
        $categories[$catID] = $catName;
    }
    $stmt -> close();
    ?>

    <?php
    // 取得產品列表

    $stmt = $mysqli->prepare('SELECT id, thumbnail, name, sell_quantity, price, description, categories FROM products');
    $stmt->bind_result($id, $thumbnail, $name, $sell_quantity, $price, $desc, $cat);
    $stmt->execute();
    ?>

    <table class="ui celled padded table">
        <thead>
        <tr>
            <th>ID</th>
            <th>縮圖</th>
            <th style="min-width: 8em;">名稱</th>
            <th style="min-width: 10em;">販售方式</th>
            <th>敘述</th>
            <th style="min-width: 5em;">分類</th>
            <th style="min-width: 5em;">動作</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($stmt->fetch()) {
            ?>
            <tr>
                <td style="text-align: center;">
                    <?php echo $id; ?>
                </td>
                <td>
                    <img style="max-height: 6em; max-width: 6em;" src="/images.php?id=<?php echo $thumbnail; ?>"/>
                </td>
                <td class="single line">
                    <?php echo $name; ?>
                </td>
                <td>
                    <?php echo $sell_quantity; ?> $<?php echo $price; ?>
                </td>
                <td>
                    <?php echo $desc; ?>
                </td>
                <td>
                    <?php echo $categories[$cat]; ?>
                </td>
                <td class="center aligned">
                    <a href="product_edit.php?id=<?php echo $id; ?>">編輯</a>
                    <a href="product_delete.php?id=<?php echo $id; ?>">刪除</a>
                </td>
            </tr>
            <?php
        }
        $stmt -> close();
        ?>
        </tbody>
        <tfoot class="full-width">
        <tr>
            <th class="right aligned" colspan="7">
                <a href="product_new.php">新增產品</a>
            </th>
        </tr>
        </tfoot>
    </table>


    <?php
    include './../util/close.php';
    ?>
</div>
</body>
</html>
