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
    $(function() {
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

    <div id="image-carousel">
      <div id="Glide" class="glide">

        <div class="glide__arrows">
          <button class="ui inverted blue circular icon button glide__arrow large prev" data-glide-dir="<"><i class="chevron left icon"></i></button>
          <button class="ui inverted blue circular icon button glide__arrow large next" data-glide-dir=">"><i class="chevron right icon" style="margin: 0;"></i></button>
        </div>

        <div class="glide__wrapper">
          <div class="glide__track">
            <img class="glide__slide" src="images/index-carousel/1.jpg" />
            <img class="glide__slide" src="images/index-carousel/2.jpg" />
            <img class="glide__slide" src="images/index-carousel/3.jpg" />
            <img class="glide__slide" src="images/index-carousel/4.jpg" />
            <img class="glide__slide" src="images/index-carousel/5.jpg" />
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
                $result = $mysqli -> query("select * from posts");
                $total = mysqli_num_rows($result);
                for($i = 0; $i < $total; $i++) {
                  $row = mysqli_fetch_row($result);
                    echo "<div class =\"item\">
                              <div class =\"content\">
                                <a class =\"header\" href = \"http://localhost/product.php?id=$row[3]\">". $row[1] ."</a>
                                <div class =\"description\">". $row[2] ."</div>
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