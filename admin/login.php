<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Nameless Apps 收支管理系統</title>
    <link rel="stylesheet" type="text/css" href="../semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="../styles/style.css">
    <script src="../scripts/jquery-2.2.2.js"></script>
    <script src="../semantic/semantic.js"></script>
    
    <style>
      body > .grid {
        height: 100%;
      }
      .image {
        margin-top: -100px;
      }
      .column {
        max-width: 450px;
      }
    </style>
  </head>
  <body>
    <div class="ui middle aligned center aligned grid">
      <div class="column">
        <h2 class="ui teal image header">
          <div class="image" style="background: url(http://webkit.org/images/green-background.png), #00b5ad; border:5px solid #00b5ad; padding:5px; -webkit-background-clip: text, border; color: white; width: 50px; height: 50px;">N</div>
          <div class="content">
            登入
          </div>
        </h2>
        <form class="ui large form" action="_connect.php" method = "POST">
          <div class="ui raised segment">
            <div class="field">
              <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="text" name="username" placeholder="username">
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="lock icon"></i>
                <input type="password" name="password" placeholder="密碼">
              </div>
            </div>
            <div type = "submit" class="ui fluid large teal submit button"  >登入</div>
          </div>
    
          <div class="ui error message"></div>
    
        </form>
      </div>
    </div>
  </body>
</html>