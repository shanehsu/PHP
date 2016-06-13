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
        $(function () {
            $("#Glide").glide({
                type: "carousel"
            });
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

    $stmt = $mysqli -> prepare('SELECT image FROM carousel');
    $stmt -> bind_result($iid);
    $stmt -> execute();
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
                    while ($stmt -> fetch()) {
                        ?>
                        <img class="glide__slide" src="images.php?id=<?php echo $iid; ?>"/>
                        <?php
                    }

                    $stmt -> close();
                    include 'util/close.php';
                    ?>
                </div>
            </div>

            <div class="glide__bullets"></div>
        </div>
    </div>

    <div style="display: flex; align-items: stretch; margin-top: 2rem;">
        <?php
        include "util/nested_menu.php";
        ?>

        <div class="ui piled segments" style="margin: 0 0 0 3rem; flex-grow: 1;">
            <div class="ui very padded red raised segment">
                <h2 class="ui red header">特惠商品</h2>
                <div class="ui items">
                    <?php
                    include 'util/connect.php';

                    $stmt = $mysqli -> prepare('SELECT id, name, thumbnail, description FROM products ORDER BY RAND() DESC LIMIT 0, 5');
                    $stmt -> bind_result($id, $name, $thumbnail, $description);
                    $stmt -> execute();
                    while ($stmt -> fetch()) {
                        ?>
                        <div class="item">
                            <div class="ui small image">
                                <img src="images.php?id=<?=$thumbnail?>">
                            </div>
                            <div class="middle aligned content">
                                <a href="product.php?id=<?=$id?>" class="header"><?=$name?></a>
                                <div class="description">
                                    <p><?=$description?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }

                    include 'util/close.php';
                    ?>
                </div>
            </div>
            <div class="ui very padded blue segment">
                <h2 class="ui blue header">公告</h2>
                <div class="ui relaxed divided list">
                    <?php
                    include("util/connect.php");
                    $result = $mysqli->query("SELECT * FROM posts ORDER BY id DESC LIMIT 0, 5");
                    $total = mysqli_num_rows($result);
                    for ($i = 0; $i < $total; $i++) {
                        $row = mysqli_fetch_row($result);
                        echo "<div class =\"item\">
                              <div class =\"content\">
                                <a class =\"header\" href = \"/product.php?id=$row[3]\">" . $row[1] . "</a>
                                <div class =\"description\">" . $row[2] . "</div>
                              </div>
                            </div>";
                    }
                    include("util/close.php");
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="ui horizontal segments" style="margin-top: 2rem;">
        <div class="ui padded yellow segment">
            <h2 class="ui yellow header">熱門商品</h2>
            <div class="ui items">
                <?php
                include 'util/connect.php';

                $stmt = $mysqli -> prepare('SELECT products.id, products.name, products.thumbnail, products.description
                    FROM group_12.products, group_12.receipt_item
                    WHERE products.id = receipt_item.item_id
                    ORDER BY receipt_item.id DESC
                    LIMIT 0, 5');
                $stmt -> bind_result($id, $name, $thumbnail, $description);
                $stmt -> execute();
                while ($stmt -> fetch()) {
                    ?>
                    <div class="item">
                        <div class="ui small image">
                            <img src="images.php?id=<?=$thumbnail?>">
                        </div>
                        <div class="middle aligned content">
                            <a href="product.php?id=<?=$id?>" class="header"><?=$name?></a>
                            <div class="description">
                                <p><?=$description?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                include 'util/close.php';
                ?>
            </div>
        </div>
        <div class="ui padded teal segment">
            <h2 class="ui teal header">近期上架</h2>
            <div class="ui items">
                <?php
                include 'util/connect.php';

                $stmt = $mysqli -> prepare('SELECT id, name, thumbnail, description FROM products ORDER BY id DESC LIMIT 0, 5');
                $stmt -> bind_result($id, $name, $thumbnail, $description);
                $stmt -> execute();
                while ($stmt -> fetch()) {
                    ?>
                    <div class="item">
                        <div class="ui small image">
                            <img src="images.php?id=<?=$thumbnail?>">
                        </div>
                        <div class="middle aligned content">
                            <a href="product.php?id=<?=$id?>" class="header"><?=$name?></a>
                            <div class="description">
                                <p><?=$description?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                }

                include 'util/close.php';
                ?>
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