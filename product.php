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
    <div class="ui breadcrumb">
        <a class="section">總覽</a>
        <i class="right angle icon divider"></i>
        <a class="section">生鮮食品</a>
        <i class="right angle icon divider"></i>
        <div class="active section">蔬菜</div>
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
                                    <i class=\"users icon\"></i>三天內共有 XXX 人購買
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
                        <span data-quantity-per-item="250" class="quantity per item"></span>
                        <span class="gram unit" style="padding-right: 1em; "></span>
                    </div>
                    <div class="value">
                        <span data-price-per-item="27" class="price per item"></span>
                        <span class="dollar unit"></span>
                    </div>
                </div>
            </div>

            <?php
            mysqli_free_result($result);
            ?>
        </div>
    </div>
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
                    <img class="glide__slide" src="images/index-carousel/1.jpg"/>
                    <img class="glide__slide" src="images/index-carousel/2.jpg"/>
                    <img class="glide__slide" src="images/index-carousel/3.jpg"/>
                    <img class="glide__slide" src="images/index-carousel/4.jpg"/>
                    <img class="glide__slide" src="images/index-carousel/5.jpg"/>
                </div>
            </div>

            <div class="glide__bullets"></div>
        </div>
    </div>
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
                WHERE group_12.comments.product = ? AND group_12.comments.member = group_12.member.id');

            $pid = intval($_GET['id']);
            $stmt -> bind_param('d', $pid);
            $stmt -> bind_result($comment, $rating, $date, $member);
            $stmt -> execute();
            $stmt -> store_result();
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
        </div>
    </div>
</div>
<?php
include 'modals.php';
?>
</body>

</html>