$(function(){

    var Li = $('.set-title');
    //滑动导航
    Li.mouseover(function(){
        var liindex = Li.index(this);
        var liWidth = Li.width();
        $('.set-title-underline').animate({'left' : liindex * liWidth +10+ 'px'},300);
    })
    //切换
    Li.click(function(){
        var liindex = Li.index(this);
        $('.set-info').eq(liindex).fadeIn(100).siblings('form.set-info').hide();
    })
    //判断昵称长度
    var name = $('.basic-massage input').eq(0);
    $('.basic-info tr td button').click(function(){
        if(name.val().length >6 ){
            $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;昵称不可以超过6个字哦!</span>');
        }
    })
    //判断密码
    var input_password = $('.input-password');
    var password_btn = $('.set-info p button')
    input_password.eq(1).blur(function(){
        $('.set-info p span').remove();
        if($(this).val() == input_password.eq(0).val()){
           password_btn.after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;密码不可以和原密码相同哦!</span>');
        }

    }) 

    input_password.eq(2).blur(function(){
        $('.set-info p span').remove();
        if($(this).val() != input_password.eq(1).val()){
           password_btn.after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;两次输入密码不一致哦!</span>');
        }

    })    

});