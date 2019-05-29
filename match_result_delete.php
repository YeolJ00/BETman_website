<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);

$home_club_id = $_GET['home_club_id'];
$away_club_id = $_GET['away_club_id'];
$date = $_GET['date'];

$ret = mysqli_query($conn, "DELETE FROM match_result WHERE home_club_id = '$home_club_id'and away_club_id = '$away_club_id'and date = '$date'");
if(!$ret)
{
	echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    s_msg ('성공적으로 삭제 되었습니다');//message box
    echo "<meta http-equiv='refresh' content='0;url=match_result_list.php'>";//move to product_list.php
}
?>