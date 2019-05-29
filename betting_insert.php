<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$member_id = $_POST['member_id'];
$club_id = $_POST['club_id'];
$amount = $_POST['amount'];

$ret = mysqli_query($conn, "INSERT INTO betting (`member_id`, `club_id`, `amount`) VALUES('$member_id', '$club_id', '$amount')");
if(!$ret)
{
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 입력 되었습니다');//message box
    echo "<meta http-equiv='refresh' content='0;url=betting_list.php'>";//move to product_list.php
}
?>