<?php
  /* @function fsize             获取文件大小函数【自动转换单位】
   * @param    string   $fize    文件地址
   * @param    string   $charset 文件编码
   * @return   string   $unit    带单位的文件大小
   */
  function fsize($file,$charset="utf-8"){
    $point = 1;
    $size = filesize($file);
    if( $size < 1024 ){
      $unit = '字节';
      $s = 0;
      $point = 0;
    }else if( $size < pow(1024,2) ){
      $unit = 'KB';
      $s = 1;
    }else if( $size < pow(1024,3) ){
      $unit = 'MB';
      $s = 2;
    }else if( $size < pow(1024,4) ){
      $unit = 'GB';
      $size = 3;
    }else if( $size <pow(1024,5) ){
      $unit = 'TB';
      $s = 4;
    }
    $unit = sprintf("%.{$point}f",$size/pow(1024,$s)).$unit;
    if( $charset != 'utf-8' ){
      $unit = iconv('utf-8',$charset,$unit );
    }
    return $unit;
  }

  /* @function removedir         递归删除文件或目录
   * @param    string   $path    要删除的文件地址或目录地址
   * @rereturn void              没有返回值
   */
  function removedir($path){

    if( is_file($path) ){
      unlink($path);
    }else{
      $res = scandir( $path );
      foreach($res as $item){
        if( $item != '.' && $item != '..' ){
          removedir($path.'/'.$item);
        }
      }
    }
    rmdir($path);
  }


  /* @function     showMsg              页面提示跳转函数
   * @param        string      $msg     提示文本
   * @param        string      $url     跳转地址
   * @return       void
   */
  function showMsg($msg,$url=false){
    echo '<script>';
    echo "alert('$msg');";
    if( $url ){
      echo "location.assign('$url');";
    }else{
      echo "history.go(-1);";
    }
    echo '</script>';
    die;
  }

