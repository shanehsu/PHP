<?php
    session_start();
    include("util/connect.php");
    if ($_session['_ID']){
        $result = $mysqli -> query("select * from member where id = " . intval($_session['_ID']));
        $row = mysqli_fetch_row($result);
    }  
     if ($_SERVER['REQUEST_METHOD'] == 'POST') {        
        $sql ="update member set username='".$_POST['username']."',password='".$_POST['password']."',email='".$_POST['email']."',name='".$_POST['name']."',phone='".$_POST['phone']."',address='".$_POST['address']."'  where id = ".$_session['_ID'];

        //echo '<pre>'.$sql.'</pre>';

        if (mysqli_query($mysqli, $sql)) {
            header('Location: member.php');
        } else {
            echo "<br>無法修改。";
            echo mysqli_error($mysqli);
        }
        include("util/close.php");
    }
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
                        username: {
                            identifier: 'username',
                            rules: [
                                {
                                    type: 'empty',
                                    prompt: '請輸入你的使用者名稱'
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
                                }
                            ]
                        },
                        password: {
                            identifier: 'password',
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
<br>
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
    <h1 class="ui teal header">會員中心</h1>
    <!-- TODO 版面設計 -->
    <div class="ui top attached tabular menu">
        <a class="active item" data-tab="profile">會員資料</a>
        <a class="item" data-tab="orders">訂單<div class="circular floating ui red label">1</div></a>
    </div>
    <div class="ui bottom attached segment">
        <div class="ui active tab" data-tab="profile">
            <form class="ui form" role="form" id="form1" action="member.php" method="POST">
                <div class="field">
                    <label>姓名</label>
                    <input type="text" name="name" id="name" placeholder="姓名" value="<?=$row[4]?>">
                </div>
                <div class="field">
                    <label>使用者名稱</label>
                    <input type="text" name="username" id="username" placeholder="限 6 至 20 個字元（英文、數字、點以及底線）" value="<?=$row[1]?>">
                </div>
                <div class="field">
                    <label>密碼</label>
                    <input type="password" name="password" id="password" placeholder="限 8 至 40 個字元" value="<?=$row[2]?>">
                </div>
                <div class="field">
                    <label>密碼確認</label>
                    <input type="password" name="confirm" id="confirm" placeholder="密碼確認">
                </div>
                <div class="field">
                    <label>電子郵件</label>
                    <input type="email" name="email" id="email" placeholder="user@company.com" value="<?=$row[3]?>">
                </div>
                <div class="field">
                    <label>電話</label>
                    <input type="text" name="phone" id="phone" placeholder="推薦使用手機" value="<?=$row[5]?>">
                </div>
                <div class="field">
                    <label>地址</label>
                    <input type="text" name="address" id="address" placeholder="" value="<?=$row[6]?>">
                </div>
                <div class="field" style="text-align: center;">
                    <button class="ui inverted green submit button">更改</button>
                </div>
                <div class="ui error message"></div>
            </form>
        </div>
        <div class="ui tab" data-tab="orders">
            <div class="ui divided items">
                <div class="item" style="align-items: center;">
                    <div class="content">
                        <div class="header">訂單編號 #1</div>
                        <div class="meta">
                            <span>總金額：</span><span class="dollar unit"></span>
                            <span data-price-per-item="1830" class="price per item"></span>
                            <span class="price quantity separator"></span>
                            <span class="date">5 月 31 日</span>
                        </div>
                        <div class="description">
                            甘藍菜、蘋果、鳳梨釋迦
                        </div>
                        <div class="extra">
                            <a>立即付款</a>
                            <a>詳細資訊</a>
                        </div>
                    </div>
                    <span class="ui red label status">未付款</span>
                </div>
                <div class="item" style="align-items: center;">
                    <div class="content">
                        <div class="header">訂單編號 #1</div>
                        <div class="meta">
                            <span>總金額：</span><span class="dollar unit"></span>
                            <span data-price-per-item="1830" class="price per item"></span>
                            <span class="price quantity separator"></span>
                            <span class="date">5 月 31 日</span>
                        </div>
                        <div class="description">
                            甘藍菜、蘋果、鳳梨釋迦
                        </div>
                        <div class="extra">
                            <a>詳細資訊</a>
                        </div>
                    </div>
                    <span class="ui green label status">已付款</span>
                </div><div class="item" style="align-items: center;">
                <div class="content">
                    <div class="header">訂單編號 #1</div>
                    <div class="meta">
                        <span>總金額：</span><span class="dollar unit"></span>
                        <span data-price-per-item="1830" class="price per item"></span>
                        <span class="price quantity separator"></span>
                        <span class="date">5 月 31 日</span>
                    </div>
                    <div class="description">
                        甘藍菜、蘋果、鳳梨釋迦
                    </div>
                    <div class="extra">
                        <a>詳細資訊</a>
                    </div>
                </div>
                <span class="ui green label status">已付款</span>
            </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>