<?php
$username = $_POST['username'];
$password = $_POST['password'];
$confirm = $_POST["confirm"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$name = $_POST["name"];
$address = $_POST["address"];
$terms = ($_POST["terms"] == 'agreed');

if($username != "" && $password != "" && $confirm != "" && $email != "" && $phone != "" && $name != "" && $address != "" && $terms && $password == $confirm) {
    include("util/connect.php");

    $statement = $mysqli -> prepare('INSERT INTO member (username, password, email, name, phone, address, identity) VALUES (?, ?, ?, ?, ?, ?, 1)');
    $statement -> bind_param('ssssss', $username, $password, $email, $name, $phone, $address);

    if ($statement -> execute()) {
        ?>
        <script>
            alert('註冊成功！請重新登入。')
            window.location.assign('/index.php')
        </script>
        <?php
    } else {
        ?>
        <script>
            alert('註冊失敗！')
            window.location.assign('/index.php')
        </script>
        <?php
    }

    include("util/close.php");
} else {
    die("每個欄位都要填寫。");
}
