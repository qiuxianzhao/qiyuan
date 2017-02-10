<?php
function upload($uploadfile,$watermark=1,$watertype=1,$content){
  foreach($uploadfile['name'] as $key=>$name) {  //多文件上传函数
   uploadall($uploadfile,$key,$watermark,$watertype,$content);
  }
 }
 function uploadall($uploadfile,$i,$watermark,$watertype,$content) {
  $watermark=$watermark;         //是否附加水印(1为加水印,其他为不加水印); 
  $watertype=$watertype;         //水印类型(1为文字,2为图片) 
  $watercontent=$content;         //水印的内容
  if(empty($uploadfile['name'][$i])) {
   die("未选择文件上传");
  }
  if($uploadfile['error'][$i] == 2) {   //验证html判断结果
   die("上传的文件太大了");
  }
  $allow_filemaxsize = 2048000;    // 2m
  $filesize = $uploadfile['size'][$i];
  if($filesize > $allow_filemaxsize) {
   die("上传的文件太大了");
  }
  $allow_filetypes = array("jpeg", "gif", "png","jpg","pjpeg");//允许上传的文件统一资源类型 mimetype
  $allow = false;        //默认都不允许
  $mimetype = $uploadfile['type'][$i];  //上传文件的mime文件类型
  foreach($allow_filetypes as $t) {
   if(strpos($mimetype, $t) !== false) {
    $allow = true;      //找到了符合上传条件的文件类型
    break;
   }
  }
  if($allow == false) {
   die("上传的文件类型不被允许");
  }
  $result = is_uploaded_file($uploadfile['tmp_name'][$i]);   //判断是否为上传动作产生的
  if(!$result) {
   die("上传的文件有误");
  }
  $uploaddir = "img/";       //上传文件保存目录
  if(!file_exists($uploaddir)) mkdir($uploaddir, 0777, true);//若上传保存目录不存在，则递归创建
  /**重命名文件**/
  $filetype = explode(".", $uploadfile['name'][$i]);
  $filetype = array_pop($filetype);
  $uploadfilename = time().".".$filetype;
  $_session['filename'] = $uploadfilename;
  //end
  $result = move_uploaded_file($uploadfile['tmp_name'][$i], $uploaddir.$uploadfilename);
  if($result) {
   echo  "文件上传成功";
  }else{
   switch($uploadfile['error'][$i]) {
    case 1:return "上传的文件超出了php.ini中设定的最大值";break;
    case 2:return "上传的文件超出了html中设定的最大值";break;
    case 3:return "文件只有部分被上传";break; 
    case 4;return "没有文件被上传";break; 
    default:die("文件上传失败");  
   }
  }
  if($watermark==1) { 
   $iinfo=getimagesize($uploaddir.$uploadfilename);  //获取图片的相关信息，得到数组
   $nimage=imagecreatetruecolor($iinfo[0],$iinfo[1]); 
   $white=imagecolorallocate($nimage,255,255,255); //设置背景颜色为白色
   $black=imagecolorallocate($nimage,0,0,0);  //设置背景颜色为黑色
   $red=imagecolorallocate($nimage,255,0,0);  //设置背景颜色为红色
   imagefill($nimage,0,0,$white);     //背景填充为白色
   switch ($iinfo[2]) { 
    case 1: 
    $simage =imagecreatefromgif($uploaddir.$uploadfilename); 
    break; 
    case 2: 
    $simage =imagecreatefromjpeg($uploaddir.$uploadfilename); 
    break; 
    case 3: 
    $simage =imagecreatefrompng($uploaddir.$uploadfilename); 
    break; 
    case 6: 
    $simage =imagecreatefromwbmp($uploaddir.$uploadfilename); 
    break; 
    default: 
    die("不支持的文件类型"); 
    exit; 
   } 
   imagecopy($nimage,$simage,0,0,0,0,$iinfo['0'],$iinfo['1']); 
   switch($watertype) { 
    case 1:             //加水印字符串 
    imagestring($nimage,5,$iinfo['0']/2-50,$iinfo['1']-30,$watercontent,$black); 
    break; 
    case 2:            //加水印图片 
    $simage1 =imagecreatefromgif($watercontent); 
    $size = getimagesize($watercontent);
    imagecopy($nimage,$simage1,$iinfo['0']/2+50,$iinfo['1']-100,0,0,$size[0],$size[1]); 
    imagedestroy($simage1); 
    break; 
   }

   switch ($iinfo[2]) { 
    case 1: 
    imagejpeg($nimage, $uploaddir.$uploadfilename); //将图像$nimage以$destination文件名创建一个jpeg的格式文件
    //解决央视的问题  坚持坚持 环境 
    break; 
    case 2: 
    imagejpeg($nimage, $uploaddir.$uploadfilename); 
    break; 
    case 3: 
    imagepng($nimage, $uploaddir.$uploadfilename); 
    break; 
    case 6: 
    imagewbmp($nimage, $uploaddir.$uploadfilename); 
    break; 
   } 
   imagedestroy($nimage);    //覆盖原上传文件 
   imagedestroy($simage); 
  } 
}
if(@$_get['act'] == "insert") {    //未作参数校验
     //该函数的四个参数分别是：上传控件的name值；是否加水印（1为加，其他数字为不佳）；
     //水印的类型（1为字符串，2为图片）；水印的内容,字符串时写数据，图片时写图片的地址；
 $picture = upload($_files['picture'],1,2,"img/watermark.gif");//上传文件，并返回上传后的文件路径名

}

?>