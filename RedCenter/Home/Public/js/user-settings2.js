$(function(){

    var Li = $('.set-title');
    var name = $('.basic-massage input').eq(0);
    var input_password = $('.input-password');
    var password_btn = $('.set-info p button');


    //滑动导航切换
    Li.mouseover(function(){
        var liindex = Li.index(this);
        var liWidth = Li.width();
        Li.removeClass('set-title-show');
        $(this).addClass('set-title-show');
        $('.set-title-underline').animate({'left' : liindex * liWidth +8+ 'px'},300);
        // $('.set-info').eq(liindex).fadeIn(100).siblings('form.set-info').hide();
        $('.set-info').removeClass('show');
        $('.set-info').eq(liindex).addClass('show');
    })  


    //切换
    // Li.click(function(){
    //     var liindex = Li.index(this);
    //     $('.set-info').eq(liindex).fadeIn(100).siblings('form.set-info').hide();
    //     $(this).addClass('set-title-show');
    // })

    //判断昵称长度
    
    $('.basic-info tr td button').click(function(){
        if(name.val().length >6 ){
            $('.basic-info tr td span').remove();
            $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;昵称不可以超过6个字哦!</span>');
        }
    })

    //判断密码
    input_password.eq(1).blur(function(){
        $('.set-info p span').remove();
        if($(this).val() === input_password.eq(0).val() && $(this).val() !==''){
           password_btn.after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;密码不可以和原密码相同哦!</span>');
        }

    }) 

    input_password.eq(2).blur(function(){
        $('.set-info p span').remove();
        if($(this).val() !== input_password.eq(1).val()){
           password_btn.after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;两次输入密码不一致哦!</span>');
        }

    })    

    password_btn.click(function(){
        if(input_password.siblings('input.input-password').val() === ''){
            $('.set-info p span').remove();
            $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;请填写信息!</span>');
        }
    })

   //表单
   $('.basic-info tr td button').click(function(){
     $.post('U("Home/Index/set")', $('.set-info').eq(0).serialize(),function(){
        $('.basic-info tr td span').remove();
            $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;修改成功!</span>');
     })
   })

    input_password.eq(0).blur(function(){
        $.post('{:U("Home/Index/setPassword")}'),$(this).val(),function(date,status){
            if(this.value !== password){
                alert('密码不正确');
                }
        }    
    })

    password_btn.click(function(){
     $.post('{:U("Home/Index/setPassword")}', $('.set-info').eq(1).serialize(),function(){
        $('.set-info p span').remove();
            $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;修改成功!</span>');
     })
   })


});