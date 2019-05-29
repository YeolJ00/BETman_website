<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$member_id = $_GET['member_id'];

$ret = mysqli_query($conn, "DELETE FROM member WHERE member_id = $member_id");

if(!$ret)
{
    msg('베팅 내역이 있는 회원은 삭제할 수 없습니다.');
}
else
{
    s_msg ('성공적으로 삭제 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=member_list.php'>";
}

?>

