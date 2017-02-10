<?php 
    require_once './include/common.conf.php';
    require_once './src/pagination/pagination.func.php';

    if(isset($_GET['del'])){
        $del = $_GET['del'];
        $sql = "select `avator` from student where `id` in ($del)";
        $res_img = mysqli_query($con,$sql);
        $sql = "delete from student where id in ($del)";
        $res = mysqli_query($con,$sql);
        if( $res && mysqli_affected_rows($con) ){
            while($row = mysqli_fetch_assoc($res_img)){
                if(file_exists(ROOT.$row['avator'])){
                    unlink(ROOT.$row['avator']);
                }
            }
            showMsg('删除成功！','show-student.php');
        }else{
            showMsg('删除失败！');
        }
    }

    $pagesize = 5;    //确定每页显示多少条记录

    $sql = "select count('id') c from `student`";
    $count = getOne($con,$sql)['c'];     //确定总共有多少条记录
	//echo $count;die;
    if(isset($_GET['page']) && $_GET['page']>=1 ){      //确定当前为第几页
        $pagenow = $_GET['page']+0;
    }else{
        $pagenow = 1;
    }

    $sql = "select s.`id` id,s.`name` name,`last_login_time`,`avator`,s.`addtime` addtime,`last_login_ip`,`sex`,`age`,s.`status` status,c.`name` class from student s left join `class` c on s.`class_id`=c.`id` limit ".($pagenow-1)*$pagesize.",$pagesize";
    $data = getAll($con,$sql);
    mysqli_close($con);
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>奇猿网络后台管理中心</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="./src/pagination/pagination/page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script language="javascript">
$(function(){	
	//导航切换
	$(".imglist li").click(function(){
		$(".imglist li.selected").removeClass("selected")
		$(this).addClass("selected");
	})	
})	
</script>
<script type="text/javascript">
$(document).ready(function(){
  $(".del").click(function(){
  $(".tip").fadeIn(200);
  });
  
  $(".tiptop a").click(function(){
  $(".tip").fadeOut(200);
});

  $(".cancel").click(function(){
  $(".tip").fadeOut(100);
});

});
</script>
</head>


<body>

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">图片列表</a></li>
    </ul>
    </div>
    
    <div class="rightinfo">
    
    <div class="tools">
    
    	<ul class="toolbar">
        <li class="click"><a href="addstudent.php"><span><img src="images/t01.png" /></span>添加</a></li>
        <li class="del"><span><img src="images/t03.png" /></span>删除</li>
        <!-- <li class="click"><span><img src="images/t02.png" /></span>修改</li>
        <li><span><img src="images/t03.png" /></span>删除</li>
        <li><span><img src="images/t04.png" /></span>统计</li> -->
        </ul>
        
        
        <ul class="toolbar1">
        <li><span><img src="images/t05.png" /></span>设置</li>
        </ul>
    
    </div>
    
    
    <table class="imgtable">
    
    <thead>
    <tr>
    <th><input name="selectAll" type="checkbox" /></th>
    <th>学号</th>
    <th width="100px;">头像</th>
    <th>姓名与入学时间</th>
    <th>性别与年龄</th>
    <th>最后登录时间</th>
    <th>最后登录IP</th>
    <th>状态</th>
    <th>所在班级</th>
    <th>操作</th>
    </tr>
    </thead>
    
    <tbody>

    <?php foreach($data as $value){ ?>
    <tr>
    <td><input name="list[]" type="checkbox" value="<?php echo $value['id']; ?>" /></td>
    <td><?php echo $value['id']; ?></td>
    <td class="imgtd"><img src="<?php echo $value['avator']; ?>" width="80" height="60" /></td>
    <td><a href="#"><?php echo $value['name']; ?></a><p>入学时间：<?php echo date('Y-m-d',$value['addtime']); ?></p></td>
    <td><?php echo $value['sex']==1?'男':'女'; ?><p>年龄: <?php echo $value['age']; ?></p></td>
    <td><?php echo date('Y-m-d',$value['last_login_time']); ?></td>
    <td><?php echo $value['last_login_ip']; ?></td>
    <td><?php echo $value['status']==1?'启用':($value['status']==2?'禁用':'删除'); ?></td>
    <td><?php echo $value['class']; ?></td>
    <td>
          <a href="upstudent.php?id=<?php echo $value['id']; ?>" class="tablelink">编辑</a>
          <a href="#" del-data="<?php echo $value['id']; ?>" class="tablelink del"> 删除</a></td>
    </tr>
    <?php } ?>
    
    </tbody>
    
    </table>
   
    <div class="pagin">
    	<?php echo pagination($count,$pagenow,$pagesize,5); ?>
    </div>
    
    
    
    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认删除学生 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
    
    <script type="text/javascript">
	   $('.imgtable tr:odd').addClass('odd');

      (function(){
        var list = document.getElementsByName('list[]')
        document.getElementsByName('selectAll')[0].onclick = function(){
          for(var i = 0,len = list.length; i<len; i++ ){
            list[i].checked=!list[i].checked;
          }
        }
        var del = document.querySelectorAll('.del');
        // console.log(del);
        var delId;
        for(var i=0;i<del.length;i++){
            del[i].onclick = function(){
                delId=[];
                // console.log(this.getAttribute('del-data'));
                if(this.getAttribute('del-data')!==null){
                    // console.log(this.getAttribute('del-data'));
                    delId[0] = this.getAttribute('del-data');
                }else{
                    for(var i =0;i<list.length;i++){
                        if(list[i].checked){
                            // console.log(list[i]);
                            delId.push(list[i].value);
                        }
                    }
                }

                $(".sure").click(function(){
                  $(".tip").fadeOut(100);
                  location.href='./show-student.php?del='+delId.join(',');
                });
            }
        }

      })();
	</script>
    
</body>

</html>
