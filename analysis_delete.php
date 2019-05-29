<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$club_id = $_GET['club_id'];
$expert_id = $_GET['expert_id'];
$ret = mysqli_query($conn, "DELETE FROM analysis WHERE club_id = '$club_id' and expert_id = '$expert_id'");

if(!$ret)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=expert_list.php'>";
}

?>