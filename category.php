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
            <div class="ui four doubling cards">
                <?php
                include("util/connect.php");

                if (isset($_GET['id'])) {
                    $result = $mysqli->query("SELECT * FROM products WHERE categories = " . intval($_GET['id']));
                }
                $total = mysqli_num_rows($result);
                for ($i = 0; $i < $total; $i++) {
                    $row = mysqli_fetch_row($result);
                    ?>
                    <div class="card">
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
                                <div class="ui star rating" data-rating="<?php echo $row[9]; ?>" data-max-rating="5"></div>
                            </div>
                        </div>
                        <div class="extra content">
                            <div class="recent">
                                <i class="users icon"></i>
                                近三天內有 493 人購買
                            </div>
                        </div>
                        <div onclick="addToCart(<?php echo $row[0]; ?>)" class="ui bottom attached blue add to cart button">
                            <i class="add icon"></i>
                            加入購物車
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
