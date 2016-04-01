$(document).ready(function () {
    $.ajax({
        url: '/main/orderedproduct/get-attached-to-order',
        dataType: 'json',
        success: function(data, statusText, jqXHR) {
            for(var i=0; i<data.length; i++) {
                var input = $('[value="' + data[i].kodpart + '"]');
                var divs = input.parent().parent();
                var notordered = divs.find('.product.notordered');
                var ordered = divs.find('.product.ordered');
                notordered.css('display', 'none');
                ordered.css('display', 'block');
                ordered.css('display', 'block');
                ordered.find('a').css('display', 'block');
                var span = ordered.find('a span');
                span.text('(' + data[i].kolz + ')');
                console.log(input);
                
            }
        }
    });
});