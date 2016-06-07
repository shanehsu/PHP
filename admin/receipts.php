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
    <script src="../scripts/jquery.tablesort.js"></script>
    <script src="../semantic/semantic.js"></script>

    <script>
        $(function() {
            $('table').tablesort()
        })
    </script>
</head>
<body>
<div class="ui container">
    <!-- 選單 -->
    <?php
    include 'navigation.php';
    ?>

    <!-- 標題 -->
    <h1 class="ui teal header">
        訂單
    </h1>

    <?php
    include './../util/connect.php';
    ?>

    <?php
    // 取得會員列表

    $stmt = $mysqli->prepare('SELECT receipt.id, receipt.ordered, receipt.paid, member.username, member.name,
        SUM(receipt_item.item_price * receipt_item.quantity)
        FROM group_12.receipt, group_12.receipt_item, group_12.member
        WHERE receipt_item.receipt = receipt.id AND member.id = receipt.member
        GROUP BY receipt.id');
    $stmt->bind_result($rid, $rdate, $rpaid, $rusername, $rname, $rsum);
    $stmt->execute();
    ?>

    <table class="ui celled padded table">
        <thead>
        <tr>
            <th>ID</th>
            <th>訂購日期</th>
            <th>使用者名稱</th>
            <th>名字</th>
            <th>總金額</th>
            <th>付款狀況</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($stmt->fetch()) {
            ?>
            <tr>
                <td><?=$rid?></td>
                <td><?=$rdate?></td>
                <td><?=$rusername?></td>
                <td><?=$rname?></td>
                <td>$ <?=$rsum?></td>
                <td class="<?php echo $rpaid == 1 ? "" : "warning"; ?>"><?php echo $rpaid == 1 ? "已付款" : "未付款"; ?></td>
            </tr>
            <?php
        }
        $stmt -> close();
        ?>
        </tbody>
    </table>


    <?php
    include './../util/close.php';
    ?>
</div>
</body>
</html>
