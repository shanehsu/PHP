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

    <div style="display: flex; align-items: stretch; margin-top: 2rem;">
        <?php
        include "util/nested_menu.php";
        ?>

        <div class="ui piled segments" style="margin: 0 0 0 3rem; flex-grow: 1;">
            <div class="ui very padded red raised segment">
                <h2 class="ui red header">特惠商品</h2>
                <div class="ui items">
                    <div class="item">
                        <div class="ui small image">
                            <img src="images/004.jpg">
                        </div>
                        <div class="middle aligned content">
                            <a class="header">芥藍菜</a>
                            <div class="meta">
                                <span>於臺灣雲林生產，附有產銷履歷。</span>
                            </div>
                            <div class="description">
                                <p>我是完整敘述的前幾個字喔。</p>
                            </div>
                            <div class="extra">
                                Additional Details
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui small image">
                            <img src="images/003.jpg">
                        </div>
                        <div class="middle aligned content">
                            <a class="header">菠菜</a>
                            <div class="meta">
                                <span>於臺灣雲林生產，附有產銷履歷。</span>
                            </div>
                            <div class="description">
                                <p>我是完整敘述的前幾個字喔。</p>
                            </div>
                            <div class="extra">
                                Additional Details
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="ui small image">
                            <img src="images/008.jpg">
                        </div>
                        <div class="middle aligned content">
                            <a class="header">A 菜</a>
                            <div class="meta">
                                <span>於臺灣雲林生產，附有產銷履歷。</span>
                            </div>
                            <div class="description">
                                <p>我是完整敘述的前幾個字喔。</p>
                            </div>
                            <div class="extra">
                                Additional Details
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ui very padded blue segment">
                <h2 class="ui blue header">公告</h2>
                <div class="ui relaxed divided list">
                    <?php
                    include("util/connect.php");
                    $result = $mysqli->query("SELECT * FROM posts");
                    $total = mysqli_num_rows($result);
                    for ($i = 0; $i < $total; $i++) {
                        $row = mysqli_fetch_row($result);
                        echo "<div class =\"item\">
                              <div class =\"content\">
                                <a class =\"header\" href = \"http://localhost/product.php?id=$row[3]\">" . $row[1] . "</a>
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
                <div class="item">
                    <div class="ui small image">
                        <img src="images/004.jpg">
                    </div>
                    <div class="middle aligned content">
                        <a class="header">芥藍菜</a>
                        <div class="meta">
                            <span>於臺灣雲林生產，附有產銷履歷。</span>
                        </div>
                        <div class="description">
                            <p>我是完整敘述的前幾個字喔。</p>
                        </div>
                        <div class="extra">
                            Additional Details
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ui padded teal segment">
            <h2 class="ui teal header">近期上架</h2>
            <div class="ui items">
                <div class="item">
                    <div class="ui small image">
                        <img src="images/004.jpg">
                    </div>
                    <div class="middle aligned content">
                        <a class="header">芥藍菜</a>
                        <div class="meta">
                            <span>於臺灣雲林生產，附有產銷履歷。</span>
                        </div>
                        <div class="description">
                            <p>我是完整敘述的前幾個字喔。</p>
                        </div>
                        <div class="extra">
                            Additional Details
                        </div>
                    </div>
                </div>
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