<?php

/* @function  连接数据库
 * 
 */

 function con($host,$user,$psw,$db,$cset='utf8'){
	$con = mysqli_connect($host,$user,$psw,$db);
	mysqli_set_charset($con,$cset);
	return $con;
 }
// $con = con('127.0.0.1','root','zjm516423','sjk_1');
// print_r($con);die;

/* @function 查询多条数据
 * 
 */
 function getAll($con,$sql){
	$res = mysqli_query($con,$sql);
	$data = [];
	while( $row = mysqli_fetch_assoc($res) ){
		$data[] = $row;
	}
	//此处报错 
    mysqli_free_result($res);
	return $data;
 }


/* @function 查询一条数据
 * 
 */
 function getOne($con,$sql){
	$res = mysqli_query($con,$sql);
	$row = mysqli_fetch_assoc($res);
	return $row;
 }

/* @function 添加数据
 * 
 */
 function add($con,$table,$data){
  	$sql = "insert into $table (`";
	$sql .= implode('`,`',array_keys($data));
	$sql .= "`) values ('";
	$sql .= implode("','",array_values($data))."')";
	$res = mysqli_query($con,$sql);
	return $res && mysqli_affected_rows($con);
 }

//zhenggzebiaodashi1
/* @function 删除数据
 * 
 */
 function del($con,$table,$where){
  	$sql = "delete from $table where $where";
  	$res = mysqli_query($con,$sql);
  	return $res && mysqli_affected_rows($con);
 }
// del($con,'class',"`id`=5");

/* @function 更新数据
 * 
 */
 function edit($con,$table,$data,$where){
	  $sql = "update $table set ";
	  foreach($data as $k => $v){
	  	$sql .= "`$k`".'='."'$v'".",";
	  }
	  $sql = rtrim($sql,',');
	  $sql .= " where $where";
	  $res = mysqli_query($con,$sql);
	  return $res && mysqli_affected_rows($con);
 }