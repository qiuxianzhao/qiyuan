<?php 
    require_once './include/common.conf.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "select * from class where id = $id";
        $up_class = getOne($con,$sql);
    }

    if($_POST){
       $name = htmlspecialchars($_POST['name']);
       $status = $_POST['status']+0;
       $addtime = strtotime($_POST['addtime']);
       $tid = $_POST['tid']+0;
        $sql = "update `class` set `name`='$name', `addtime`=$addtime, `tid`=$tid, `status`=$status where id = $id";
        $res = mysqli_query($con,$sql);
        if($res && mysqli_affected_rows($con)){
            showMsg('修改班级成功！','show-class.php');
        }else{
            showMsg('修改班级失败');
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
    
    <div class="formtitle"><span>添加班级</span></div>
    <form action="" method="post" enctype="multipart/form-data">
        <ul class="forminfo">
        <li><label>班级名称</label><input name="name" type="text" class="dfinput" value="<?php echo $up_class['name']; ?>" /></li>
        <li><label>开班时间</label><input name="addtime" id="addtime" type="text" class="dfinput" value="<?php echo date('Y-m-d H:i:s',$up_class['addtime']); ?>" /></li>
        <li>
            <label>班主任</label>
            <select name="tid" class="dfinput">
                <?php foreach($data as $value){ ?>
                <option value="<?php echo $value['id']; ?>" <?php echo $value['id']==$up_class['tid']?'selected':'' ?> ><?php echo $value['name']; ?></option>
                <?php } ?>
            </select>
        </li>
        <li><label>状态</label><cite><input name="status" type="radio" value="1" <?php echo $up_class['status']==1?'checked':'' ?> />已开班&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="2" <?php echo $up_class['status']==2?'checked':'' ?> />未开班</cite></li>
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
