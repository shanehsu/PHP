<?php

require 'util/UserNotAuthenticatedRequired.php';

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
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
            exit();
        } else {
            ?>
            <script>
                alert('註冊失敗！')
            </script>
            <?php
        }

        include("util/close.php");
    } else {
        die("每個欄位都要填寫。");
    }
}
?>

<html>

<head>
    <meta charset="utf-8">
    <title>阿寯的美食天地</title>
    <link rel="stylesheet" type="text/css" href="semantic/semantic.css">
    <link rel="stylesheet" type="text/css" href="styles/style.css">
    <script src="scripts/jquery-2.2.2.js"></script>
    <script src="semantic/semantic.js"></script>
    <script src="scripts/script.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script>
        var debug = false;

        if (debug) {
            console.warn("測試中：已啟用測試功能，將自動填寫表單預設值，方便測試。")
        }
        
        $.fn.form.settings.rules.validPassword = function(value) {
            var set = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789 !\"#$%&'()*+,-./:;<=>?@[\\]^_`{|}~"
            for (var x of value) {
                if (set.indexOf(x) < 0) return false
            }
            return true
        }

        $.fn.form.settings.rules.usernameInUse = function(value) {
            var result = true

            req = $.ajax('/ajax/check_username.php?username=' + value, {
                async: false,
                cache: false,
                dataType: 'text',
                timeout: 250,
                success: function(response) {
                    if (response == 'false') {
                        result = false;
                    }
                }
            })
            console.log("RESULT = " + result);
            return result
        }
        $(document).ready(function($) {
            $('.ui.checkbox').checkbox()
            $('.ui.form').form({
                fields: {
                    name: {
                        identifier: 'name',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '請輸入你的姓名'
                            }
                        ]
                    },
                    username: {
                        identifier: 'username',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '請輸入你的使用者名稱'
                            },
                            {
                                type: 'minLength[6]',
                                prompt: '使用者名稱長度必須大於 {ruleValue}'
                            },
                            {
                                type: 'maxLength[20]',
                                prompt: '使用者名稱長度必須小於 {ruleValue}'
                            },
                            {
                                type: 'regExp[/^[.\\w]*$/]',
                                prompt: '使用者名稱只能包含英文、數字、點（.）以及底線（_）'
                            },
                            {
                                type: 'usernameInUse',
                                prompt: '使用者名稱已經被使用'
                            }
                        ]
                    },
                    password: {
                        identifier: 'password',
                        rules: [
                            {
                                type   : 'empty',
                                prompt : '請輸入你的密碼'
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
                                type   : 'checked',
                                prompt : '你必須同意服務條款'
                            }
                        ]
                    }
                }
            })
            
            if (debug == true) {
                $('#name').val("徐鵬鈞")
                $('#username').val("hsu.pengjun")
                $('#password').val("ABCD1234")
                $('#confirm').val("ABCD1234")
                $('#email').val("hsu.pengjun@icloud.com")
                $('#phone').val("033352279")
                $('#address').val("桃園市桃園區朝陽街 53 號 10 樓之 3")
                $('#terms').prop("checked", "checked")
            }
        })
    </script>
</head>

<body>
    <br>
    <div class="ui container">

        <?php
        include 'navigation.php';
        ?>

        <div style="min-width: 30em; width: 50%; margin: 0 auto;">
            <form class="ui form" role="form" id="form1" action="signup.php" method="POST">
                <h1>會員註冊</h1>
                <div class="field">
                    <label>姓名</label>
                    <input type="text" name="name" id="name" placeholder="姓名">
                </div>
                <div class="field">
                    <label>使用者名稱</label>
                    <input type="text" name="username" id="username" placeholder="限 6 至 20 個字元（英文、數字、點以及底線）">
                </div>
                <div class="field">
                    <label>密碼</label>
                    <input type="password" name="password" id="password" placeholder="限 8 至 40 個字元">
                </div>
                <div class="field">
                    <label>密碼確認</label>
                    <input type="password" name="confirm" id="confirm" placeholder="密碼確認">
                </div>
                <div class="field">
                    <label>電子郵件</label>
                    <input type="email" name="email" id="email" placeholder="user@company.com">
                </div>
                <div class="field">
                    <label>電話</label>
                    <input type="text" name="phone" id="phone" placeholder="推薦使用手機">
                </div>
                <div class="field">
                    <label>地址</label>
                    <input type="text" name="address" id="address" placeholder="">
                </div>
                <br />
                <div class="field" style="text-align: center;">
                    <div class="ui checkbox">
                        <input type="checkbox" id="terms" name="terms" value="agreed" class="hidden">
                        <label>我同意相關服務條款</label>
                    </div>
                </div>
                <br />
                <div class="field" style="text-align: center;">
                    <button type="submit" class="ui inverted green submit button">註冊</button>
                </div>
                <div class="ui right rail">
                    <div class="ui error message"></div>
                </div>
            </form>
        </div>
    </div>
    <?php
    include 'modals.php';
    ?>
</body>
</html>