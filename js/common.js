//全局配置，没有登录则跳到登录
var userId = $.fn.cookie('userId');
if(!userId){ //如果没有这个用户的custId
	location.href = "login.html";
}
