<?php 
    require_once './include/common.conf.php';

    $up=[];
    $up_id;
    if(isset($_GET['id'])){
        $up_id = $_GET['id'];
        $sql = "select `name`, `avator`, `username`, `password`, `status`, `sex`, `age`, `addtime`, `class_id`, `desc`, `fav`, `mobi`, `email` from student where `id` = $up_id";
        $up = getOne($con,$sql);
    }
    
    if($_POST){
       $name = htmlspecialchars($_POST['name']);
       $username = htmlspecialchars($_POST['username']);
       $psw = htmlspecialchars($_POST['psw'])==''?$up['password']:htmlspecialchars($_POST['psw']);
       $age = $_POST['age']+0;
       $sex = $_POST['sex']+0;
       $class = $_POST['class']+0;
       $fav = htmlspecialchars($_POST['fav']);
       $addtime = strtotime($_POST['addtime']);
       $status = $_POST['status']+0;
       $desc = htmlspecialchars($_POST['desc']);
       $phone = htmlspecialchars($_POST['phone']);
       $email = htmlspecialchars($_POST['email']);
       $old_img = htmlspecialchars($_POST['old_img']);

        if($_FILES){
            $i = uploads('avator');
            if($i[0]==0){
                $avator = $old_img;
            }else{
                $avator = $i[1];
            }
        }

       $sql = "update `student` set `name`='$name', `avator`='$avator', `username`='$username', `password`='$psw', `status`=$status, `sex`=$sex, `age`=$age, `addtime`=$addtime, `class_id`=$class, `desc`='$desc', `fav`='$fav', `mobi`='$phone', `email`='$email' where `id`=$up_id";
        $res = mysqli_query($con,$sql);
        if($res && mysqli_affected_rows($con)){
           if(file_exists(ROOT.$old_img) && $i[0]!='0'){
                unlink(ROOT.$old_img);
           }
            showMsg('修改学生成功！','show-student.php');
        }else{
            showMsg('修改学生失败');
        }
    }

    $sql = "select * from class";
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
    
    <div class="formtitle"><span>添加学生</span></div>
    <form action="" method="post" enctype="multipart/form-data">
        <ul class="forminfo">
        <li><label>姓名</label><input name="name" type="text" class="dfinput" value="<?php echo $up['name']; ?>" /></li>
        <li><label>登录账号</label><input name="username" type="text" class="dfinput" value="<?php echo $up['username']; ?>" /></li>
        <li><label>登录密码</label><input name="psw" type="password" class="dfinput" /></li>
        <li><label>上传头像</label><input name="avator" type="file" class="dfinput" value="" />
            <input type="hidden" name="old_img" value="<?php echo $up['avator']; ?>" />
            <img src="<?php echo $up['avator']; ?>" alt="" style="position:absolute;right:35%;" />
        </li>
        <li><label>年龄</label><input name="age" type="text" class="dfinput" value="<?php echo $up['age']; ?>" /></li>
        <li><label>手机</label><input name="phone" type="text" class="dfinput" value="<?php echo $up['mobi']; ?>" /></li>
        <li><label>邮箱</label><input name="email" type="text" class="dfinput" value="<?php echo $up['email']; ?>" /></li>
        <li><label>性别</label><cite><input name="sex" type="radio" value="1" <?php echo $up['sex']==1?'checked':''; ?> />男&nbsp;&nbsp;&nbsp;&nbsp;<input name="sex" type="radio" value="2" <?php echo $up['sex']==2?'checked':''; ?> />女</cite></li>
        <li><label>所在班级</label>
            <select name="class" id="" class="dfinput">
                <?php foreach($data as $value){ ?>
                <option value="<?php echo $value['id']; ?>" <?php echo $up['class_id']==$value['id']?'selected':''; ?>><?php echo $value['name']; ?></option>
                <?php } ?>
            </select>
        </li>
        <li><label>爱好</label><input name="fav" type="text" class="dfinput" value="<?php echo $up['fav']; ?>" /><i>多个爱好用,隔开</i></li>
        <li><label>入学时间</label><input name="addtime" id="addtime" type="text" class="dfinput" value="<?php echo date('Y-m-d H:i:s',$up['addtime']); ?>" /></li>
        <li><label>状态</label><cite><input name="status" type="radio" value="1" <?php echo $up['status']==1?'checked':''; ?> />启用&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="2" <?php echo $up['status']==2?'checked':''; ?> />禁用&nbsp;&nbsp;&nbsp;&nbsp;<input name="status" type="radio" value="3" <?php echo $up['status']==3?'checked':''; ?> />删除</cite></li>
        <li><label style="float:none;">个性签名</label><textarea id="desc" name="desc" style="width:800px;height:240px;"><?php echo $up['desc']; ?></textarea></li>
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
