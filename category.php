<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>阿寯的美食天地</title>
    <link rel="stylesheet" type="text/css" href="semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="scripts/jquery-2.2.2.js"></script>
    <script src="semantic/semantic.js"></script>
    <script src="scripts/script.js"></script>
</head>
<body>
<div class="ui container" style="padding-bottom: 2rem;">
    <?php
    include 'navigation.php';
    ?>
    <br>
    <div class="ui grid">
        <div class="three wide column">
            <?php
            include 'util/flat_menu.php';
            ?>
        </div>
        <div class="thirteen wide column">
            <?php
            include("util/connect.php");

            $current_cid = intval($_GET['id']);
            $current_name = "";
            $traversal = []; // 從空陣列開始
            while (true) {
                $stmt = $mysqli->prepare('SELECT id, name, parent FROM group_12.categories WHERE id = ?');
                $stmt->bind_param('d', $current_cid);
                $stmt->bind_result($cid, $cname, $cparent);
                $stmt->execute();
                $stmt->fetch();

                if ($current_name == "") $current_name = $cname;

                // 儲存到陣列
                array_unshift($traversal, [
                    'id' => $cid,
                    'name' => $cname
                ]);

                if (is_null($cparent)) {
                    break;
                } else {
                    $current_cid = $cparent;
                }
                $stmt->close();
            }

            include("util/close.php");
            ?>

            <h2 class="ui grey header">
                <?= $current_name ?>
            </h2>
            <div class="ui breadcrumb" style="padding-bottom: 2em; ">

                <?php
                $length = count($traversal);

                for ($i = 0; $i < $length - 1; $i++) {
                    ?>
                    <span class="section"><?= $traversal[$i]['name'] ?></span>
                    <i class="right angle icon divider"></i>
                    <?php
                }
                ?>

                <div class="active section"><?= $traversal[$length - 1]['name'] ?></div>
            </div>

            <div class="ui four doubling cards">
                <?php

                // 將使用者已經加入購物車的東西
                include("util/connect.php");
                $stmtc = $mysqli->prepare('SELECT GROUP_CONCAT(item) FROM group_12.cart WHERE member = ?');
                $stmtc->bind_param('d', $uid);
                $stmtc->bind_result($result);
                $stmtc->execute();
                $stmtc->fetch();

                $bought_str = explode(',', $result);
                $bought = [];
                foreach ($bought_str as $bought_str_item) {
                    $bought[] = intval($bought_str_item);
                }
                $stmtc->close();

                // 抓取該分類下面的產品
                $cid = intval($_GET['id']);
                $stmtp = $mysqli -> prepare('SELECT id, name, sell_quantity, price, description, thumbnail, rating FROM group_12.products WHERE categories = ?');
                $stmtp -> bind_param('d', $cid);
                $stmtp -> bind_result($pid, $pname, $psq, $pprice, $pdescription, $pthumb, $prating);
                $stmtp -> execute();

                $products = [];

                while ($stmtp -> fetch()) {
                    $products[] = [
                        'id' => $pid,
                        'name' => $pname,
                        'quantity' => $psq,
                        'price' => $pprice,
                        'description' => $pdescription,
                        'thumbnail' => "images.php?id={$pthumb}",
                        'rating' => $prating
                    ];
                }

                $stmtp -> close();

                foreach ($products as $product) {
                    // 產品是否在購物車中
                    $inCart = in_array($product['id'], $bought);
                    ?>
                    <div class="card" data-pid="<?= $product['id'] ?>">
                        <div class="image">
                            <img src="<?= $product['thumbnail']?>"/>
                        </div>
                        <div class="content">
                            <a class="header" href="product.php?id=<?= $product['id'] ?>">
                                <?= $product['name'] ?>
                            </a>
                            <div class="meta">
                                $ <?= $product['price'] ?>
                                <span class="price quantity separator"></span>
                                <?= $product['quantity'] ?>
                            </div>
                            <div class="description">
                                <span class="text">
                                <?= $product['description'] ?>
                                </span>
                            </div>
                        </div>
                        <div class="extra content">
                            <div class="rating">
                                <div class="ui star rating" data-rating="<?= $product['rating'] ?>"
                                     data-max-rating="5"></div>
                            </div>
                        </div>
                        <div class="extra content">
                            <?php
                            $stmtr = $mysqli -> prepare('SELECT SUM(quantity) 
                                FROM group_12.receipt, group_12.receipt_item, group_12.products
                                WHERE products.id = ? AND products.id = receipt_item.item_id AND receipt.id = receipt_item.receipt
                                AND receipt.ordered >= DATE_ADD(CURDATE(), INTERVAL -3 DAY)');
                            $stmtr -> bind_param('d', $product['id']);
                            $stmtr -> bind_result($recent);
                            $stmtr -> execute();
                            $stmtr -> fetch();
                            $stmtr -> close();

                            if (is_null($recent)) {
                                $recent = 0;
                            }
                            ?>
                            <div class="recent">
                                <i class="users icon"></i>
                                近三天內有 <?=$recent?> 人購買
                            </div>
                        </div>
                        <?php
                        if ($authenticated) {
                            ?>
                            <div class="cart-button <?php echo $inCart ? 'purchased' : '' ?>">
                                <div class="added to cart ui bottom attached green button">
                                    <i class="checkmark icon"></i>
                                    在購物車內
                                </div>
                                <div onclick="addToCart(<?= $product['id'] ?>)"
                                     class="ui bottom attached blue add to cart button">
                                    <i class="add icon"></i>
                                    加入購物車
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                include("util/close.php");
                ?>
            </div>
        </div>

    </div>
</div>
<?php
include 'modals.php';
?>
</body>
</html>
