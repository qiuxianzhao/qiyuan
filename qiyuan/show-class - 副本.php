<?php 
    header('Content-Type:text/html;charset=utf-8');
    date_default_timezone_set('PRC');
    require_once './include/common.conf.php';
    require_once './src/pagination/pagination.func.php';


    //删除操作
    if(isset($_GET['del'])){
        $del = $_GET['del'];
        $sql = "delete from class where `id` in ($del)";
        $res = mysqli_query($con,$sql);
        if( $res && mysqli_affected_rows($con) ){
            showMsg('删除成功！',"show-class.php");
        }else{
            showMsg('删除失败！');
        }
    }
    
    $pagesize = 5;    //确定每页显示多少条记录

    $sql = "select count('id') c from class";
    $count = getOne($con,$sql)['c'];     //确定总共有多少条记录

    if(isset($_GET['page']) && $_GET['page']>=1 ){      //确定当前为第几页
        $pagenow = $_GET['page']+0;
    }else{
        $pagenow = 1;
    }


    $sql = "select c.`id` id,c.`name` name,c.`addtime` addtime,c.`status` status,t.`name` tname from class c left join teacher t on t.`id`=c.`tid` limit ".($pagenow-1)*$pagesize.",$pagesize";
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
        <li class="click"><a href="addclass.php"><span><img src="images/t01.png" /></span>添加</a></li>
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
    <th>班级编号</th>
    <th width="100px;">班级名称</th>
    <th>开班时间</th>
    <th>班主任</th>
    <th>状态</th>
    <th>操作</th>
    </tr>
    </thead>
    
    <tbody>

    <?php foreach($data as $value){ ?>
    <tr>
    <td><input name="list[]" type="checkbox" value="<?php echo $value['id']; ?>" /></td>
    <td><?php echo $value['id']; ?></td>
    <td><?php echo $value['name']; ?></td>
    <td>入职时间：<?php echo date('Y-m-d',$value['addtime']); ?></td>
    <td><?php echo $value['tname']; ?></td>
    <td><?php echo $value['status']==1?'已开班':'未开班'; ?></td>
    <td>
          <a href="upclass.php?id=<?php echo $value['id']; ?>" class="tablelink">编辑</a>
          <a href="#" data-del="<?php echo $value['id']; ?>" class="tablelink del"> 删除</a></td>
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
        <p>是否确认删除班级 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>
    
    
    
    
    </div>
    
    <div class="tip">
    	<div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认对信息的修改 ？</p>
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
        var delId;
        for(var i =0;i<del.length;i++){
            del[i].onclick=function(){
                delId=[];
                if(this.getAttribute('data-del')!==null){
                    delId[0] = this.getAttribute('data-del');
                }else{
                    for(var i=0;i<list.length;i++){
                        if(list[i].checked){
                            delId.push(list[i].value);
                        }
                    }
                }
                // location.href = "?del="+delId.join(',');
                 // console.log(delId.join(','));
            }
        }


        $(".sure").click(function(){
            $(".tip").fadeOut(100);
            location.href="?del="+delId.join(',');
        });
      })();

	</script>
    
</body>

</html>
