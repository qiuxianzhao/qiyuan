<?php 
    require_once './include/common.conf.php';

    //显示当前老师的信息，以便修改
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $sql = "select * from teacher where id = $id";
        $r_teacher = getOne($con,$sql);
    }
    
//修改老师的信息
    if($_POST){
       $name = htmlspecialchars($_POST['name']);
       $username = htmlspecialchars($_POST['username']);
       $psw = htmlspecialchars($_POST['psw'])==''?$r_teacher['password']:htmlspecialchars($_POST['psw']);  //判断是否有修改密码，如果没有则使用前面的
       $age = $_POST['age']+0;
       $sex = $_POST['sex']+0;
       $position = $_POST['position']+0;
       $fav = htmlspecialchars($_POST['fav']);
       $addtime = strtotime($_POST['addtime']);
       $status = $_POST['status']+0;
       $desc = htmlspecialchars($_POST['desc']);
       $phone = htmlspecialchars($_POST['phone']);
       $email = htmlspecialchars($_POST['email']);
       $old_img = $_POST['old_img'];

       if($_FILES){               //判断是否有修改头像，如果有修改头像那么$img[0]等于1，否则为0，$img的第二个参数是头像的路径或者错误报告
            $img = uploads('avator');
            if($img[0]==1){
                $avator = $img[1];
            }else{
                $avator = $old_img;
            }
        }else{
            showMsg('请上传头像！');
        }

        $sql = "update `teacher` set `name`='$name', `avator`='$avator', `username`='$username', `password`='$psw', `status`=$status, `sex`=$sex, `age`=$age, `addtime`=$addtime,`position`=$position, `desc`='$desc', `fav`='$fav', `mobi`='$phone', `email`='$email' where id = $id";
        $res = mysqli_query($con,$sql);
        if($res && mysqli_affected_rows($con)){
            if($img[0]==1 && file_exists(ROOT.$old_img)){           //如果有重新上传头像那么则删除原来旧的头像，否则不删除
                unlink(ROOT.$old_img);
            }
            showMsg('修改教师成功！','show-teacher.php');
        }else{
            showMsg('修改教师失败');
        }
    }
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
    
    <div class="formtitle"><span>添加老师</span></div>
    <form action="" method="post" enctype="multipart/form-data">
        <ul class="forminfo">
        <li><label>姓名</label><input name="name" type="text" class="dfinput" value="<?php echo $r_teacher['name']; ?>" /></li>
        <li><label>登录账号</label><input name="username" type="text" class="dfinput" value="<?php echo $r_teacher['username']; ?>" /></li>
        <li><label>登录密码</label><input name="psw" type="password" class="dfinput" /></li>
        <li><label>上传头像</label>
            <input name="avator" type="file" class="dfinput" value="" />
            <input type="hidden" name="old_img" value="<?php echo $r_teacher['avator']; ?>" />
            <img src="<?php echo $r_teacher['avator']; ?>" alt="" style="position:absolute;left:50%;" />
        </li>
        <li><label>年龄</label><input name="age" type="text" class="dfinput" value="<?php echo $r_teacher['age']; ?>" /></li>
        <li><label>手机</label><input name="phone" type="text" class="dfinput" value="<?php echo $r_teacher['mobi']; ?>" /></li>
        <li><label>邮箱</label><input name="email" type="text" class="dfinput" value="<?php echo $r_teacher['email']; ?>" /></li>
        <li><label>性别</label><cite><input name="sex" type="radio" value="1" <?php echo $r_teacher['sex']==1?'checked':''; ?> />男&nbsp;&nbsp;&nbsp;&nbsp;<input name="sex" type="radio" value="2" <?php echo $r_teacher['sex']==2?'checked':''; ?> />女</cite></li>
        <li><label>职称</label>
            <select name="position" id="" class="dfinput">
                <option value="1" <?php echo $r_teacher['position']==1?'selected':''; ?> >授课老师</option>
                <option value="2" <?php echo $r_teacher['position']==2?'selected':''; ?> >班主任</option>
                <option value="3" <?php echo $r_teacher['position']==3?'selected':''; ?> >授课老师兼班主任</option>
            </select>
        </li>
        <li><label>爱好</label><input name="fav" type="text" class="dfinput" value="<?php echo $r_teacher['fav']; ?>" /><i>多个爱好用,隔开</i></li>
        <li><label>入职时间</label><input name="addtime" id="addtime" type="text" class="dfinput" value="<?php echo date('Y-m-d H:i:s',$r_teacher['addtime']); ?>" /></li>
        <li><label>状态</label><cite><input name="status" type="radio" value="1" <?php echo $r_teacher['status']==1?'checked':''; ?> />启用&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="2" <?php echo $r_teacher['status']==2?'checked':''; ?> />禁用&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="3" <?php echo $r_teacher['status']==3?'checked':''; ?> />删除</cite></li>
        <li><label style="float:none;">个性签名</label><textarea id="desc" name="desc" style="width:800px;height:240px;"><?php echo $r_teacher['desc']; ?></textarea></li>
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

		//实例化富文本编辑器ueditor
		 var ue = UE.getEditor('desc',{
             toolbars: [[
            'fullscreen',  'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase',  '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload',  'spechars', 'snapscreen', 'wordimage', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable','splittocells', 'splittorows', 'splittocols', 'charts', '|', 'preview'
        ]]});

    </script>

</body>

</html>
