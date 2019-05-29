<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$home_club_id = $_POST['home_club_id'];
$away_club_id = $_POST['away_club_id'];
$date = $_POST['date'];
$result = $_POST['result'];

$ret = mysqli_query($conn, "INSERT INTO match_result (`home_club_id`, `away_club_id`, `result`, `date`) VALUES('$home_club_id', '$away_club_id', '$result','$date')");
if(!$ret)
{
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 입력 되었습니다');//message box
    echo "<meta http-equiv='refresh' content='0;url=match_result_list.php'>";//move to product_list.php
}
?>