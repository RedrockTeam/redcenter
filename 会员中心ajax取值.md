会员中心ajax取数据
===================

`注释` :
采用post传参,所有url值为{:U('Home/Index/Return')},必传参数：dataType


##如果dataType不是指定的值：
	

参数：dataType = ''    //为空

返回：{"errorInfo":"bad request"}
  
`------------------------------------------`

参数:dataType =  //不是指定的值而且非空

返回:{"errorInfo":"this function does not exist"}

##用户基本信息(网名，头像，店铺，个性签名)
	
参数：dataType = 'basicInfo';

返回：数组

<pre>
Array
(
    [nickname] => sadf  
    [hedimg] => head_img/m.png   
    [myshop] =>     
    [mysign] =>
     
)
</pre>
##用户所有信息

	
参数：dataType = 'getSelfInfo';

返回：数组

<pre>
Array
(
    [id] => 68071
    [stu_num] => 2014211547
    [nickname] => sadf
    [status] => 1
    [real_name] => 王良
    [email] => 2014211547@stu.cqupt.edu.cn
    [last_login_ip] => 
    [last_login_time] => 
    [last_month_rank] => 0
    [last_year_rank] => 0
    [month_rank] => 6
    [score_update_time] => 1451487521
    [year_rank] => 257
    [score] => 109
    [score_month] => 9
    [experience] => 9
    [gender] => 男
    [salt] => NxUBZR
    [headimg] => 
    [weixin_visit_num] => 110
    [identify_code] => 0
    [link_id] => ["2","3"]
    [read_help] => 7
    [read_news] => 1
    [myshop] => asdf
    [mysign] => asdf
    [level] => 1
    [last_time] => 
    [headImage] => head_img/m.png
)
</pre>

##链接产品数量：
	
参数：dataType = 'linkNum'

返回：2     //单个数字
##链接产品信息：
	
参数：dataType = 'linkInfo'

返回：数组

<pre>
Array
(
    [unlinked] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [project] => 微信
                    [project_id] => cyxbs
                )

            [1] => Array
                (
                    [id] => 4
                    [project] => 锦瑟南山
                    [project_id] => jsns
                )

            [2] => Array
                (
                    [id] => 5
                    [project] => 掌上重邮
                    [project_id] => zscy
                )

            [3] => Array
                (
                    [id] => 6
                    [project] => BBS
                    [project_id] => BBS
                )

            [4] => Array
                (
                    [id] => 7
                    [project] => 云盘
                    [project_id] => yunpan
                )

        )

    [linked] => Array
        (
            [0] => Array
                (
                    [id] => 2
                    [project] => BTdown铺
                    [project_id] => BTdown
                )

            [1] => Array
                (
                    [id] => 3
                    [project] => 拾货
                    [project_id] => market
                )

        )

)
</pre>
##添加|删除链接：
	
参数：dataType = 'changeLink';changeType='add'|'del';linkId=3;

返回：true  false
##更改密码：
	
参数：dataType='changePass';old_pass='';new_pass='';conf_pass=''（再次输入的密码）

返回：true  false
##修改个人信息（昵称，店铺。。）：
	
参数：type = 'chnageInfo';nickname='（网名）';myshop='（店铺）';mysign='（个性签名）';photo = '(上传的心头像)'

返回：true|false
##未读新帮助个数
	
参数：dataType = 'newHelpNum'

返回：3  单个数字
##未读新消息个数
	
参数：dataType = 'newNewsNum'

返回：0 单个数字

##获取一页6篇文章

参数:dataType = 'getHelp';page = 1,2,3...

返回:数组

<pre>
array(
	['total'] => 35,    //数据库存的所有帮助的总条数
	['article'] => array(     //一页上有六篇文章
		[0] => array(
			['id'] => 1,
			['title'] => '小帮手帮助文章',
			['pro_id'] => 1,
			['pro_name'] => '重邮小帮手',
			['content'] => 'bla bla bla ...',
			['writer'] => '管理员吧',
			['time'] => 2016-03-09 22:25:56;
		)
		
		[1]
		[2]
		...
		[5] =>array(
			['id'] => 1,
			['title'] => '小帮手帮助文章',
			['pro_id'] => 1,
			['pro_name'] => '重邮小帮手',
			['content'] => 'bla bla bla ...',
			['writer'] => '管理员吧',
			['time'] => 2016-03-09 22:25:56;
		)
	)
)
</pre>

##获取一页5篇消息

参数:dataType = 'getNew';page = 1,2,3...

返回:数组

<pre>
array(
	['total'] => 35,    //数据库存的所有帮助的总条数
	['article'] => array(     //一页上有六篇文章
		[0] => array(
			['id'] => 1,
			['title'] => '小帮手帮助文章',
			['pro_id'] => 1,
			['pro_name'] => '重邮小帮手',
			['content'] => 'bla bla bla ...',
			['writer'] => '管理员吧',
			['time'] => 2016-03-09 22:25:56;
		)
		
		[1]
		[2]
		...
		[4] =>array(
			['id'] => 1,
			['title'] => '小帮手帮助文章',
			['pro_id'] => 1,
			['pro_name'] => '重邮小帮手',
			['content'] => 'bla bla bla ...',
			['writer'] => '管理员吧',
			['time'] => 2016-03-09 22:25:56;
		)
	)
)
</pre>

##各种积分
	
参数：dataType = 'getAllScore'

返回：数组
<pre>
Array
(
    [byMonth] => Array
        (
            [total] => 0
            [cyxbs] => 0
            [BTdown] => 0
            [market] => 0
            [jsns] => 0
            [zscy] => 0
            [BBS] => 0
            [yunpan] => 0
        )

    [byYear] => Array
        (
            [total] => 1
            [cyxbs] => 1
            [BTdown] => 0
            [market] => 0
            [jsns] => 0
            [zscy] => 0
            [BBS] => 0
            [yunpan] => 0
        )

)
</pre>

##在各产品上的登录次数
	
参数：dataType = 'logTime'

返回：数组,只返回当前可用的三个产品的次数,其他为0
<pre>
array(
    'zscy' => 23,   //掌上重邮
    'hyzx' => 34,	//会员中心	
    'cyxbs' => 45	//重邮小帮手
)
</pre>

  
`------------------------------------------`


##发布文章:
URL: Admin/Publish/addArticle

方式:POST  

返回:true | false

参数:

type = 'new(发布的是消息)或help(发布的是帮助文章)'

title = '标题'

content = '内容'

pro_id  = '为哪个项目写的'

pro_name = '为哪个项目写的'


.

        pro_id=0时pro_name=所有人可见


.

		pro_id=1时pro_name=重邮小帮手

.

		pro_id=2时pro_name=BTdown铺

.

		pro_id=3时pro_name=拾货

		
.

        pro_id=4时pro_name=锦瑟南山


.

        pro_id=5时pro_name=掌上重邮


.

        pro_id=6时pro_name=云盘


.

        pro_id=7时pro_name=BBS
        


