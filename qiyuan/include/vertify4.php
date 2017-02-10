<?php
  header('Content-Type:image/png;charset=utf-8');
  //header('Content-Type:text/html;charset=utf-8');
  session_start();
  // 创建真彩色画板
  $w = 800;
  $h = 320;
  $src = imagecreatetruecolor($w,$h);
  // 设置画板背景颜色
  $bgcolor = imagecolorallocate($src,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
  $x1 = 0;
  $y1 = 0;
  $x2 = $w;
  $y2 = $h;
  imagefilledrectangle($src,$x1,$y1,$x2,$y2,$bgcolor);


  //添加干扰线条
  for($i = 0;$i<200;$i++){
    $linecolor = imagecolorallocate($src,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    imageline($src,mt_rand(0,800),mt_rand(0,320),mt_rand(0,800),mt_rand(0,320),$linecolor);
  }

  // 把验证码写入画板[验证码是随机性的,我们先要生成随机数]
  $fontfile = 'pop.ttf';
  $fontsize = 170;
  $x = 100;
  $y = 210;
  $string = ''; //要存储session里面的验证码
  //验证码 那是必须的我必须 会听君一席话，胜读十年书 
  for($i = 0;$i<4;$i++){
    $angle = mt_rand(-45,45);
    $text = ver_num();
    $string .= $text;
    $textcolor = imagecolorallocate($src,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    imagettftext($src,$fontsize,$angle,$x+$i*mt_rand(140,180),$y+mt_rand(-80,80),$textcolor,$fontfile,$text);
  }
  $_SESSION['vertify_string'] = $string;
  $_SESSION['vertify_time'] = time();
  /*
   $src       画板资源
   $fontsize  字体大小
   $angle     倾斜角度
   $x,$y      首个字符的左下角坐标
   $textcolor 字体颜色[imagecolorallocate函数分配]
   $fontfile  字体文件
   $text      内容
   */
  //添加干扰像素
  for($i = 0;$i<2000;$i++){
    $pxcolor = imagecolorallocate($src,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    imagesetpixel($src,mt_rand(0,800),mt_rand(0,320),$pxcolor);
  }
  // 保存图片
  imagepng($src);

  function ver_num(){
    $case = range('A','Z');
    $int  = range(0,9);
    $num = array_merge($case,$int);
    shuffle($num);
    return $num[0];
  }