<?php
include 'util/UserAuthenticationRequired.php';
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
        $(function() {
            $('.ui.form').form({
                fields: {
                    shipping_address: 'empty',
                    recipient: 'empty'
                }
            })
        })
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

    $stmt = $mysqli -> prepare('SELECT item, name, thumbnail, quantity, price
              FROM group_12.cart, group_12.products
              WHERE products.id = item AND cart.member = ?');

    $stmt -> bind_param('d', $uid);
    $stmt -> bind_result($iid, $iname, $iimage, $quantity, $price);
    $stmt -> execute();

    $result = array();
    $total = 0;
    while ($stmt -> fetch()) {
        $result[] = array(
            'itemName' => $iname,
            'itemPrice' => $price,
            'quantity' => $quantity,
            'subtotal' => $price * $quantity
        );
        $total += $price * $quantity;
    }

    $stmt -> close();

    include 'util/close.php';
    ?>
    <div class="ui stacked very padded teal segment">
        <h2 class="ui teal header">購買項目</h2>
        <table class="ui tablet stackable table">
            <thead>
            <tr>
                <th>品項</th>
                <th>單價</th>
                <th>數量</th>
                <th>總價</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($result as $r) {
                ?>
                <tr>
                    <td><?=$r['itemName']?></td>
                    <td>
                        <span><?=$r['itemPrice']?></span>
                    </td>
                    <td>
                        <span><?=$r['quantity']?></span>
                    </td>
                    <td>
                        $
                        <span><?=$r['subtotal']?></span>
                    </td>
                </tr>
                <?php
            }
            ?>

            </tbody>
            <tfoot class="full-width right aligned">
                <tr>
                    <th colspan="4">
                        <h4 style="display: inline-block; margin: 0; padding-right: 1em;" class="ui teal header">總金額</h4>
                        $ <span><?=$total?></span>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="ui very padded red segment">
        <h2 class="ui red header">送貨地址</h2>
        <form action="confirm_checkout.php" method="POST" class="ui form">
            <div class="field">
                <label>收貨人</label>
                <input type="text" name="recipient" placeholder="收貨人全名">
            </div>
            <div class="field">
                <label>送貨地址</label>
                <input type="text" name="shipping_address" placeholder="">
            </div>
            <button type="submit" class="ui green right floated button" <?php echo $total == 0 ? 'disabled' : '' ?>>確認訂購</button>
            <br/>
            <br/>
            <div class="ui error message"></div>
        </form>
    </div>

    <div class="ui fluid steps">
        <div class="active step">
            <i class="truck icon"></i>
            <div class="content">
                <div class="title">送貨地址</div>
                <div class="description">輸入送貨地址以及收貨人</div>
            </div>
        </div>
        <div class="disabled step">
            <i class="checkmark icon"></i>
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