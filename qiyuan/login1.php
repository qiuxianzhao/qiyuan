<?php
 //登录页面
  // session_start();
  define('IS_LOGIN',1);
  require "./include/common.conf.php";
  if(isset($_GET['card']) && $_GET['card'] == 1){
      $table = "student";
    }else{
      $table = 'teacher';
    }
  if($_POST){
    //接收数据，并校验
    $username = $_POST['username'];
    $password = $_POST['password'];
 
    
    $sql = "SELECT `name`,`id`,`avator` FROM `$table` where `username`='$username' AND `password`='$password' AND `status`=1";
    // echo $sql;die;
    $info = getOne($con,$sql);
	
    if(empty($info)){
      showMsg('登录失败！请重新登录！');
    }else{
		$_SESSION['username']='username';
    $_SESSION['password']='password';
		$_SESSION['is_login']=1;
		
		//$_session['admin']=1;
		
      //保存cookie信息
      //setcookie('is_login',1); 设置登录状态
      //setcookie('uid',$info['id']);
      //setcookie('uname',$info['name']);
      //setcookie('avator',$info['avator']); 
      //更新最后登录资料
      //$data['last_login_time'] = time(); //最后登录时间 
      //$data['last_login_ip'] = $_SERVER['REMOTE_ADDR']; //最后登录IP
      //edit($con,'student',$data,' id= '.$info['id']);
      showMsg('登录成功！','./main.php');
    }
//保持session  的数值通过传参  赋值

 }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>奇猿网络后台管理中心</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="js/jquery.js"></script>
<script src="js/cloud.js" type="text/javascript"></script>

<script language="javascript">
	$(function(){
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
	$(window).resize(function(){  
    $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
    })  
});  
</script> 

</head>

<body style="background-color:#1c77ac; background-image:url(images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;">



    <div id="mainBody">
      <div id="cloud1" class="cloud"></div>
      <div id="cloud2" class="cloud"></div>
    </div>  


<div class="logintop">    
    <span>欢迎登录奇猿网络后台管理中心</span>
    </div>
    <form action="" method="post">
    <div class="loginbody">
      <span class="systemlogo"></span>    
      <div class="loginbox">
      <!-- 登陆后台啊 -->
        <ul>
          <li><input name="username" type="text" class="loginuser" placeholder="登录帐号" /></li>
          <li><input name="password" type="password" class="loginpwd" placeholder="登录密码" /></li>
          <li><input name="verify" type="text" class="logincode" placeholder="验证码" />
              <img src="./include/vertify4.php" width="128" height="54"  alt=" class="loginimg" />
			  
          </li>
          <li><input type="submit" class="loginbtn" value="登录" />
              <label><input name="" type="checkbox" value="" checked="checked" />记住密码</label>
              <label></label>
          </li>
        </ul>
      </div>
    </div>
    </form>
    <div class="loginbm">版权所有  2016  <a href="http://www.qyit5.com">悉心网络</a></div>
</body>

</html>
