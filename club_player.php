<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

if (array_key_exists("club_id", $_GET)) {
    $club_id = $_GET["club_id"];
    $query = "SELECT * FROM club NATURAL JOIN player NATURAL JOIN plays_for WHERE club_id = $club_id";
    $res = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($res);
}
?>
<div class=container>
	<h2><?echo $row['club_name']?> </h2><br>
	<h4> 연고지: <?echo $row['home_town']?></h4><br>
    <table class="tablesmall table-striped table-bordered">
        <thead>
        <tr>
            <th>선수 이름</th>
            <th>등번호</th>
            <th>선수 상태</th>
        </tr>
        </thead>
        <tbody>
        <?
        do{
            echo "<tr>";
            echo "<td>{$row['player_name']}</td>";
            echo "<td>{$row['backnumber']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "</tr>";
        }while ($row = mysqli_fetch_array($res)) 
        ?>
        </tbody>
    </table>
</div>
<? include("footer.php") ?>