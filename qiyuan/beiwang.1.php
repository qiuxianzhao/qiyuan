<?php 
    require_once './include/common.conf.php';
    require_once './src/pagination/pagination.func.php';

 //SELECT ah.`id`,s.`name`,c.`name`,`point`,ah.`addtime` from achievement ah LEFT join student s on ah.`sid`=s.`id` LEFT JOIN course c ON ah.`cid`=c.`id`

    if(isset($_GET['del'])){
        $del = htmlspecialchars($_GET['del']);
        $res = del($con,'achievement',"id in ($del)");
        if($res){
            showMsg('删除成绩成功！','show-achi.php');
        }else{
            showMsg('删除成绩失败！');
        }
    }
    $sql = "select `avator` from `student` where `id` IN ($del)";
?>
   
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>奇猿网络后台管理中心</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/select.css" rel="stylesheet" type="text/css" />
<link href="./src/pagination/pagination/page.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="js/select-ui.min.js"></script>
<script type="text/javascript" src="editor/kindeditor.js"></script>

<script type="text/javascript">
    KE.show({
        id : 'content7',
        cssPath : './index.css'
    });
  </script>
  
<script type="text/javascript">
$(document).ready(function(e) {

	$(".select3").uedSelect({
		width : 152
	});
});
</script>
</head>

<body class="sarchbody">

	<div class="place">
    <span>位置：</span>
    <ul class="placeul">
    <li><a href="#">首页</a></li>
    <li><a href="#">系统设置</a></li>
    </ul>
    </div>
    
    <div class="formbody">
    
    
    <div id="usual1" class="usual"> 
    
    
    <form action="" name="search" method="post">
        <ul class="seachform1">
        
            <li>
                <label>学生姓名</label>
                <input name="stu_name" type="text" class="scinput1" />
            </li>
            <li>
                <label>课程名称</label>  
                <div class="vocation">
                    <select class="select3" name="course_name">
                        <option value="">请选择课程名称</option>
                        <!-- foreach -->
                        <option value=""></option>
                     
                    </select>
                </div>
            </li>
            
            <li>
                <label>班级</label>  
                <div class="vocation">
                    <select class="select3" name="class_name">
                        <option value="">请选择班级名称</option>
                        
                        <option value=""></option>
                      
                    </select>
                 </div>
            </li>  
        </ul>
    </form>
    <ul class="seachform1">
    <li class="sarchbtn"><label>&nbsp;</label><input name="" type="button" class="scbtn subsearch" value="查询"/>   <input name="" type="button" class="scbtn1 del" value="删除"/>   <input name="" type="button" class="scbtn2" value="导出"/>   <a href="addachi.php"><input name="" type="button" class="scbtn" value="添加成绩"/></a></li>  
    </ul>
    
    <script language="javascript">
    	$(document).ready(function() 
    { 
    $(".scbtn1").click(function() 
    {      
        if( $(".seachform2").hasClass("hideclass") ) 
        { 
            $(".seachform2").removeClass("hideClass"); 
        } 
        else 
        { 
            $(".seachform2").addClass("hideClass"); 
        }    
    }); 
    }); 
    	
    	
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
    
    
    
    
    <div class="formtitle"><span>成绩列表</span></div>
    
    <table class="tablelist">
    	<tr>
        <th><input name="sel_all" type="checkbox" value="" /></th>
        <th>成绩编号<i class="sort"><img src="images/px.gif" /></i></th>
        <th>课程名称</th>
        <th>学生姓名</th>
        <th>所在班级</th>
        <th>成绩</th>
        <th>考试时间</th>
        <th>操作</th>
        </tr>

        <!-- foreach -->
        <tr>
        <td><input name="list" type="checkbox" value="<?php echo $value['id']; ?>" /></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><a href="#" class="tablelink">查看</a>     <a href="#" del-data="" class="tablelink del"> 删除</a></td>
        </tr> 
        
        <!-- foreach -->
    </table>
    
  <!--   <?php  pagination($count,$pagenow,$pagesize,$showpage); ?> -->
       
    	</div> 
 
    </div>

    <script>
        var search = document.getElementsByName('search')[0];
        $('.subsearch').click(function(){
            $(search).trigger('submit');
        })

        var list = document.getElementsByName('list');
        document.getElementsByName('sel_all')[0].onclick = function(){
            for(var i=0;i<list.length;i++){
                 list[i].checked=!list[i].checked;                
            }
        }

        var del = document.querySelectorAll('.del');
        for(var i=0;i<del.length;i++){
            del[i].onclick = function(){
                var del_ach = [];
                if(this.getAttribute('del-data')!=null){
                    del_ach[0] = this.getAttribute('del-data');
                }else{
                    for(var i=0;i<list.length;i++){
                        if(list[i].checked){
                            del_ach.push(list[i].value);
                        }
                    }
                }
                $('.sure').click(function(){
                    $('.tip').fadeOut(200);
                    location.href = "?del="+del_ach.join(',');
                })
            }
        }
    </script>

    <div class="tip">
        <div class="tiptop"><span>提示信息</span><a></a></div>
        
      <div class="tipinfo">
        <span><img src="images/ticon.png" /></span>
        <div class="tipright">
        <p>是否确认删除成绩 ？</p>
        <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
        </div>
        </div>
        
        <div class="tipbtn">
        <input name="" type="button"  class="sure" value="确定" />&nbsp;
        <input name="" type="button"  class="cancel" value="取消" />
        </div>
    
    </div>

</body>

</html>
