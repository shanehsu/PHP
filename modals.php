<?php
/**
 * Created by PhpStorm.
 * Date: 2016/6/5
 * Time: 下午3:10
 */
?>

<div id="login-modal" class="ui small modal">
    <div class="header">
        登入
    </div>
    <div class="content">
        <form class="ui form">
            <div class="required field">
                <label>使用者名稱</label>
                <input type="text" name="username" placeholder="使用者名稱">
            </div>
            <div class="required field">
                <label>密碼</label>
                <input type="password" name="password" placeholder="密碼">
            </div>
            <div class="ui error message">
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
    <div class="ui basic segment content">
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
            </tbody>
        </table>
    </div>
    <div class="actions">
        <div id="cart-modal-update" class="approve ui green basic button" onclick="updateCart()">更新</div>
        <div id="cart-modal-checkout" class="approve ui animated fade blue button">
            <div class="visible content" onclick="checkout()">結帳</div>
            <div class="hidden content">
                <span class="dollar unit"></span>
                <span class="price total" data-price-total=""></span>
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