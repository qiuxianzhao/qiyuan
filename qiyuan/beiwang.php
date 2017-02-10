<?php 
    require_once './include/common.conf.php';
    require_once './src/pagination/pagination.func.php';

 //SELECT ah.`id`,s.`name`,c.`name`,`point`,ah.`addtime` from achievement ah LEFT join student s on ah.`sid`=s.`id` LEFT JOIN course c ON ah.`cid`=c.`id`

    if(isset($_GET['del'])){
        $del = $_GET['del'];
        $res = del($con,'achievement',"id in ($del)");
        if($res){
            showMsg('删除成绩成功！','show-achi.php');
        }else{
            showMsg('删除成绩失败！');
        }
    }

    if($_POST){
        $stu_name = htmlspecialchars($_POST['stu_name']);
        $course_name = $_POST['course_name'];
        $class_name = $_POST['class_name'];
        if($stu_name!=''){
            $stu_where = "s.`name`='$stu_name' and";
        }else{
            $stu_where ="";
        }
        if($course_name!=''){
            $course_where = "c.`id`='$course_name' and";
        }else{
            $course_where = "";
        }
        if($class_name!=''){
            $class_where = "s.`class_id`='$class_name' and";
        }else{
            $class_where = "";
        }
    
	//var_dump();die;
    //分页的必须参数
    $sql = "select count(ah.`id`) c from `achievement` ah left join student s on ah.`sid`=s.`id` left join `course` c on ah.`cid`=c.`id` left join class cl on s.`class_id`=cl.`id` where $stu_name $course_name $class_name 1";
    $count = getOne($con,$sql)['c'];

    if(isset($_GET['page']) && $_GET['page']>=1){
        $pagenow = $_GET['page'];
    }else{
        $pagenow = 1;
    }

    $pagesize = 5;            //每页多少条记录
    $showpage = 5;            //显示页数的数量
}
    $sql = "select ah.`id`,s.`name` sname,c.`name` cname,`point`,ah.`addtime` addtime,cl.`name` classname from achievement ah left join student s on ah.`sid`=s.`id` left join course c on ah.`cid`=c.`id` left join class cl on s.`class_id`=cl.`id` where $stu_where $course_where $class_where 1 limit ".($pagenow-1)*$pagesize.",$pagesize";
    //echo $sql;die;
    $data = getAll($con,$sql);
//select count(ah.`id`) c from `achievement` ah left join student s on ah.`sid`=s.`id` left join `course` c on ah.`cid`=c.`id` left join class cl on s.`class_id`=cl.`id` where $stu_where $course_where $class_where 1

    //查找所有的班级，用来做条件查询
    $sql = "select * from class";
    $class = getAll($con,$sql);

    //查找所有课程，也是用来做条件查询
    $sql ="select * from course";
    $course = getAll($con,$sql);
 //Notice: Undefined variable: pagenow in D:\wamp\www\2016-10-19-0\SCM1\show-achi.php on line 51

Notice: Undefined variable: pagesize in D:\wamp\www\2016-10-19-0\SCM1\show-achi.php on line 51

Notice: Undefined variable: pagesize in D:\wamp\www\2016-10-19-0\SCM1\show-achi.php on line 51

Warning: mysqli_fetch_assoc() expects parameter 1 to be mysqli_result, boolean given in D:\wamp\www\2016-10-19-0\SCM1\include\mysqli.func.php on line 21

Warning: mysqli_free_result() expects parameter 1 to be mysqli_result, boolean given in D:\wamp\www\2016-10-19-0\SCM1\include\mysqli.func.php on line 25
 ?>
