$(function() {
  // 設定元件
  $('.ui.rating').rating('disable')
  $('#login-modal').modal({
    blurring: true,
    onApprove: function(element) {
      var action = element.attr('id')
      if (action.includes('register')) {
        // 導向至註冊畫面
        return false
      } else if (action.includes('login')) {
        // 登入並導向至回現在頁面
        return true
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
    onShow: function() {
      setTimeout(function() {
        $('#added-to-cart-modal').modal('hide')
      }, 1400)
    }
  })

  // 事件
  $('#world-popup-toggle').popup({
    inline: true,
    hoverable: true,
    position : 'bottom left'
  })
  $('#login-modal-show').click(function() {
    $('#login-modal').modal('show')
  })
  $('#cart-modal-show').click(function() {
    $('#cart-modal').modal('show')
  })
  $('.quantity.add').click(function() {
    var element_quantity = $(this).closest('td').find('span.quantity')
    var element_subtotal = $(this).closest('tr').find('span.price.subtotal')

    var price_per_item = $(this).closest('tr').find('span.price.per.item').attr('data-price-per-item')
    var quantity = +element_quantity.attr('data-quantity') + 1
    var subtotal = +quantity * +price_per_item

    element_quantity.attr('data-quantity', quantity)
    element_subtotal.attr('data-price-subtotal', subtotal)

    update_total()
  })
  $('.quantity.minus').click(function() {
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

  $('.add.to.cart.button').click(function() {
    $('#added-to-cart-modal').modal('show')
  })
})

function update_total() {
  var total = 0
  $('#cart-modal span.price.subtotal').each(function(index, element) {
    var subtotal = +$(element).attr('data-price-subtotal')
    total += subtotal
  })

  $('#cart-modal div.actions #cart-modal-checkout div.hidden.content span.price.total').attr('data-price-total', total)
}
