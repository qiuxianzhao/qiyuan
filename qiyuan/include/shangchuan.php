<?php
 $ori_img = "images/13801220684507.jpg"; //原图
 $water_img = "logo.png"; //水印
 $new_img = "images/daixiaorui.jpg"; //生成水印后的图片
 
 $original = getimagesize($ori_img); //得到图片的信息，可以print_r($original)发现它就是一个数组
 $watermark = getimagesize($water_img);
 
 $s_original = imgCreateFrom($ori_img, $original[2]); //$original[2]是图片类型，其中1表示gif、2表示jpg、3表示png
 $s_watermark = imgCreateFrom($water_img, $watermark[2]);
 
 $posX = $original[0] - $watermark[0]-6; //X坐标（右下角）
 $poxY = $original[1] - $watermark[1]-3; //Y坐标（右下角）
 //打水印
 imagecopy($s_original, $s_watermark, $posX, $poxY, 0, 0, $watermark[0], $watermark[1]);
 //header("Content-type:image/jpeg");
 //imagejpeg($s_original); //向浏览器输出图片
 $loop = imagejpeg($s_original, $new_img); //生成新的图片(jpg格式)，如果用imagepng可以生成png格式
 if($loop){
  echo "水印添加成功！";
 }
 
 //根据文件类型 创建一个新图象
 function imgCreateFrom($img_src, $val){
  switch($val){
   case 1 : $img = imagecreatefromgif($img_src);
    break;
   case 2 : $img = imagecreatefromjpeg($img_src);
    break;
   case 3 : $img = imagecreatefrompng($img_src);
    break;
  }
  return $img;
 } 
?>