<?php
 /* @function             uploads                文件上传处理函数
  * @author               php1605
  * @date                 2016-09-19
  * @param      string    $input                 上传文件框的name值
  * @param      string    $path="./uploads/"     上传文件的存放目录
  * @param      array     $type = array('gif','jpeg','jpg','png')
                                                 允许上传文件的文件类型
  * @param      int       $max_size=8388608      允许上传文件大小的最大值
  * @return     array     $filename              返回值，0为失败，1为成功
  */

  function uploads($input,$path="uploads/",$type = array('gif','jpeg','jpg','png'),$max_size=8388608){
    date_default_timezone_set('PRC');
    $file = $_FILES[$input];

    //1. 判断文件是否是使用HTTP POST 上传过来的文件
    if( !is_uploaded_file( $file['tmp_name'] ) ){
      return array(0,'文件有误！');
    }

    //2. 对文件的错误类型进行判断处理
    switch($file['error']){
      case 1: 
        return array(0,"上传文件太大");
      case 2:
        return array(0,"上传文件太大");
      case 3: 
        return array(0,"上传文件不完整");
      case 4: 
        return array(0,"没有文件上传");
      case 6: 
        return array(0,"找不到上传文件的临时目录");
      case 7: 
        return array(0,"没有权限");
    }
    //3. 对上传文件的大小进行限制
    if( $file['size']> $max_size ){
      return array(0,"上传的文件太大了");
    }

    //4. 对上传文件的类型进行限制
    $ext = strtolower( pathinfo($file['name'],PATHINFO_EXTENSION) );
    
    if( !in_array( $ext,$type ) ){
      return array(0,'上传文件的类型不符');
    }
    
    //5. 对上传文件进行处理，用法和copy一样
    //5.1 对上传文件的存放目录，进行判断，不存在则自动创建
    $path = rtrim($path,'/').date('/Y/m/d');
    if( !realpath($path) ){
      mkdir($path,0755,true);
    }
    //5.2 对上传文件进行分目录处理
    
    $filename = rtrim($path,'/').'/'.date('YmdHis').mt_rand(1000000,9999999).'.'.$ext;
    $res = move_uploaded_file($file['tmp_name'],$filename);
    if($res){
      return array(1,$filename);
    }else{
      return array(0,'发生为止的错误!请重新上传！');
    }
  }