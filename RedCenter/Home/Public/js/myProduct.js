$.post('{:U("Home/Index/returnData")}',{type: 'linkInfo'}, function(res) {
    var res = JSON.parse(res);
    res.forEach( function(item, index,arr) {
        $('.product-name').eq(index + 1).innerHTML = '<img src="/__PUBLIC__/img/'+item.id+'png">' + item.project;
    });
});


// $.post(':U("Home/Index/changeLink")', function(res) {
//     var res = JSON.parse(res);

// });