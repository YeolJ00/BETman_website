<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$member_id = $_POST['member_id'];
$member_name = $_POST['member_name'];

$ret = mysqli_query($conn, "INSERT INTO member (`member_id`, `member_name`) VALUES('$member_id', '$member_name')");
if(!$ret)
{
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 입력 되었습니다');//message box
    echo "<meta http-equiv='refresh' content='0;url=member_list.php'>";//redirect-----------------!!
}
?>