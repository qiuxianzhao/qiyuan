<?php 
    require_once './include/common.conf.php';

    //修改前显示所有信息
    $id;
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "select * from course where id=$id";
        $r_course = getOne($con,$sql);
    }

    if($_POST){            //修改部分
        
       $name = htmlspecialchars($_POST['name']);
       $old_img = $_POST['old_img'];
       $ontime = htmlspecialchars($_POST['ontime']);
       $classroom = htmlspecialchars($_POST['classroom']);
       $status = $_POST['status']+0;
       $addtime = strtotime($_POST['addtime']);
       $tid = $_POST['tid']+0;

       if($_FILES){
            $cover = uploads('cover');
            if($cover[0]==1){
                $cover_img = $cover[1];
            }else{
                $cover_img = $old_img;
            }
        }else{
            showMsg('请上传封面！');
        }

        $sql = "update `course` set `name`='$name', `cover`='$cover_img', `ontime`='$ontime', `addtime`=$addtime, `status`=$status, `classroom`='$classroom', `tid`=$tid where id=$id";
        $res = mysqli_query($con,$sql);
        if($res && mysqli_affected_rows($con)){
            if($cover[0]==1 && file_exists(ROOT.$cover_img)){
                unlink(ROOT.$old_img);
            }
            showMsg('课程修改成功！','show-course.php');
        }else{
            showMsg('课程修改失败！');
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
        <li><label>课程名称</label><input name="name" type="text" class="dfinput" value="<?php echo $r_course['name']; ?>" /></li>
        <li><label>上传封面</label>
            <input name="cover" type="file" class="dfinput" value="" />
            <input type="hidden" name="old_img" value="<?php echo $r_course['cover']; ?>" />
            <img src="<?php echo $r_course['cover']; ?>" alt="" style="position:absolute;top:20%;right:30%;" />
        </li>
        <li><label>上课时间</label><input name="ontime" type="text" class="dfinput" value="<?php echo $r_course['ontime']; ?>" /></li>
        <li><label>上课教室</label><input name="classroom" type="text" class="dfinput" value="<?php echo $r_course['classroom']; ?>" /></li>
        <li><label>课程添加时间</label><input name="addtime" id="addtime" type="text" class="dfinput" value="<?php echo date('Y-m-d H:i:s',$r_course['addtime']); ?>" /></li>
        <li>
            <label>任课老师</label>
            <select name="tid" class="dfinput">
                <?php foreach($data as $value){ ?>
                <option value="<?php echo $value['id']; ?>" <?php echo $r_course['tid']==$value['id']?'selected':'' ?>><?php echo $value['name']; ?></option>
                <?php } ?>
            </select>
        </li>
        <li><label>状态</label><cite><input name="status" type="radio" value="1" <?php echo $r_course['status']==1?'checked':'' ?> />上架&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="2" <?php echo $r_course['status']==2?'checked':'' ?> />下架&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="3" <?php echo $r_course['status']==3?'checked':'' ?> />删除</cite></li>
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
