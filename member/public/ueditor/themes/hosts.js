var hosts = {
	NCHC自由软件实验室(台湾): "free.nchc.org.tw", 
	Ubuntu正体中文站(台湾): "ftp.ubuntu-tw.org", 
	元智大学(台湾): "ftp.yzu.edu.tw", 
	南台科技大学(台湾): "ftp.stust.edu.tw", 
	国立暨南国际大学(台湾): "ftp.ncnu.edu.tw", 
	Linux运维派: "mirrors.skyshe.cn", 
	NCHC自由软件实验室(台湾): "free.nchc.org.tw", 
	Ubuntu正体中文站(台湾): "ftp.ubuntu-tw.org", 
	上海交通大学: "ftp.sjtu.edu.cn", 
	中国地质大学: "mirrors.cug.edu.cn", 
	中国开源软件中心: "mirrors.oss.org.cn", 
	中国科学技术大学: "mirrors.ustc.edu.cn", 
	中科院开源软件协会: "mirrors.opencas.cn", 
	元智大学(台湾): "ftp.yzu.edu.tw", 
	兰州大学: "mirror.lzu.edu.cn", 
	凝聚网络安全工作室: "mirrors.cnssuestc.org", 
	北京交通大学: "mirror.bjtu.edu.cn", 
	北京理工大学: "mirror.bit.edu.cn", 
	华中科技大学: "mirrors.hust.edu.cn", 
	华中科技大学联创团队: "mirrors.hustunique.com", 
	南京信息工程大学: "mirrors.duohuo.org",
	南台科技大学(台湾): "ftp.stust.edu.tw",
	南开大学: "ftp.nankai.edu.cn", 
	厦门大学: "mirrors.xmu.edu.cn", 
	吉林大学: "mirrors.jlu.edu.cn", 
	哈尔滨工业大学: "run.hit.edu.cn", 
	国立暨南国际大学(台湾): "ftp.ncnu.edu.tw", 
	天津大学: "mirror.zyrj.org", 
	山东理工大学: "mirrors.sdutlinux.org", 
	开源中国: "mirrors.oschina.net", 
	搜狐开源: "mirrors.sohu.com", 
	江苏开放大学: "mirrors.jstvu.edu.cn", 
	浙江大学: "mirrors.zju.edu.cn", 
	清华大学: "mirrors.tuna.tsinghua.edu.cn", 
	电子科技大学: "mirrors.scie.in", 
	西南大学: "mirrors.linuxstory.org", 
	西安电子科技大学: "ftp.xdlinux.info", 
	重庆大学: "mirrors.cqu.edu.cn", 
	阿里云: "mirrors.aliyun.com", 
	首都在线科技股份有限公司: "mirrors.yun-idc.com",
}

var exec = require('child_process').exec;
exec('ping baidu.com', function(error, stdout, stderr) {
	if (error) console.error(error)
	else conosle.log(stdout);
})