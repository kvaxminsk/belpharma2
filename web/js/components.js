var orderedProducts =null;
$( document ).ready(function() {
    $.ajax({
        url: '/main/orders/get-counters',
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            var counters = data;
            $('a.ordered-products').text('Оформить заказ (' + counters.orderedProducts + ')');
            $('#info span').text(counters.totalPrice);
            orderedProducts = counters.orderedProducts;
        }
    });
});

updateCounters = function () {
    $.ajax({
        url: '/main/orders/get-counters',
        dataType: 'json',
        success: function (data, textStatus, jqXHR) {
            var counters = data;
            $('a.ordered-products').text('Оформить заказ (' + counters.orderedProducts + ')');
            $('#info span').text(counters.totalPrice);
            orderedProducts = counters.orderedProducts;
        }
    });
};
$('.quont-minus').click(function () {
    var $input = $(this).parent().find('input.kol');
    var count = parseInt($input.val()) - 1;
    count = count < 1 ? 1 : count;
    $input.val(count);
    $input.change();
    return false;
});
$('.quont-plus').click(function () {
    var $input = $(this).parent().find('input.kol');
    $input.val(parseInt($input.val()) + 1);
    $input.change();
    return false;
});
$('.add-product').click(function () {
    var id = $(this).parent().find('input.id').val();
    var kodpart = $(this).parent().find('input.kodpart').val();
    var kol = $(this).parent().find('input.kol').val();
    if(orderedProducts < 200) {
        $.ajax({
            url: '/main/orderedproduct/add-to-product?id=' + kodpart,
            type: 'POST',
            data: {
                'id': id,
                'kol': kol
            },
            success: function (result) {
                var notordered = $('.product.notordered.' + id);
                notordered.css('display', 'none');
                var ordered = $('.product.ordered.' + id);
                ordered.css('display', 'block');
                ordered.find('a').css('display', 'block');
                var span = ordered.find('a span');
                span.text('(' + kol + ')');
                updateCounters();
            },
            error: function () {
                console.log('err');
            }
        });
    }
    else {
        alert('Ограничение: одна заявка не может содержать более 200 товаров');
    }

    return false;
});
$('.add-the-product').click(function () {
    var pathname = window.location.pathname;
    var orderId = pathname.split('/').pop();
    var id = $(this).parent().find('input.id').val();
    var kodpart = $(this).parent().find('input.kodpart').val();
    var kol = $(this).parent().find('input.kol').val();
    $.ajax({
        url: '/main/orderedproduct/add-to-product-for-order?id=' + kodpart + '&orderId=' + orderId,
        type: 'POST',
        data: {
            'id': id,
            'kol': kol
        },
        success: function (result) {
            var notordered = $('.product.notordered.' + id);
            notordered.css('display', 'none');
            var ordered = $('.product.ordered.' + id);
            ordered.css('display', 'block');
            ordered.find('a').css('display', 'block');
            var span = ordered.find('a span');
            span.text('(' + kol + ')');
            updateCounters();
        },
        error: function () {
            console.log('err');
        }
    });
    return false;
});
$('.product.ordered a').click(function () {
    $(this).css('display', 'none');
    $(this).parent().parent().find('.product.notordered').css('display', 'block');
    console.log('notordered');
    return false;
});
var descHandler = function (data, statusText, jqXHR) {
    var rub = ' руб.';
    var pieces = ' шт.';
    $('.modal').css('display', 'block');
    $('div.modal h2').html(data.tn + ' <span class="english">(' + data.mnn + ')</span>');
    $('div.modal div.description').text(data.nshort3);
    var table = $('div.modal div.table-cover table tbody');
    table.find('tr td#p1').text(data.mnn);
    table.find('tr td#p2').text(data.tn);
    table.find('tr td#p3').text(data.nshort3);
    table.find('tr td#p4').text(data.namepr);
    table.find('tr td#p5').text(data.country);
    table.find('tr td#p6').text(data.otd);
    if (data.osnls == 1) {
        table.find('tr td#p7').text('ОС');
    } else {
        table.find('tr td#p7').text('-');
    }
    table.find('tr td#p9').text(data.spar);
    table.find('tr td#p10').text(data.goden_do);
    table.find('tr td#p19').text(data.nds);
    table.find('tr td#p11').text(data.cenopt + rub);
    table.find('tr td#p12').text(data.cenrozn + rub);
    table.find('tr td#p13').text(data.kol + pieces);
    table.find('tr td#p15').text(data.vidtovara);
    if (data.obnalichie == 1) {
        table.find('tr td#p16').text('Обязательно');
    } else {
        table.find('tr td#p16').text('-');
    }
    table.find('tr td#p17').text(data.kolotgr + pieces);
    table.find('tr td#p18').text(data.vidpost);
    return false;
};
var isProductsPage = function() {
    var pathname = window.location.pathname;
    var partsAddress = pathname.split('/');
    var actionName = partsAddress.pop();
    if(actionName == 'products') {
        return true;
    } else { 
        return false;
    }
};
$('.desc-view').click(function () {
    var key = $(this).data('key');
    $.ajax({
        url: '/main/products/desc-view?id=' + key,
        type: 'post',
        dataType: 'json',
        success: descHandler
    });
    return false;
});
$('.desc-link').click(function () {
    var key = $(this).parent().parent().data('key');
    var what = isProductsPage();
    if(what) {
        $.ajax({
            url: '/main/products/desc-view?id=' + key,
            type: 'post',
            dataType: 'json',
            success: descHandler
        });
    } else {
        $.ajax({
            url: '/main/products/desc-view-ordered?id=' + key,
            type: 'post',
            dataType: 'json',
            success: descHandler
        });
    }
    return false;
});
$('div.modal div.close').click(function () {
    $('div.modal').css('display', 'none');
});
$('.clear-input').click(function() {
    $(this).parent().parent().find('input').val('');
    return false;
});
$('.clear-button').click(function() {
    $('form#search-product-form div.col-sm-4 div.form-group div div.input-group input').val('');
    $('#productssearch-osnls :nth-child(1)').attr('selected', 'selected');
    $('#productssearch-vidpost :nth-child(1)').attr('selected', 'selected');
    $('#productssearch-country :nth-child(1)').attr('selected', 'selected');
    $('.select2-selection__rendered').text('');
    
    return false;
});