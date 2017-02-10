<?php
require "./include/common.func.php"; //引入公共函数库
  require "./include/uploads.func.php"; //引入上传文件处理函数
  require "./include/mysqli.func.php"; //引入增删改查函数
  //公共配置文件[公共代码，常量定义、数据库连接]
  header('Content-Type:text/html;charset=utf-8');
  date_default_timezone_set('PRC');
  //因为地址太长了，往往我们需要定义两个常量来表示网址和项目的实际目录
  define('WEB','http://www.scm.com/');
  //此处不存在 有什么 
  define('KEY','125ds423'); //盐值
  define('ROOT',str_replace('\\','/',dirname( __DIR__ ) ).'/' );   
  $con = con('127.0.0.1','root','zjm516423','sjk_3');