<?php
include 'util/UserAuthenticationRequired.php';
?>

<?php
$shipping = $_POST['shipping_address'];
$recv = $_POST['recipient'];


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>阿寯的美食天地</title>
    <link rel="stylesheet" type="text/css" href="semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="styles/glide.core.css">
    <link rel="stylesheet" type="text/css" href="styles/glide.theme.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="scripts/jquery-2.2.2.js"></script>
    <script src="semantic/semantic.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/glide.js"></script>

    <script>
    </script>
    <style>

    </style>
</head>

<body>
<div class="ui container">
    <?php
    include 'navigation.php';
    ?>
    
    <?php
    include 'util/connect.php';
    // 建立新的 Receipt
    
    $stmt = $mysqli -> prepare('INSERT INTO group_12.receipt(member, recipient, shipping_address) VALUES (?, ?, ?)');
    $stmt -> bind_param('dss', $uid, $recv, $shipping);
    $stmt -> execute();
    $receiptID = $stmt -> insert_id;
    $stmt -> close();

    // 丟購物車的東西進去！
    $stmt = $mysqli -> prepare('INSERT INTO group_12.receipt_item (receipt, item_name, item_price, quantity)
      SELECT ?, products.name, products.price, quantity FROM group_12.products, group_12.cart
      WHERE cart.item = products.id AND cart.member = ?');

    $stmt -> bind_param('dd', $receiptID, $uid);
    $stmt -> execute();
    $stmt -> close();

    // 刪除購物車裡面的
    $stmt = $mysqli -> prepare('DELETE FROM group_12.cart WHERE member = ?');
    $stmt -> bind_param('d', $uid);
    $stmt -> execute();
    $stmt -> close();

    include 'util/close.php';
    ?>

    <div class="ui stacked very padded green segment">
        <h2 class="ui green header">購買項目</h2>
        <div class="ui green icon message">
            <i class="grey checkmark icon"></i>
            <div class="content">
                <div class="header">
                    訂購成功！
                </div>
                <p>你已經成功的訂購我們的產品，你可以選擇立即付款！</p>
            </div>
        </div>
    </div>

    <div class="ui very padded red segment">
        <h2 class="ui red header">付款</h2>
        <form action="pay.php?id=<?=$receiptID?>" method="POST" class="ui form">
            <button type="submit" class="ui red basic fluid button">確認付款</button>
        </form>
    </div>

    <div class="ui fluid steps">
        <div class="step">
            <i class="blue truck icon"></i>
            <div class="content">
                <div class="title">送貨地址</div>
                <div class="description">輸入送貨地址以及收貨人</div>
            </div>
        </div>
        <div class="active step">
            <i class="green checkmark icon"></i>
            <div class="content">
                <div class="title">完成</div>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include 'modals.php';
?>
</body>

</html>