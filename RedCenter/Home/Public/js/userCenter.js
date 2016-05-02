$.post(':U("Home/Index/newHelpNum")', function(res) {
    var res = JSON.parse(res);
    $('#new-helper').text(res);
});
$.post(':U("Home/Index/linkNum")', function(res) {
    var res = JSON.parse(res);
    $('#product-num').text(res);
});


$.post(':U("Home/Index/selfInfo")', function(res) {
    var res = res;
    $('#my-score').text(res.score);
});

$.post(':U("Home/Index/newNewsNum")', function(res) {
    var res = JSON.parse(res);
    $('user-message').text('您有'+ res + '条消息');
})
$.post(':U("Home/Index/getNew")', function(res) {
    var res = res;
    var page_num = parseInt(res.total) / 5;

    var $page_sub_fragment = $('.page-sub').eq(0);
    var $next_page_fragment = $('#user-new-next-page');
    $next_page_fragment.remove();
    for(var i = 0; i < page_num; i ++) {
        $page_sub_fragment.find(i).text(i+1);
        $('.contain-pageG').append($page_sub_fragment);
    }
    res.article.forEach(function(item, index, arr) {
        $('.contain-pageG').append('<a href="##">' +
                                        '<li class="contain-new">' +
                                            '<img src="__PUBLIC__/img/'+item.pro_id + '.png" alt="图标">' +
                                            '<div class="contain-new-detail">' +
                                                '<h3>[' + item.pro_name + ']' + item.title +
                                                    '<span class="new-unread" id="unread-label" style="display:none">未读</span>' +
                                                '</h3>'+
                                                '<span class="new-time">'+ item.time + '<img src="__PUBLIC__/img/time.png" alt="时间"></span>' +
                                                '<p class="new-text">'+ item.content + '</p>'+
                                            '</div>'+
                                        '</li>'+
                                    '</a>');
    });

    var unread_num = parseInt($('user-message').text().match(/\d+/));

    for(var i= 0; i < unread_num; i++) {
        $('.new-unread').eq(i).show();
    }

});





// $.post(':U("Home/Index/page")', {'page': } function(res) {
//     var res = JSON.parse(res);
//     $('#my-score').text(res.score);
// });

