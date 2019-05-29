<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$club_id = $_GET['club_id'];
$news_id = $_GET['news_id'];
$ret1 = mysqli_query($conn, "DELETE FROM related WHERE club_id = '$club_id' and news_id = '$news_id'");
$ret2 = mysqli_query($conn, "DELETE FROM news WHERE news_id = '$news_id'");

if(!$ret1)
{
    msg('Query Error 1: '.mysqli_error($conn));
}else if(!$ret2){
    msg('Query Error 2: '.mysqli_error($conn));	
}
else
{
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=news_list.php'>";
}

?>