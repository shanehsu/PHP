$(function () {
    // 設定元件
    $('.ui.rating').rating('disable')

    $('#logout').click(function() {
        $.ajax('ajax/logout.php', {
            async: true,
            success: function(value) {
                window.location.reload()
            }
        })
    })

    $('#login-modal').modal({
        blurring: true,
        onApprove: function (element) {
            var action = element.attr('id')
            if (action.includes('register')) {
                window.location.assign('signup.php')
            } else if (action.includes('login')) {
                var result = undefined

                $.ajax('ajax/login.php', {
                    async: false,
                    method: 'post',
                    timeout: 500,
                    data: {
                        username: $('#login-modal input[type=text]').val(),
                        password: $('#login-modal input[type=password]').val()
                    },
                    success: function(value) {
                        if (value == 'true') {
                            result = true;
                            window.location.reload()
                        } else {
                            $('#login-modal form').addClass('error')
                            $('#login-modal div.error.message').text('登入失敗，請檢查帳號密碼。')
                            result = false;
                        }
                    }
                })

                return result
            } else {
                console.error('使用者介面邏輯錯誤')
                return false;
            }
        }
    })
    $('#cart-modal').modal({
        blurring: true,
        onShow: function() {
            $('#cart-modal div.content').addClass('loading')
            // 執行 AJAX 取得資料
            fetchCart(function(cart) {
                var total = 0
                $('#cart-modal div.content table tbody').empty();
                for (var x of cart) {
                    $('#cart-modal div.content table tbody').append(
                        $(`<tr class="cartrow" data-id="${x.itemID}">
                                <td>${x.itemName}</td>
                                <td class="itemPrice" data-price="${x.itemPrice}">
                                    $ ${x.itemPrice}
                                </td>
                                <td>
                                    <button class="ui red basic icon button quantity minus" onclick="quantity_minus(${x.itemID})">
                                        <i class="minus icon"></i>
                                    </button>
                                    <span data-quantity="${x.quantity}" class="quantity"></span>
                                    <button class="ui green basic icon button quantity add" onclick="quantity_plus(${x.itemID})">
                                        <i class="plus icon"></i>
                                    </button>
                                </td>
                                <td>
                                    $
                                    <span data-price-subtotal="${x.itemPrice * x.quantity}" class="price subtotal"></span>
                                </td>
                                <td>
                                    <button class="ui inverted red icon button" onclick="quantity_zero(${x.itemID})">
                                        移除
                                    </button>
                                </td>
                            </tr>`
                        )
                    )

                    total += x.itemPrice * x.quantity;
                }

                $('#cart-modal div.content').removeClass('loading')
                $('#cart-modal span.price.total').attr('data-price-total', total)
            })
        }
    })

    $('#added-to-cart-modal').modal({
        blurring: true,
        onShow: function () {
            setTimeout(function () {
                $('#added-to-cart-modal').modal('hide')
            }, 1400)
        }
    })

    // 事件
    $('.multiple.dropdown.toggle').popup({
        inline: true,
        hoverable: true,
        position: 'bottom left'
    })
    $('.dropdown.toggle:not(.multiple)').popup({
        inline: true,
        hoverable: true,
        position: 'bottom right'
    })
    $('.ui.dropdown').dropdown({
        on: 'hover',
    })

    $('#login-modal-show').click(function () {
        $('#login-modal').modal('show')
    })
    $('#cart-modal-show').click(function () {
        $('#cart-modal').modal('show')
    })
    $('.add.to.cart.button').click(function () {
        $('#added-to-cart-modal').modal('show')
    })

    $.api.settings.api = {
        cache: false,
        search: '/ajax/search.php?query={query}'
    }

    $('.ui.search')
        .search({
            type: 'category',
            verbose: true
        })
    ;
})

// Calls callback with response
function fetchCart(callback) {
    $.ajax('/ajax/cart.php', {
        cache: false,
        success: callback
    })
}

/**
 * @param item
 * @param quantity
 * @param callback
 *
 * @return true of false on callback
 */
function updateCartItem(item, quantity, callback) {
    $.ajax('/ajax/cart.php', {
        method: 'POST',
        data: JSON.stringify({
            action: 'update',
            itemID: item,
            quantity: quantity
        }),
        contentType: "application/json",
        async: false,
        success: function(res) {
            if (res == 'true') {
                if (quantity == 0) {
                    $('*[data-pid=' + item + '] *.cart-button').removeClass('purchased')
                }
                callback(true)
            }
            else callback(false)
        },
        error: function() { callback(false) }
    })
}

function addCartItem(item, callback) {
    $.ajax('/ajax/cart.php', {
        method: 'POST',
        data: JSON.stringify({
            action: 'insert',
            itemID: item
        }),
        contentType: "application/json",
        async: false,
        success: function(res) {
            if (res == 'true') {
                $('*[data-pid=' + item + '] *.cart-button').addClass('purchased')
                callback(true)
            }
            else callback(false)
        },
        error: function() { callback(false) }
    })
}

function removeCartItem(item, callback) {
    $.ajax('/ajax/cart.php', {
        method: 'POST',
        contentType: "application/json",
        data: JSON.stringify({
            action: 'remove',
            itemID: item
        }),
        success: function(res) {
            if (res == 'true') {
                $('*[data-pid=' + item + '] *.cart-button').removeClass('purchased')
                callback(true)
            }
            else callback(false)
        },
        error: function() { callback(false) }
    })
}

function clearCart(callback) {
    $.ajax('/ajax/cart.php', {
        method: 'POST',
        contentType: "application/json",
        data: JSON.stringify({
            action: 'clear'
        }),
        success: function(res) {
            if (res == 'true') {
                $('#cart-modal div.content table tbody').empty()
                $('#added-to-cart-modal').modal('hide')
            }
            else callback(false)
        },
        error: function() { callback(false) }
    })
}

function quantity_plus(id) {
    "use strict";
    var tr = $('#cart-modal tr[data-id=' + id + ']')
    tr.addClass('dirty')

    var itemPrice = +tr.find('.itemPrice').attr('data-price')

    var quantity = tr.find('span.quantity')
    quantity.attr('data-quantity', +quantity.attr('data-quantity') + 1);

    var delta = itemPrice;

    var subtotal = tr.find('span.subtotal')
    subtotal.attr('data-price-subtotal', +subtotal.attr('data-price-subtotal') + delta)
    var total = $('#cart-modal span.total')
    total.attr('data-price-total', +total.attr('data-price-total') + delta)
}

function quantity_minus(id) {
    "use strict";
    var tr = $('#cart-modal tr[data-id=' + id + ']')
    var quantity = tr.find('span.quantity')
    if (+quantity.attr('data-quantity') == 0) { return }

    tr.addClass('dirty')

    var itemPrice = +tr.find('.itemPrice').attr('data-price')

    quantity.attr('data-quantity', +quantity.attr('data-quantity') - 1);

    var delta = -itemPrice;

    var subtotal = tr.find('span.subtotal')
    subtotal.attr('data-price-subtotal', +subtotal.attr('data-price-subtotal') + delta)
    var total = $('#cart-modal span.total')
    total.attr('data-price-total', +total.attr('data-price-total') + delta)
}

function quantity_zero(id) {
    "use strict";
    var tr = $('#cart-modal tr[data-id=' + id + ']')
    var quantity = tr.find('span.quantity')

    tr.addClass('dirty')

    var itemPrice = +tr.find('.itemPrice').attr('data-price')

    quantity.attr('data-quantity', 0);

    var subtotal = tr.find('span.subtotal')
    var total = $('#cart-modal span.total')
    total.attr('data-price-total', +total.attr('data-price-total') - +subtotal.attr('data-price-subtotal'))

    subtotal.attr('data-price-subtotal', 0)

}

function updateCart(callback) {
    "use strict";

    $('#cart-modal tr.dirty').each(function(i, row) {
        var row = $(row)

        var id = +row.attr('data-id')
        console.dir(row)
        var quantity = +row.find('span.quantity').attr('data-quantity')

        updateCartItem(id, quantity, function(result) {
            if (result) {
                console.log('成功')
                row.removeClass('dirty')
            }
            else {
                console.log('失敗')
            }
        })
    })
    if (callback) callback()
}

function addToCart(id) {
    "use strict";
    addCartItem(id, function() {
        $('#added-to-cart-modal').modal('show')
    })
}

function checkout() {
    "use strict";
    updateCart(function() {
        window.location.assign('checkout.php')
    })
}

// Cart ID -> cart-modal
