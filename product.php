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
    <div class="ui large menu" style="margin-bottom: 2rem;">
        <a class="active item">阿寯的美食天地</a>
        <div class="right menu">
            <div class="collapsed search item">
                <div class="ui icon input">
                    <input type="text" placeholder="關鍵字">
                    <i class="search link icon"></i>
                </div>
            </div>
            <a class="search trigger ui item"><i class="search link marginless icon"></i></a>
            <a id="login-modal-show" class="ui item">登入</a>
            <a id="cart-modal-show" class="ui item">購物車</a>
        </div>
    </div>
    <div class="ui breadcrumb">
        <a class="section">總覽</a>
        <i class="right angle icon divider"></i>
        <a class="section">生鮮食品</a>
        <i class="right angle icon divider"></i>
        <div class="active section">蔬菜</div>
    </div>
    <!-- Product -->
    <div class="ui items">
        <div class="item">
            <a class="ui image">
                <img src="images/001.jpg">
            </a>
            <div class="middle aligned content">
                <?php 
                    include("connect.php");

                    if (isset($_GET['id']))
                    {
                        $result = $mysqli -> query("select * from products where id = " . intval($_GET['id']));
                    } 
                    $row = mysqli_fetch_row($result);              
                    echo "<h1 class=\"ui header\">". $row[1] ."</h1>
                            <div class=\"meta\">
                                <div class=\"recent\" style=\"display: inline-block;\">
                                    <i class=\"users icon\"></i>共有XXX人購買
                                </div>
                                <span class=\"price quantity separator\"></span>
                                <div class=\"rating\" style=\"display: inline-block;\">
                                    <div class=\"ui star rating\" data-rating=\"5\" data-max-rating=\"5\"></div>
                                </div>
                            </div>
                        <div class=\"description\"><p>". $row[5] ."</p></div>";               
                ?>
                <div class="extra">
                    <div class="ui blue add to cart button">
                        <i class="add icon"></i> 加入購物車
                    </div>
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
            $ary = str_split($row[6]);
            $i = 0;
            echo "<div style=\"width: 40rem;\" class=\"ui very padded segment\"><p>";
            while($ary[$i] != null)
            {
                
                if($ary[$i] == "\n")
                {   
                    
                    echo "<p></p>";
                    $i++;
                }
                else
                {
                    echo " ".$i." ";
                    echo "$ary[i]";
                    $i++;
                }
            }
            echo "</div>";
            include("close.php");
            
        ?>      
        <div style="padding-left: 2rem; flex-grow: 1; margin: 0;" class="ui comments">
            <h2 class="ui teal header">評論</h2>
            <div class="comment">
                <div class="content">
                    <a class="author">徐鵬鈞</a>
                    <div class="metadata">
                        <div class="rating" style="display: inline-block;">
                            <div class="ui star rating" data-rating="3" data-max-rating="5"></div>
                        </div>
                        <div class="date">5 月 30 日</div>
                    </div>
                    <div class="text">
                        <p>還不錯吃。</p>
                        <p>可以再更新鮮。</p>
                    </div>
                </div>
            </div>
            <div class="comment">
                <div class="content">
                    <a class="author">王詳寯</a>
                    <div class="metadata">
                        <div class="rating" style="display: inline-block;">
                            <div class="ui star rating" data-rating="5" data-max-rating="5"></div>
                        </div>
                        <div class="date">5 月 30 日</div>
                    </div>
                    <div class="text">
                        <p>幹你娘吃爆。</p>
                    </div>
                </div>
            </div>
            <form class="ui reply form">
                <div class="field">
                    <textarea name="comment" id="comment"></textarea>
                </div>
                <div class="field">
                    <input type="hidden" name="rating" id="rating"/>
                </div>
                <div class="field rating" style="display: inline-block;">
                    <div id="user-rating" class="ui star rating" data-max-rating="5"></div>
                </div>
                <div class="ui primary submit right floated labeled icon button">
                    <i class="icon edit"></i> 評論
                </div>
            </form>
        </div>
    </div>
</div>
</body>

</html>