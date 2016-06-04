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
  <br>
  <div class="ui container" style="padding-bottom: 2rem;">
    <div class="ui large menu">
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
    <br>
    <div class="ui grid">
      <div class="three wide column">
        <?php
          include 'util/flat_menu.php';
        ?>
<!--        <div class="ui fluid secondary vertical menu">-->
<!--          <a class="active item">特惠專區</a>-->
<!--          <a class="item">生鮮食品</a>-->
<!--          <a class="item">加工食品</a>-->
<!--          <a id="world-popup-toggle" class="browse item">-->
<!--            世界美食特區-->
<!--            <i class="dropdown icon"></i>-->
<!--          </a>-->
<!--          <div id="world-popup" class="ui flowing popup bottom left transition hidden" style="min-width: 30em;">-->
<!--            <div class="ui four column relaxed equal height divided grid">-->
<!--              <div class="column">-->
<!--                <h4 class="ui header">亞洲</h4>-->
<!--                <div class="ui link list">-->
<!--                  <a class="item">日本</a>-->
<!--                  <a class="item">南韓</a>-->
<!--                </div>-->
<!--              </div>-->
<!--              <div class="column">-->
<!--                <h4 class="ui header">歐洲</h4>-->
<!--                <div class="ui link list">-->
<!--                  <a class="item">英國</a>-->
<!--                  <a class="item">法國</a>-->
<!--                  <a class="item">義大利</a>-->
<!--                </div>-->
<!--              </div>-->
<!--              <div class="column">-->
<!--                <h4 class="ui header">美洲</h4>-->
<!--                <div class="ui link list">-->
<!--                  <a class="item">美國</a>-->
<!--                  <a class="item">加拿大</a>-->
<!--                  <a class="item">墨西哥</a>-->
<!--                </div>-->
<!--              </div>-->
<!--              <div class="column">-->
<!--                <h4 class="ui header">其他</h4>-->
<!--                <div class="ui link list">-->
<!--                  <a class="item">澳洲</a>-->
<!--                  <a class="item">紐西蘭</a>-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->
<!--          </div>-->
<!--        </div>-->
      </div>
      
      <div class="thirteen wide column">
        <div class="ui four doubling cards">
          <?php
            include("util/connect.php");

            if (isset($_GET['id']))
            {
              $result = $mysqli -> query("select * from products where id = " . intval($_GET['id']));
            }
            $total = mysqli_num_rows($result);
            for($i = 0; $i < $total; $i++) {
                $row = mysqli_fetch_row($result);
          ?>
          <div class="card">
            <div class="image">
              <img src="<?php echo "images.php?id={$row[7]}" ?> "/>
            </div>
            <div class="content">
              <a class="header">
              <?php               
                  echo $row[1];
              ?>
              </a>
              <div class="meta">
                <span class="dollar unit"></span>
                <span data-price-per-item="27" class="price per item"></span>
                <span class="price quantity separator"></span>
                <span data-quantity-per-item="250" class="quantity per item"></span>
                <span class="gram unit"></span>
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
                <div class="ui star rating" data-rating="3" data-max-rating="5"></div>
              </div>
            </div>
            <div class="extra content">
              <div class="recent">
                <i class="users icon"></i>
                近三天內有 493 人購買
              </div>
            </div>
            <div class="ui bottom attached blue add to cart button">
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
  <div id="login-modal" class="ui small modal">
    <div class="header">
      登入
    </div>
    <div class="content">
      <form class="ui form">
        <div class="required field">
          <label>電子郵件</label>
          <input type="email" name="email" placeholder="電子郵件">
        </div>
        <div class="required field">
          <label>密碼</label>
          <input type="password" name="password" placeholder="密碼">
        </div>
      </form>
    </div>
    <div class="actions">
      <div id="login-modal-register" class="approve ui blue basic button">註冊</div>
      <div id="login-modal-login" class="approve ui green button">登入</div>
    </div>
  </div>
  <div id="cart-modal" class="ui large modal">
    <div class="header">
      購物車
    </div>
    <div class="content">
      <table class="ui tablet stackable table">
        <thead>
          <tr>
            <th>品項</th>
            <th>單價</th>
            <th>數量</th>
            <th>總價</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>小白菜</td>
            <td>
              <span class="dollar unit"></span>
              <span data-price-per-item="39" class="price per item"></span>
            </td>
            <td>
              <button class="ui red basic icon button quantity minus">
                <i class="minus icon"></i>
              </button>
              <span data-quantity="4" class="quantity"></span>
              <button class="ui green basic icon button quantity add">
                <i class="plus icon"></i>
              </button>
            </td>
            <td>
              <span class="dollar unit"></span>
              <span data-price-subtotal="156" class="price subtotal"></span>
            </td>
          </tr>
          <tr>
            <td>油菜</td>
            <td>
              <span class="dollar unit"></span>
              <span data-price-per-item="37" class="price per item"></span>
            </td>
            <td>
              <button class="ui red basic icon button quantity minus">
                <i class="minus icon"></i>
              </button>
              <span data-quantity="2" class="quantity"></span>
              <button class="ui green basic icon button quantity add">
                <i class="plus icon"></i>
              </button>
            </td>
            <td>
              <span class="dollar unit"></span>
              <span data-price-subtotal="77" class="price subtotal"></span>
            </td>
          </tr>
          <tr>
            <td>小黃瓜</td>
            <td>
              <span class="dollar unit"></span>
              <span data-price-per-item="75" class="price per item"></span>
            </td>
            <td>
              <button class="ui red basic icon button quantity minus">
                <i class="minus icon"></i>
              </button>
              <span data-quantity="6" class="quantity"></span>
              <button class="ui green basic icon button quantity add">
                <i class="plus icon"></i>
              </button>
            </td>
            <td>
              <span class="dollar unit"></span>
              <span data-price-subtotal="450" class="price subtotal"></span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="actions">
      <div id="cart-modal-update" class="approve ui green basic button">更新</div>
      <div id="cart-modal-checkout" class="approve ui animated fade blue button">
        <div class="visible content">結帳</div>
        <div class="hidden content">
          <span class="dollar unit"></span>
          <span class="price total" data-price-total="683"></span>
        </div>
      </div>
    </div>
  </div>
  <div id="added-to-cart-modal" class="ui xsmall modal">
    <div class="centered header">
      已加入購物車
    </div>
    <div class="centered content">
      <i class="massive checkmark icon"></i>
    </div>
  </div>
</div>
</body>
</html>
