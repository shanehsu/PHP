<?php
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    // 修改！
    include './../util/connect.php';

    $stmt = $mysqli -> prepare('UPDATE products SET name = ?, sell_quantity = ?, price = ?, description = ?, detail = ?, thumbnail = ?, categories = ? WHERE id = ?');
    $id = intval($_GET['id']);
    $name = $_POST['name'];
    $sell_quantity = $_POST['sell_quantity'];
    $price = intval($_POST['price']);
    $description = $_POST['description'];
    $detail = $_POST['detail'];
    $thumbnail = intval($_POST['thumbnail']);
    $categories = intval($_POST['category']);

    $stmt -> bind_param('ssdsssdd', $name, $sell_quantity, $price, $description, $detail, $thumbnail, $categories, $id);

    if ($stmt -> execute()) {
        header('Location: products.php');
    } else {
        ?>
        <script>
            alert('修改失敗！');
        </script>
        <?php
    }

    include './../util/close.php';
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nameless Apps 收支管 理系統</title>
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

    <?php
    include './../util/connect.php';
    ?>

    <?php
    // 取得該產品
    $statement = $mysqli -> prepare('SELECT id, name, sell_quantity, price, description, detail, thumbnail, categories FROM products WHERE id = ?');
    $getID = intval($_GET['id']);
    $statement -> bind_param('d', $getID);
    $statement -> bind_result($id, $name, $sell_quantity, $price, $description, $detail, $thumbnail, $categories);
    $statement -> execute();
    $statement -> fetch();
    ?>

    <form class="ui form" method="POST">
        <div class="field">
            <label>產品名稱</label>
            <input type="text" name="name" value="<?php echo $name; ?>"/>
        </div>
        <div class="field">
            <label>販售單位</label>
            <input type="text" name="sell_quantity" value="<?php echo $sell_quantity; ?>"/>
        </div>
        <div class="field">
            <label>販售價格</label>
            <input type="number" name="price" value="<?php echo $price; ?>"/>
        </div>
        <div class="field">
            <label>簡單敘述</label>
            <input name="description" value="<?php echo $description; ?>"/>
        </div>
        <div class="field">
            <label>產品說明</label>
            <textarea name="detail"><?php echo $detail; ?></textarea>
        </div>
        <div class="field">
            <label>縮圖 ID</label>
            <input name="thumbnail" value="<?php echo $thumbnail; ?>"/>
        </div>
        <div class="field">
            <label>分類</label>
            <input type="number" name="category" value="<?php echo $categories; ?>"/>
        </div>

        <button type="submit" class="ui blue basic button">送出</button>
    </form>

    <?php
    include './../util/close.php';
    ?>
</div>
</body>
</html>