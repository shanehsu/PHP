<?php
include "util/UserAuthenticationRequired.php";
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
</head>

<body>
<div class="ui container">
    <?php
    include 'navigation.php';
    ?>

    <?php
    include "util/connect.php";

    $receipt_stmt = $mysqli->prepare('SELECT receipt.id, member.name, receipt.recipient, receipt.shipping_address, receipt.ordered, receipt.paid,
        SUM(receipt_item.item_price * receipt_item.quantity) 
        FROM group_12.receipt, group_12.receipt_item, group_12.member
        WHERE receipt_item.receipt = receipt.id AND member.id = receipt.member AND receipt.member = ? AND receipt.id = ?
        GROUP BY receipt.id');

    $getid = intval($_GET['id']);
    $receipt_stmt->bind_param('dd', $uid, $getid);
    $receipt_stmt->bind_result($rid, $rname, $rrcve, $raddr, $rdate, $rpaid, $rsum);
    $receipt_stmt->execute();
    $receipt_stmt->fetch();
    $receipt_stmt->close();

    include "util/close.php";
    ?>

    <div class="ui breadcrumb">
        <a href="member.php" class="section">會員中心</a>
        <span class="divider">/</span>
        <div class="active section">訂單資訊</div>
    </div>

    <h1 class="ui header">訂單編號 #<?= $rid ?></h1>
    <div class="ui very padded segment">
        <h2 class="ui header">訂單資訊</h2>
        <div class="ui two column grid">
            <div class="column">
                <table class="ui definition table">
                    <tbody>
                    <tr>
                        <td class="three wide column">訂購人</td>
                        <td><?= $rname ?></td>
                    </tr>
                    <tr>
                        <td>訂購時間</td>
                        <td><?= $rdate ?></td>
                    </tr>
                    <tr>
                        <td>總金額</td>
                        <td>$ <?= $rsum ?></td>
                    </tr>
                    <tr>
                        <td>付款狀況</td>
                        <td><?php echo $rpaid == 1 ? "已付款" : "未付款" ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="column">
                <table class="ui definition table">
                    <tbody>
                    <tr>
                        <td class="three wide column">收貨人</td>
                        <td><?= $rrcve ?></td>
                    </tr>
                    <tr>
                        <td>送貨地址</td>
                        <td><?= $raddr ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="ui very padded segment">
        <h2 class="ui header">商品資訊</h2>
        <table class="ui very basic celled table">
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
        include "util/connect.php";

        $receipt_stmt = $mysqli->prepare('SELECT receipt_item.item_name, receipt_item.item_price, receipt_item.quantity, receipt_item.item_price * receipt_item.quantity
            FROM group_12.receipt, group_12.receipt_item
            WHERE receipt_item.receipt = receipt.id AND receipt.member = ? AND receipt.id = ?');

        $getid = intval($_GET['id']);
        $receipt_stmt->bind_param('dd', $uid, $getid);
        $receipt_stmt->bind_result($iname, $iprice, $iquantity, $isubtotal);
        $receipt_stmt->execute();

        while ($receipt_stmt->fetch()) {
            ?>

            <tr>
                <td><?= $iname ?></td>
                <td>$ <?= $iprice ?></td>
                <td><?= $iquantity ?></td>
                <td>$ <?= $isubtotal ?></td>
            </tr>

            <?php
        }
        $receipt_stmt->close();

        include "util/close.php";
        ?>
        </tbody>
        </table>
    </div>
</div>

<?php
include 'modals.php';
?>

</body>

</html>