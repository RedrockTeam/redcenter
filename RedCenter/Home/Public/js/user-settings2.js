$(function(){

    var Li = $('.set-title');
    var name = $('.basic-massage input').eq(0);
    var input_massage = $('.basic .basic-massage input');
    var input_password = $('.input-password');
    // var password_btn = $('.set-info p button');


    //滑动导航切换
    Li.mouseover(function(){
        var liindex = Li.index(this);
        var liWidth = Li.width();
        Li.removeClass('set-title-show');
        $(this).addClass('set-title-show');
        $('.set-title-underline').animate({'left' : liindex * (liWidth+24) -2+ 'px'},300);
        // $('.set-info').eq(liindex).fadeIn(100).siblings('form.set-info').hide();
        $('.set-info').removeClass('set-show');
        $('.set-info').eq(liindex).addClass('set-show');
    })  

    //判断昵称长度
    
    name.blur(function(){
        if(name.val().length >6 ){
            $('.set-info p').remove();
            $(this).after('<p style ="color:red;font-size:12px;">昵称不可以超过6个字哦!</p>');
        }
    })

    //表单验证

    input_password.eq(1).blur(function(){
        $('.set-info  p').remove();
        if($(this).val() === input_password.eq(0).val() && $(this).val() !==''){
           $(this).after('<p style ="color:red;font-size:12px;">密码不可以和原密码相同哦!</p>');
        }

    }) 

    input_password.eq(2).blur(function(){
        $('.set-info  p').remove();
        if($(this).val() !== input_password.eq(1).val()){
           $(this).after('<p style ="color:red;font-size:12px;">两次输入密码不一致哦!</p>');
        }

    })

    $('.basic-btn').click(function(){
       $('.set-info span').remove();
     if( input_massage.val()===''){
        $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;请输入信息哦!</sapn>');
      }
    })

    $('.safe-btn').click(function(){
       $('.set-info span').remove();
     if( input_password.val()===''){
        $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;请输入信息哦!</sapn>');
      }
    })

   //交互
   $('.basic-btn').click(function(){
       
      $('.set-info span').remove();
      if( input_massage.val()===''){
        $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;请输入信息哦!</sapn>');
        return false;
      }else{

        $.post('U("Home/Index/set")', $('.basic-info').serialize(),function(){
           $(this).after('<span style ="color:green;font-size:12px;">&nbsp;&nbsp;&nbsp;提交成功哦!</sapn>');
        })
      }      
   })

   //验证密码是否正确
    input_password.eq(0).blur(function(){
        $.post('U("Home/Index/setPassword")'),$(this).val(),function(date,status){
            if(this.value !== password){
                alert('密码不正确');
                }
        }    
    })

    $('.safe-btn').click(function(){
      
      $('.set-info span').remove();
      if( input_password.val()===''){
        $(this).after('<span style ="color:red;font-size:12px;">&nbsp;&nbsp;&nbsp;请输入信息哦!</sapn>');
      }else{
         $.post('U("Home/Index/setPassword")', $('.set-info').eq(1).serialize(),function(){
          $(this).after('<span style ="color:green;font-size:12px;">&nbsp;&nbsp;&nbsp;提交成功哦!</sapn>');
        })
      }
    })
   


});