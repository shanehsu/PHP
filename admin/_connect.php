<?session_start();

if (!isset($_SESSION['adminLoggedin'])){
  $_SESSION['adminLoggedin'] = false;
}
  if (!isset($_SESSION['id'])){
  $_SESSION['id'] = 0;
}



$username = $_POST['username'];
$password = $_POST['password'];



if($username != "" || $password != ""){
    $link = mysqli_connect("php.caituglxwkil.ap-northeast-1.rds.amazonaws.com","root","12345678","group_12")// 建立MySQL的資料庫連結
    or die("無法開啟MySQL資料庫連結!<br>");
    mysqli_query($link,"SET CHARACTER SET UTF8");
            mysqli_query($link,"SET collation_connection = 'utf8_unicode_ci'");

    $sql = "SELECT * FROM admin where username='$username' ";


     // 送出查詢的SQL指令
    if ( $result = mysqli_query($link, $sql) ) { 
        if($row = mysqli_fetch_assoc($result)){
            if($row['password'] == $password){
              
                $_SESSION['adminLoggedin']=true;
                $_SESSION['userName']=$row['username'];
                $_SESSION['id']=$row['ID'];
               
              
            }
            else if($row['pwd'] != $pwd){
                
               header('Location:admin/login.php');
               
            }
        }
        else $login = 3;
        //account doesn't exist
        header('Location:admin/login.php');
        mysqli_free_result($result); // 釋放佔用的記憶體 
    }

    mysqli_close($link); // 關閉資料庫連結
    

    if($_SESSION['adminLoggedin'] == true){
        header('Location:index.php');
        
    }



    }




?>