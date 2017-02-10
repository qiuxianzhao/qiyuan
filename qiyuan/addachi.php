<?php 
    require_once './include/common.conf.php';

    if($_POST){
       $sid = $_POST['sname'];
       $cid = $_POST['cname'];
       $addtime = strtotime($_POST['addtime']);
       $point = $_POST['point']+0;
        $sql = "INSERT INTO `achievement`(`sid`, `cid`, `point`, `addtime`) VALUES ('$sid','$cid','$point','$addtime')";
        $res = mysqli_query($con,$sql);
        if($res && mysqli_affected_rows($con)){
            showMsg('添加成绩成功！','show-achi.php');
        }else{
            showMsg('添加成绩失败！');
        }
    }

    $sql = "select * from student";
    $student = getAll($con,$sql);
    $sql = "select * from course";
    $course = getAll($con,$sql);
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
    
    <div class="formtitle"><span>添加成绩</span></div>
    <form action="" method="post" enctype="multipart/form-data">
        <ul class="forminfo">
        <li><label>学生姓名</label>
            <select name="sname" class="dfinput">
                <?php foreach($student as $value){ ?>
                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                <?php } ?>
            </select>
        </li>
        <li><label>课程名称</label>
            <select name="cname" class="dfinput">
                <?php foreach($course as $value){ ?>
                <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                <?php } ?>
            </select>
        </li>
        <li><label>科目成绩</label>
            <input type="number" max="100" min="0" name="point" class="dfinput"" />
        </li>
        <li><label>考试时间</label><input name="addtime" id="addtime" type="text" class="dfinput" value="<?php echo date('Y-m-d H:i:s'); ?>" /></li>
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
