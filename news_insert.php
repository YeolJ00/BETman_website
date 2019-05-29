﻿<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$article = $_POST['article'];
$club_id = $_POST['club_id'];

$ret1 = mysqli_query($conn, "INSERT INTO news (`article`) VALUES('$article')");
$res = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM news WHERE `article` = '$article'"));
$news_id = $res['news_id'];
$ret2 = mysqli_query($conn,"INSERT INTO related (`club_id`,`news_id`) VALUES('$club_id','$news_id')");
if(!$ret1)
{
	echo mysqli_error($conn);
    msg('Query Error 1: '.mysqli_error($conn));
}
else if(!$ret2){
	echo mysqli_error($conn);
    msg('Query Error 2: '.mysqli_error($conn));
}
{
    s_msg ('성공적으로 입력 되었습니다');//message box
    echo "<meta http-equiv='refresh' content='0;url=news_list.php'>";//move to product_list.php
}
?>