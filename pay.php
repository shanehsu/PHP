<?php
include 'util/UserAuthenticationRequired.php';
?>

<?php
/**
 * Created by PhpStorm.
 * User: Shane
 * Date: 2016/6/7
 * Time: 上午8:15
 */
$receipt = intval($_GET['id']);
if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    include 'util/connect.php';
    $stmt = $mysqli->prepare('UPDATE group_12.receipt SET paid = 1 WHERE id = ?');
    $stmt->bind_param('d', $receipt);
    $stmt->execute();
    $stmt->close();
    $pay = true;
    include 'util/close.php';
}

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
        div.grid {
            height: 100%;
        }

        .column {
            max-width: 450px;
        }
    </style>
</head>

<body>

<div class="ui container">
    <?php
    include 'navigation.php';
    ?>
    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <?php
            if (isset($pay) && $pay) {
                ?>
                <div class="ui very padded green segment">
                    <h2 class="ui icon header">
                        <i class="green checkmark icon"></i>
                        <div class="content">
                            已成功付款
                        </div>
                    </h2>
                    <p>請回到<a href="/index.php">首頁</a></p>
                </div>
                <?php
            } else {
                ?>
                <div class="ui very padded red segment">
                    <h2 class="ui red header">付款</h2>
                    <form action="pay.php?id=<?= $receipt ?>" method="POST" class="ui form">
                        <button type="submit" class="ui red basic fluid button">確認付款</button>
                    </form>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<?php
include 'modals.php';
?>
</body>

</html>