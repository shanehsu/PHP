<?session_start();?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?
include("util/connect.php")//仔入登入的session

//$username = $_POST['username'];
$name = $_POST['name'];
$pw = $_POST['password'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$email = $_POST['email'];
$confirm = $_POST['confirm'];

//紅色字體為判斷密碼是否填寫正確
if($_SESSION['username'] != null && $pw != null && $confirm != null && $pw == $confirm)
{
        $username = $_SESSION['username'];
    
        //更新資料庫資料語法
        $sql = "update member set password=$pw, phone=$phone, address=$address, Email='$email , name = '$name',  where account='$username'";
        if(mysql_query($sql))
        {
                echo '修改成功!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
        }
        else
        {
                echo '修改失敗!';
                echo '<meta http-equiv=REFRESH CONTENT=2;url=member.php>';
        }
}
else
{
        echo '您無權限觀看此頁面!';
        echo '<meta http-equiv=REFRESH CONTENT=2;url=index.php>';
}






?>