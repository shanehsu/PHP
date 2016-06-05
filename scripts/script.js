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
                window.location.assign('register.php')
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
                            // alert('登入失敗，請檢查帳號密碼。')
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
        blurring: true
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
        // position : 'bottom left'
    })

    $('#login-modal-show').click(function () {
        $('#login-modal').modal('show')
    })
    $('#cart-modal-show').click(function () {
        $('#cart-modal').modal('show')
    })
    $('.quantity.add').click(function () {
        var element_quantity = $(this).closest('td').find('span.quantity')
        var element_subtotal = $(this).closest('tr').find('span.price.subtotal')

        var price_per_item = $(this).closest('tr').find('span.price.per.item').attr('data-price-per-item')
        var quantity = +element_quantity.attr('data-quantity') + 1
        var subtotal = +quantity * +price_per_item

        element_quantity.attr('data-quantity', quantity)
        element_subtotal.attr('data-price-subtotal', subtotal)

        update_total()
    })
    $('.quantity.minus').click(function () {
        var element_quantity = $(this).closest('td').find('span.quantity')
        var element_subtotal = $(this).closest('tr').find('span.price.subtotal')

        var price_per_item = $(this).closest('tr').find('span.price.per.item').attr('data-price-per-item')
        var quantity = +element_quantity.attr('data-quantity') - 1
        if (quantity < 0) {
            return
        }
        var subtotal = +quantity * +price_per_item

        element_quantity.attr('data-quantity', quantity)
        element_subtotal.attr('data-price-subtotal', subtotal)

        update_total()
    })

    $('.add.to.cart.button').click(function () {
        $('#added-to-cart-modal').modal('show')
    })
})

function update_total() {
    var total = 0
    $('#cart-modal span.price.subtotal').each(function (index, element) {
        var subtotal = +$(element).attr('data-price-subtotal')
        total += subtotal
    })

    $('#cart-modal div.actions #cart-modal-checkout div.hidden.content span.price.total').attr('data-price-total', total)
}
