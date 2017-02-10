<?php
  //生成缩略图函数
  header('Content-Type:text/html;charset=utf-8');

  //$src_path = "niao.jpg"; //纵图
 

  /* @function   thumb                      生成缩略语函数
   * @author     PHP1605
   * @date       2016-10-18
   * @param      string      $src_path      源图路径
   * @param      string      $path          新图路径
   * @param      string      $dst_w=150     新图宽度
   * @param      string      $dst_h=100     新图高度
   * @param      string      $red = null    新图背景[红色]
   * @param      string      $green = null  新图背景[绿色]
   * @param      string      $blue = null   新图背景[蓝色]
   * @param      string      $thumb = null  是否保存还是单纯生成[是否直接显示缩略图]
   * @param      string      $keep = false  是否保持宽高比
   * @return     string      $dst_path      返回路径
   */
  function thumb($src_path,$path,$dst_w=150,$dst_h=100,$red = null,$green = null,$blue = null,$thumb = null,$keep = false ){
    //1. 获取源图信息
    $src_info = getimagesize($src_path);

    //2. 根据不同的图片格式打开源图
    switch($src_info[2]){
      case 1:
        $ext = 'gif';
      break;
      case 2:
        $ext = 'jpeg';
      break;
      case 3:
        $ext = 'png';
      break;
    }
    $func = 'imagecreatefrom'.$ext; //变量函数,变量充当函数名
    $src = $func($src_path);
  
    //3. 新建真彩色画板
      $dst_src = imagecreatetruecolor($dst_w,$dst_h);
      //默认设置画板背景颜色为白色
      if($red === null ){
        $red = 255;
        $green = 255;
        $blue = 255;
      }
      $bg_color = imagecolorallocate($dst_src,$red,$green,$blue);
      //给画板填充颜色
      $x1 = 0;
      $y1 = 0;
      imagefilledrectangle( $dst_src , $x1 , $y1 ,$dst_w , $dst_h ,$bg_color );
      //$dst_src 画板资源
      //$x1 和 $y1 左上角坐标
      //$x2 和 $y2 宽高
      //bg_color 前面分配的颜色

    //4. 把源图中的内容复制到新画板中，并调整内容大小
      $dst_x = 0; // 新图的左上角x轴坐标
      $dst_y = 0; // 新图的左上角y轴坐标
      $src_x = 0; // 源图的左上角x轴坐标
      $src_y = 0; // 源图的左上角y轴坐标
      $src_w = $src_info[0]; // 源图宽度
      $src_h = $src_info[1]; // 源图高度
      $ratio = $src_w/$src_h;// 源图的宽高比率
      
      //如果要保持图片不变形
      $new_x = 0;$new_y = 0;
      if( $keep === true ){
        if($src_w > $src_h){ //横图
          $new_h = $dst_w/$ratio;
          $new_w = $dst_w;
          $new_y = (int)(($dst_h - $new_h)/2);
        }else{ //纵图
          $new_h = $dst_h;
          $new_w = $dst_h*$ratio;
          $new_x = (int)(($dst_w-$new_w)/2);
        }
      }else{
        $new_w = $dst_w;
        $new_h = $dst_h;
      }
      
      imagecopyresized($dst_src,$src,$new_x,$new_y,$src_x,$src_y,$new_w,$new_h,$src_w,$src_h);

    //5. 根据不同格式保存图片，释放资源
    if( !realpath( $path ) ){
      mkdir($path,'0777',true);
    }
    $dst_filename = basename($src_path);
    $dst_path = trim($path,'/').'/'.$dst_filename;

    //拼接保存/生成缩略图的函数
    $func = "image".$ext;
    if( $thumb ){
      header("Content-Type:image/$ext;charset=utf-8");
      echo $func($dst_src);
    }else{
      $func($dst_src,$dst_path);
    }

    imagedestroy($src);
    imagedestroy($dst_src);
    if($thumb){
      return $dst_path;
    }
  }