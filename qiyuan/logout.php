<?php
  session_start();
  require "./include/common.conf.php";
  define('IS_LOGIN', 1);
//  这种方法是将原来注册的某个变量销毁
	unset($_SESSION['is_login']);
//  这种方法是销毁整个 Session 文件
	session_destroy();
  showMsg('退出登录成功！','login.php');
  ?>