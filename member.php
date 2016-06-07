<?php
include "util/UserAuthenticationRequired.php";
include "util/connect.php";

session_start();
$uid = intval($_SESSION['_ID']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $name = $_POST["name"];
    $address = $_POST["address"];

    if($email != "" && $phone != "" && $name != "" && $address != "") {
        // 也算是失敗

        ?>
        <script>
            alert('有空值，無法修改。')
        </script>
        <?php
    } else {
        // 有要改密碼嗎
        $password_success = true;

        if (isset($_POST['password']) || isset($_POST['confirm'])) {
            // 兩者其中一個有，就一定要來

            if ($_POST['password'] == $_POST['confirm']) {
                // 才是可以讓他改
                $update_password = $mysqli->prepare('UPDATE member SET password = ? WHERE id = ?');
                $new_password = $_POST['password'];

                $update_password->bind_param('sd', $new_password, $uid);
                if ($update_password->execute()) {
                    // 成功，繼續執行
                } else {
                    // 失敗！

                    $password_success = false;
                    ?>
                    <script>
                        alert('修改密碼發生錯誤。')
                    </script>
                    <?php
                }

                $update_password -> close();
            } else {
                // 是有問題的，失敗！

                $password_success = false;
                ?>
                <script>
                    alert('密碼不符合，無法修改。')
                </script>
                <?php
            }
        }

        if ($password_success) {
            // 密碼沒有被修改或是修改成功

            $update_information = $mysqli -> prepare('UPDATE member set email = ?, name = ?, phone = ?, address = ? WHERE id = ?');
            $update_information -> bind_param('ssssd', $email, $name, $phone, $address, $uid);

            if ($update_information -> execute()) {
                // 成功，繼續執行
            } else {
                // 失敗
                ?>
                <script>
                    alert('發生錯誤，無法修改');
                </script>
                <?php
            }

            $update_information -> close();
        }
    }
}

$retrieve_information = $mysqli -> prepare('SELECT name, username, email, phone, address FROM group_12.member WHERE id = ?');
$retrieve_information -> bind_param('d', $uid);
$retrieve_information -> bind_result($name, $username, $email, $phone, $address);
$retrieve_information -> execute();
$retrieve_information -> fetch();

include("util/close.php");
?>
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
            $('.tabular.menu .item').tab()

            $.fn.form.settings.rules.validPassword = function (value) {
                var set = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 !\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~"
                for (var x of value) {
                    if (set.indexOf(x) < 0) return false
                }
                return true
            }
            $(document).ready(function ($) {
                $('.ui.checkbox').checkbox()
                $('.ui.form').form({
                    fields: {
                        name: {
                            identifier: 'name',
                            rules: [
                                {
                                    type: 'empty',
                                    prompt: '請輸入你的姓名'
                                }
                            ]
                        },
                        password: {
                            identifier: 'password',
                            optional: true,
                            rules: [
                                {
                                    type: 'empty',
                                    prompt: '請輸入你的密碼'
                                },
                                {
                                    type: 'minLength[8]',
                                    prompt: '密碼長度必須大於 {ruleValue}'
                                },
                                {
                                    type: 'maxLength[40]',
                                    prompt: '密碼長度必須小於 {ruleValue}'
                                },
                                {
                                    type: `validPassword`,
                                    prompt: '密碼只能包含英數、空白以及以下字元：!"#$%&\'()*+,-./:;<=>?@[\]^_`{|}~'
                                }
                            ]
                        },
                        confirm: {
                            identifier: 'confirm',
                            rules: [
                                {
                                    type: 'match[password]',
                                    prompt: '密碼確認必須與密碼相同'
                                }
                            ]
                        },
                        email: {
                            identifier: 'email',
                            rules: [
                                {
                                    type: 'empty',
                                    prompt: '請輸入你的電子郵件'
                                },
                                {
                                    type: 'email',
                                    prompt: '請輸入有效的電子郵件'
                                }
                            ]
                        },
                        phone: {
                            identifier: 'phone',
                            rules: [
                                {
                                    type: 'empty',
                                    prompt: '請輸入你的電話號碼'
                                },
                                {
                                    type: 'regExp[/[\\d]{7,15}/g]',
                                    prompt: '請輸入有效的電話號碼（不含任何符號)'
                                }
                            ]
                        },
                        address: {
                            rules: [
                                {
                                    type: 'empty',
                                    prompt: '請輸入你的住家地址'
                                }
                            ]
                        },
                        terms: {
                            identifier: 'terms',
                            rules: [
                                {
                                    type: 'checked',
                                    prompt: '你必須同意服務條款'
                                }
                            ]
                        }
                    }
                })
            })
        })
    </script>
</head>

<body>
<div class="ui container">
    <?php
    include 'navigation.php';
    ?>
    <h1 class="ui teal header">會員中心</h1>
    <!-- TODO 版面設計 -->
    <div class="ui top attached tabular menu">
        <a class="active item" data-tab="profile">會員資料</a>
        <a class="item" data-tab="orders">訂單
            <?php
            include 'util/connect.php';
            $count_stmt = $mysqli -> prepare('SELECT COUNT(*) FROM group_12.receipt WHERE member = ? AND paid = 0');
            $count_stmt -> bind_param('d', $uid);
            $count_stmt -> bind_result($unpaid);
            $count_stmt -> execute();
            $count_stmt -> fetch();
            $count_stmt -> close();
            include 'util/close.php';
            if ($unpaid != 0) {
                ?>
                <div class="circular floating ui red label"><?= $unpaid ?></div>
                <?php
            }
            ?>
        </a>
    </div>
    <div class="ui bottom attached segment">
        <div class="ui active tab" data-tab="profile">
            <form class="ui form" role="form" id="form1" action="member.php" method="POST">
                <div class="required field">
                    <label>姓名</label>
                    <input type="text" name="name" id="name" value="<?=$name?>">
                </div>
                <div class="field">
                    <label>使用者名稱</label>
                    <input placeholder="<?=$username?>" readonly="" type="text">
                </div>
                <div class="field">
                    <label>密碼</label>
                    <input type="password" name="password" id="password" placeholder="限 8 至 40 個字元">
                </div>
                <div class="field">
                    <label>密碼確認</label>
                    <input type="password" name="confirm" id="confirm" placeholder="密碼確認">
                </div>
                <div class="required field">
                    <label>電子郵件</label>
                    <input type="email" name="email" id="email" value="<?=$email?>">
                </div>
                <div class="required field">
                    <label>電話</label>
                    <input type="text" name="phone" id="phone" value="<?=$phone?>">
                </div>
                <div class="required field">
                    <label>地址</label>
                    <input type="text" name="address" id="address" value="<?=$address?>">
                </div>
                <div class="field" style="text-align: center;">
                    <button class="ui inverted green submit button">更改</button>
                </div>
                <div class="ui error message"></div>
            </form>
        </div>
        <div class="ui tab" data-tab="orders">
            <div class="ui divided items">
                <?php
                include "util/connect.php";

                $receipt_stmt = $mysqli -> prepare('SELECT receipt.id, DATE_FORMAT(receipt.ordered, \'%c 月 %e 日\'), receipt.paid,
                    GROUP_CONCAT(receipt_item.item_name SEPARATOR \'、\'), SUM(receipt_item.item_price * receipt_item.quantity) 
                    FROM group_12.receipt, group_12.receipt_item 
                    WHERE receipt_item.receipt = receipt.id AND receipt.member = ?
                    GROUP BY receipt.id
                    ORDER BY receipt.paid ASC, receipt.id DESC');

                $receipt_stmt -> bind_param('d', $uid);
                $receipt_stmt -> bind_result($rid, $rdate, $rpaid, $ritems, $rsum);
                $receipt_stmt -> execute();

                ?>

                <?php
                while ($receipt_stmt -> fetch()) {
                    ?>
                    <div class="item" style="align-items: center;">
                        <div class="content">
                            <div class="header">訂單編號 #<?=$rid?></div>
                            <div class="meta">
                                <span>總金額：</span>
                                <span class="dollar unit"></span>
                                <span class="price per item"><?=$rsum?></span>
                                <span class="price quantity separator"></span>
                                <span class="date"><?=$rdate?></span>
                            </div>
                            <div class="description">
                                <?=$ritems?>
                            </div>
                            <div class="extra">
                                <?php
                                if ($rpaid == 0) {
                                    ?>
                                    <a href="pay.php?id=<?=$rid?>">立即付款</a>
                                    <?php
                                }
                                ?>
                                <a href="receipt.php?id=<?=$rid?>">詳細資訊</a>
                            </div>
                        </div>
                        <?php
                        if ($rpaid == 0) {
                            ?>
                            <span class="ui red label status">未付款</span>
                            <?php
                        } else {
                            ?>
                            <span class="ui green label status">已付款</span>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <?php
                $receipt_stmt -> close();
                include "util/close.php";
                ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'modals.php';
?>

</body>

</html>