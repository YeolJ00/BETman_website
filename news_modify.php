﻿<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$news_id = $_POST['news_id'];
$article = $_POST['article'];

$ret = mysqli_query($conn, "UPDATE news SET article = '$article' WHERE news_id = $news_id");

if(!$ret)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=news_list.php'>";
}

?>

