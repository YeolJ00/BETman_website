<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$club_id = $_POST['club_id'];
$expert_id = $_POST['expert_id'];
$comment = $_POST['comment'];

$ret = mysqli_query($conn, "UPDATE analysis SET comment = '$comment' WHERE expert_id = $expert_id AND club_id = $club_id");

if(!$ret)
{
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=expert_list.php'>";
}

?>

