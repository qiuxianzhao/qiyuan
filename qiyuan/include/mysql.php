<?php
	header('Content-Type:text/html;charset=utf-8');
	date_default_timezone_set('PRC');
	require "./mysqli.func.php";
	$con = con('127.0.0.1','root','zjm516423','sjk_3');
	//print_r($conn);
	
	//查询一条数据
	// $sql = "select * from `student` where `id`=15";
	// $res = mysqli_query($conn,$sql);
	// $data = mysqli_fetch_assoc($res);
	//var_dump( $data );
	
	
	//再查询一条数据
	
	// $sql = "select * from `student` where `name`='小号'";
	// $info = get_one($conn,$sql);
	// var_dump( $info );
	
	//查询多条数据
	// $sql = "select * from `student` where `id`>5";
	// $info = get_all($conn,$sql);
	// var_dump( $info );

	
	//删除数据
	// $res = del($conn,'student','`id`=22');
	// if($res ){
	  // echo '删除成功';
	// }else{
	  // echo '删除失败';
	// }
	
	
		//添加的数据[模拟用户提交上来的数据]
		$_POST['name'] = 'abclaowang';
		$_POST['sex'] = '1';
		$_POST['username'] = 'laowangabc';
		$_POST['pwd'] = '654321';
		$_POST['email'] = '123456';
		$_POST['mobi'] = '123456';
		$_POST['class'] = '0';
		$_POST['fav'] = '1;2;3';
		$_POST['age']  = '22';
		$_POST['status']  = '1';
		$_POST['addtime'] = '2016-10-10 12:12:21';
		$_POST['desc'] = '2016-10-10 12:12:21  abvcccccc';
		$img = "uploads/2016/10/13/201610131233554244031.jpg";

		define('KEY','abcsdeg');
		
		
		//接收数据并校验数据
		//校验数据 
		$data['name'] =  htmlspecialchars( $_POST['name'] );
		$data['sex'] = $_POST['sex']+0;
		$data['username'] =  htmlspecialchars($_POST['username'] );
		$data['password'] =  htmlspecialchars( $_POST['pwd'] );
		$data['email'] =  htmlspecialchars($_POST['email'] );
		$data['mobi'] = htmlspecialchars( $_POST['mobi'] );
		$data['class_id'] = $_POST['class']+0;
		$data['fav'] =  htmlspecialchars( $_POST['fav'] );
		$data['age'] = $_POST['age']+0;
		$data['status'] = $_POST['status']+0;
		$data['addtime'] = strtotime( $_POST['addtime'] );
		$data['desc'] =  htmlspecialchars( $_POST['desc'] );
		$where = '`id`=28';

        /* @function      edit                 修改数据
         * @param         resource    $conn    连接标识符
         * @param         string      $table   要修改数据的表名
         * @param         array       $data    要修改的数据      
         * @param         string      $where   修改数据的条件      
         * @return        boolean              成功则返回受影响行数
		 */
		// function edit($conn,$table,$data){
		// 	$sql = "insert into $table (`";
		// 	$sql .= implode('`,`',array_keys($data));
		// 	$sql .= "`) values ('";
		// 	$sql .= implode("','",array_values($data))."')";
		// 	echo $sql;
		// }
		edit($con,'student',$data,$where);

		//UPDATE `student` SET `name`= '$name', `avator`='$img', `username`='$username',`password`='$pwd',`status`=$status,`sex`=$sex,`age`=$age,`addtime`=$addtime,`class_id`=$class,`desc`='$desc',`fav`='$fav',`mobi`='$mobi',`email`='$email' WHERE `id`=$id
?>

	
	
	
	