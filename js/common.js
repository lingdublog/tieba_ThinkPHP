//全局配置，没有登录则跳到登录


if (location.pathname.indexOf("addPost")>-1||location.pathname.indexOf('replyPost')>-1) {//这几个页面需要判断登录
	var userId = $.fn.cookie('userId');
	var returnUrl = location.href;
	if(!userId){ //如果没有这个用户的custId
		location.href = "login.html?returnUrl="+returnUrl;
	}
}
var host = 'http://localhost:8080/tieba/API/tieba/Home/';


//获取get参数方法
function getLocationVal(para){
	var temp = location.search.split(para+"=")[1] || "";
	return temp.indexOf("&")>=0 ? temp.split("&")[0] : temp;
}