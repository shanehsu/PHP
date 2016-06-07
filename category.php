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
                $stmt = $mysqli -> prepare('SELECT id, name, parent FROM group_12.categories WHERE id = ?');
                $stmt -> bind_param('d', $current_cid);
                $stmt -> bind_result($cid, $cname, $cparent);
                $stmt -> execute();
                $stmt -> fetch();

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
                $stmt -> close();
            }

            include("util/close.php");
            ?>

            <h2 class="ui grey header">
                <?=$current_name?>
            </h2>
            <div class="ui breadcrumb" style="padding-bottom: 2em; ">

                <?php
                $length = count($traversal);

                for ($i = 0; $i < $length - 1; $i ++) {
                    ?>
                    <a class="section"><?=$traversal[$i]['name']?></a>
                    <i class="right angle icon divider"></i>
                    <?php
                }
                ?>

                <div class="active section"><?=$traversal[$length - 1]['name']?></div>
            </div>

            <div class="ui four doubling cards">
                <?php
                include("util/connect.php");
                $stmtc = $mysqli -> prepare('SELECT GROUP_CONCAT(item) FROM group_12.cart WHERE member = ?');
                $stmtc -> bind_param('d', $uid);
                $stmtc -> bind_result($result);
                $stmtc -> execute();
                $stmtc -> fetch();

                $bought_str = explode(',', $result);
                $bought = [];
                foreach ($bought_str as $bought_str_item) {
                    $bought[] = intval($bought_str_item);
                }
                $stmtc -> close();

                if (isset($_GET['id'])) {
                    $result = $mysqli->query("SELECT * FROM products WHERE categories = " . intval($_GET['id']));
                }
                $total = mysqli_num_rows($result);
                for ($i = 0; $i < $total; $i++) {
                    $row = mysqli_fetch_row($result);
                    $inCart = in_array($row[0], $bought);
                    ?>
                    <div class="card" data-pid="<?=$row[0]?>">
                        <div class="image">
                            <img src="<?php echo "images.php?id={$row[7]}" ?> "/>
                        </div>
                        <div class="content">
                            <a class="header" href="product.php?id=<?php echo $row[0]; ?>">
                                <?php
                                echo $row[1];
                                ?>
                            </a>
                            <div class="meta">
                                $ <?php echo $row[3]; ?>
                                <span class="price quantity separator"></span>
                                <?php echo $row[2]; ?>
                            </div>
                            <div class="description">
                <span class="text">
                <?php
                echo $row[5];
                ?>
                </span>
                            </div>
                        </div>
                        <div class="extra content">
                            <div class="rating">
                                <div class="ui star rating" data-rating="<?php echo $row[9]; ?>"
                                     data-max-rating="5"></div>
                            </div>
                        </div>
                        <div class="cart-button <?php echo $inCart ? 'purchased' : '' ?>">
                            <div class="added to cart ui bottom attached green button">
                                <i class="checkmark icon"></i>
                                在購物車內
                            </div>
                            <div onclick="addToCart(<?php echo $row[0]; ?>)"
                                 class="ui bottom attached blue add to cart button">
                                <i class="add icon"></i>
                                加入購物車
                            </div>
                        </div>
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
