<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>阿寯的美食天地</title>
    <link rel="stylesheet" type="text/css" href="semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <link rel="stylesheet" type="text/css" href="styles/glide.core.css">
    <link rel="stylesheet" type="text/css" href="styles/glide.theme.css">

    <script src="scripts/jquery-2.2.2.js"></script>
    <script src="semantic/semantic.js"></script>
    <script src="scripts/script.js"></script>
    <script src="scripts/glide.js"></script>

    <script>
        $(function () {
            $("#Glide").glide({
                type: "carousel"
            })

            $("#user-rating").rating({
                initialRating: 3,
                onRate: function (rating) {
                    $("#rating").val(rating);
                }
            })
        })
    </script>
</head>

<body>
<br>
<div class="ui container" style="padding-bottom: 2rem;">
    <?php
    include 'navigation.php';
    ?>
    <?php
    include("util/connect.php");

    $pid = intval($_GET['id']);
    $stmt_p = $mysqli -> prepare('SELECT name, categories FROM group_12.products WHERE id = ?');
    $stmt_p -> bind_param('d', $pid);
    $stmt_p -> bind_result($pname, $current_cid);
    $stmt_p -> execute();
    $stmt_p -> fetch();
    $stmt_p -> close();

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
    <div class="ui breadcrumb">

        <?php
        $length = count($traversal);

        for ($i = 0; $i < $length - 1; $i ++) {
            ?>
            <span class="section"><?=$traversal[$i]['name']?></span>
            <i class="right angle icon divider"></i>
            <?php
        }
        ?>

        <a href="category.php?id=<?=$traversal[$length-1]['id']?>" class="section"><?=$traversal[$length - 1]['name']?></a>
        <i class="right angle icon divider"></i>
        <div class="active section"><?= $pname  ?></div>
    </div>
    <!-- Product -->
    <div class="ui items">
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

        // 近期購買
        $stmtr = $mysqli -> prepare('SELECT SUM(quantity) 
            FROM group_12.receipt, group_12.receipt_item, group_12.products
            WHERE products.id = ? AND products.id = receipt_item.item_id AND receipt.id = receipt_item.receipt AND receipt.ordered >= DATE_ADD(CURDATE(), INTERVAL -3 DAY) ');
        $pid = intval($_GET['id']);
        $stmtr -> bind_param('d', $pid);
        $stmtr -> bind_result($recent);
        $stmtr -> execute();
        $stmtr -> fetch();
        $stmtr -> close();

        if (is_null($recent)) {
            $recent = 0;
        }

        if (isset($_GET['id'])) {
            $result = $mysqli -> query("SELECT * FROM products WHERE id = " . intval($_GET['id']));
            $row = mysqli_fetch_row($result);
            $inCart = in_array($row[0], $bought);
        }
        ?>
        <div class="item" data-pid="<?=$row[0]?>">

            <a class="ui image">
                <img src="<?php echo "images.php?id={$row[0]}" ?> ">
            </a>
            <div class="middle aligned content">
                <?php
                echo "<h1 class=\"ui header\">" . $row[1] . "</h1>
                            <div class=\"meta\">
                                <div class=\"recent\" style=\"display: inline-block;\">
                                    <i class=\"users icon\"></i>三天內共有 " . $recent .  " 人購買
                                </div>
                                <span class=\"price quantity separator\"></span>
                                <div class=\"rating\" style=\"display: inline-block;\">
                                    <div class=\"ui star rating\" data-rating=\"" . $row[9] . "\" data-max-rating=\"5\"></div>
                                </div>
                            </div>
                        <div style=\"max-width: 25em;\" class=\"description\"><p>" . $row[5] . "</p></div>";
                ?>
                <div class="cart-button extra <?php echo $inCart ? 'purchased' : '' ?>">
                    <?php
                    if ($authenticated) {
                        ?>
                        <div onclick="addToCart(<?php echo $row[0]; ?>)" class="ui green added to cart button">
                            <i class="checkmark icon"></i>
                            在購物車內
                        </div>
                        <div onclick="addToCart(<?php echo $row[0]; ?>)" class="ui blue add to cart button">
                            <i class="add icon"></i> 加入購物車
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="ui right floated large statistics">
                <div class="ui horizontal green statistic">
                    <div class="label">
                        <?=$row[2]?>
                    </div>
                    <div class="value">
                        $ <?=$row[3]?>
                    </div>
                </div>
            </div>

            <?php
            mysqli_free_result($result);
            ?>
        </div>
    </div>

    <?php
    $pid = intval($_GET['id']);
    $stmt_carousel = $mysqli -> prepare('SELECT image from group_12.product_carousel WHERE product = ?');
    $stmt_carousel -> bind_param('d', $pid);
    $stmt_carousel -> bind_result($image);
    $stmt_carousel -> execute();
    $images = [];

    while ($stmt_carousel -> fetch()) {
        $images[] = 'images.php?id=' . $image;
    }

    if (count($images) > 0) {
        ?>
        <div id="image-carousel">
            <div id="Glide" class="glide">

                <div class="glide__arrows">
                    <button class="ui inverted blue circular icon button glide__arrow large prev" data-glide-dir="<"><i
                            class="chevron left icon"></i></button>
                    <button class="ui inverted blue circular icon button glide__arrow large next" data-glide-dir=">"><i
                            class="chevron right icon" style="margin: 0;"></i></button>
                </div>

                <div class="glide__wrapper">
                    <div class="glide__track">
                        <?php
                        foreach ($images as $imageURL) {
                            ?>
                            <img class="glide__slide" src="<?=$imageURL?>"/>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="glide__bullets"></div>
            </div>
        </div>
        <?php
    }

    ?>
    <?php
    $stmt_carousel -> close();
    ?>

    <div style="display: flex; align-items: stretch; margin-top: 3rem; ">
        <?php
        $ary = explode("\n", $row[6]);
        $i = 0;
        echo "<div style=\"width: 40rem;\" class=\"ui very padded segment\"><p>";

        echo implode("</p><p>", $ary);


        echo "</p></div>";
        ?>
        <div style="padding-left: 2rem; flex-grow: 1; margin: 0;" class="ui comments">
            <h2 class="ui teal header">評論</h2>

            <?php

            // 載入評論
            $stmt = $mysqli -> prepare('SELECT group_12.comments.comment, group_12.comments.rating, group_12.comments.date, group_12.member.name
                FROM group_12.comments, group_12.member
                WHERE group_12.comments.product = ? AND group_12.comments.member = group_12.member.id
                ORDER BY comments.id DESC LIMIT 0, 6');

            $pid = intval($_GET['id']);
            $stmt -> bind_param('d', $pid);
            $stmt -> bind_result($comment, $rating, $date, $member);
            $stmt -> execute();

            while ($stmt -> fetch()) {
                ?>
                <div class="comment">
                    <div class="content">
                        <a class="author"><?php echo $member; ?></a>
                        <div class="metadata">
                            <div class="rating" style="display: inline-block;">
                                <div class="ui star rating" data-rating="<?php echo $rating; ?>" data-max-rating="5"></div>
                            </div>
                            <div class="date"><?php echo $date; ?></div>
                        </div>
                        <div class="text">
                            <p>
                                <?php
                                $lines = explode("\n", $comment);
                                foreach ($lines as &$line) {
                                    $line = htmlspecialchars($line);
                                }
                                echo implode("</p><p>", $lines);
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
            $stmt -> close();
            
            include("util/close.php");
            ?>
            <?php
            if ($authenticated) {
                ?>
                <form class="ui reply form" method="POST" action="comment.php?id=<?php echo intval($_GET['id']); ?>">
                    <div class="field">
                        <textarea name="comment" id="comment"></textarea>
                    </div>
                    <div class="field">
                        <input type="hidden" name="rating" id="rating"/>
                    </div>
                    <div class="field rating" style="display: inline-block;">
                        <div id="user-rating" class="ui star rating" data-max-rating="5"></div>
                    </div>
                    <button type="submit" class="ui primary submit right floated labeled icon button">
                        <i class="icon edit"></i> 評論
                    </button>
                </form>
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