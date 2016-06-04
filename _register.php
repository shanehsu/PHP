<?session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?



$login = 0;
$account = $_POST['username'];
$password = $_POST['password'];
$password2 = $_POST["confirm"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$name = $_POST["name"];
$address = $_POST["address"];

if($email != "" || $password != ""){
    $link = mysqli_connect("php.caituglxwkil.ap-northeast-1.rds.amazonaws.com","root","12345678","group_12")// 建立MySQL的資料庫連結
    or die("無法開啟MySQL資料庫連結!<br>");
    mysqli_query($link,"SET CHARACTER SET UTF8");
            mysqli_query($link,"SET collation_connection = 'utf8_unicode_ci'");
        }

    //$sql = "SELECT * FROM member where Email='$email' ";


    if($account != null && $password != null && $password2 != null && $password == $password2)
{
        //新增資料進資料庫語法
        $sql = "insert into member(account, password, Email,name, phone, address) values ('$account', '$password', '$email', '$name','$phone', '$address')";
        if(mysql_query($sql))
        {
                echo '新增成功!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        }
        else
        {
                echo '新增失敗!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
        }
}
else
{
        echo '您無權限觀看此頁面!';
        echo "$account , $password, $password2";
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}





?>