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

    .logo {
      background: #00b5ad;
      border:5px solid #00b5ad;
      padding:5px;
      color:white;
    }

    .logo::after {
      content: "寯";
    }
  </style>
</head>

<?php
// 若是 POST 則處理登入
$messages = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // 檢查帳號密碼
  $username = $_POST['username'];
  $password = $_POST['password'];

  // 開啟資料庫連線
  include './../util/connect.php';

  global $mysqli;
  $statement = $mysqli -> prepare('SELECT id, password FROM admin where username = ?');
  $statement -> bind_param('s', $username);
  $statement -> execute();
  $statement -> bind_result($result_id, $result_password);
  $statement -> fetch(); // 沒有東西的話，剛剛好，反正只是不會有值

  if ($result_password == $password) {
    // 成功登入
    // 寫入 Session
    session_start();

    $_SESSION["_ADMIN_AUTHENTICATED"] = true;
    $_SESSION["_ADMIN_ID"] = $result_id;

    session_commit();

    // 跳轉
    header('Location: index.php');
  } else {
    $messages[] = "密碼錯誤。";
  }


  // 關閉資料庫連線
  include './../util/close.php';
}
?>

<body>
<div class="ui middle aligned center aligned grid">
  <div class="column">
    <h2 class="ui teal image header">
      <div class="logo image"></div>
      <div class="content">
        登入
      </div>
    </h2>
    <form class="ui large <?php if (count($messages) > 0) {echo "error"; } ?> form" action="login.php" method="POST">
      <div class="ui raised segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="username" placeholder="帳號">
          </div>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="密碼">
          </div>
        </div>
        <button type="submit" class="ui fluid large teal submit button">登入</button>
      </div>

      <div class="ui error message">
        <?php
        if (count($messages) > 0) {
          ?>
          <ul class="list">
            <?php
            foreach ($messages as $message) {
              ?>
              <li><?php echo $message; ?></li>
              <?php
            }
            ?>
          </ul>
          <?php
        }
        ?>
      </div>
    </form>
  </div>
</div>
</body>
</html>