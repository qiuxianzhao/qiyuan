<?php 
    require_once './include/common.conf.php';

    if($_POST){
        if($_FILES && $_FILES['cover']['name']!=''){
            $cover = uploads('cover')['1'];
        }else{
            showMsg('请上传封面！');
        }
       $name = htmlspecialchars($_POST['name']);
       $ontime = htmlspecialchars($_POST['ontime']);
       $classroom = htmlspecialchars($_POST['classroom']);
       $status = $_POST['status']+0;
       $addtime = strtotime($_POST['addtime']);
       $tid = $_POST['tid']+0;
        $sql = "INSERT INTO `course`(`name`, `cover`, `ontime`, `addtime`, `status`, `classroom`, `tid`) VALUES ('$name','$cover','$ontime',$addtime,$status,'$classroom',$tid)";
        $res = mysqli_query($con,$sql);
        if($res && mysqli_affected_rows($con)){
            showMsg('添加课程成功！','show-course.php');
        }else{
            showMsg('添加课程失败');
        }
    }
    $sql = "select * from teacher";
    $data = getAll($con,$sql);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>奇猿网络后台管理中心</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/calendar.css" rel="stylesheet" type="text/css" />
<script src="./src/calendar.js"></script>
<script src="./src/ueditor/ueditor.config.js"></script>
<script src="./src/ueditor/ueditor.all.min.js"> </script>
<script  src="./src/ueditor/lang/zh-cn/zh-cn.js"></script>
</head>

<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">表单</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    <div class="formtitle"><span>添加课程</span></div>
    <form action="" method="post" enctype="multipart/form-data">
        <ul class="forminfo">
        <li><label>课程名称</label><input name="name" type="text" class="dfinput" /></li>
        <li><label>上传封面</label><input name="cover" type="file" class="dfinput" value="" /></li>
        <li><label>上课时间</label><input name="ontime" type="text" class="dfinput" /></li>
        <li><label>上课教室</label><input name="classroom" type="text" class="dfinput" /></li>
        <li><label>课程添加时间</label><input name="addtime" id="addtime" type="text" class="dfinput" value="<?php echo date('Y-m-d H:i:s'); ?>" /></li>
        <li>
            <label>任课老师</label>
            <select name="tid" class="dfinput">
                <?php foreach($data as $value){ ?>
                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                <?php } ?>
            </select>
        </li>
        <li><label>状态</label><cite><input name="status" type="radio" value="1" checked="checked" />上架&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="2" />下架&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="3" />删除</cite></li>
        <li><label>&nbsp;</label><input type="submit" class="btn" value="确认保存"/></li>
        </ul>
    </form>
    
    </div>

    <script language="javascript" type="text/javascript">
        Calendar.setup({
            inputField     :    "addtime",
            ifFormat       :    "%Y-%m-%d %H:%M:%S",
            showsTime      :    true,
            timeFormat     :    "12"
        });

		

    </script>

</body>

</html>
