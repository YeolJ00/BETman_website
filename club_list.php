<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM club";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where club_name like '%$search_keyword%' or home_town like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    <form action="club_list.php" method="post">
		<input type="text" name="search_keyword" placeholder="구단 이름 연고지">
	</form>
	<br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>구단 ID</th>
            <th>구단 이름</th>
            <th>연고지</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['club_id']}</td>";
            echo "<td><a href='club_player.php?club_id={$row['club_id']}'>{$row['club_name']}</a></td>";
            echo "<td>{$row['home_town']}</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
</div>
<? include("footer.php") ?>
