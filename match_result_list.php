<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM match_result NATURAL JOIN (SELECT club_id as home_club_id, club_name as home_name FROM club)h NATURAL JOIN (SELECT club_id as away_club_id, club_name as away_name FROM club)a";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " WHERE home_name like '%$search_keyword%' or away_name like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
	<form action="match_result_list.php" method="post">
		<input type="text" name="search_keyword" placeholder="구단이름">
	</form>
	<br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>홈 구단</th>
            <th>어웨이 구단</th>
            <th>날짜</th>
            <th>결과</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['home_name']}</td>";
            echo "<td>{$row['away_name']}</td>";
            echo "<td>{$row['date']}</td>";
            echo "<td>{$row['result']}</td>";
            $dates = explode("-", $row['date']);
            echo "<td width='10%'>
                 <button onclick='javascript:deleteConfirm({$row['home_club_id']},{$row['away_club_id']},{$dates[0]},{$dates[1]},{$dates[2]})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        //str_pad($number, 2, '0', STR_PAD_LEFT)
        //str_pad($row['club_id'], 4, '0', STR_PAD_LEFT);
        //{$row['club_id']}
        //,{$row['date']}
        //cid.toString().padStart(4,'0')
        //{$row['date']}
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(home_club_id, away_club_id, year, month, day) {
        	var hid = Number(String(home_club_id));
        	var aid = Number(String(away_club_id));
        	var year = String(year);
        	var month = String(month).padStart(2,'0');
        	var day = String(day).padStart(2,'0');
        	var fulldate = year.concat('-',month.concat('-',day));
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "match_result_delete.php?home_club_id=" + hid.toString(8).padStart(4,'0') + "&away_club_id="+ aid.toString(8).padStart(4,'0') +"&date="+fulldate;
            }else{   //취소
                return;
            }
            
        }
    </script>
    
<?
$mode = "입력";
$action = "match_result_insert.php";// next file,this file must redirect if possible

$clubs = array();// make array (index can be string format)
$query3 = "SELECT * FROM club"; // string format query : we want the list of manufacturer
$res3 = mysqli_query($conn, $query3);
while($row3 = mysqli_fetch_array($res3)) {// for each row~
    $clubs[$row3['club_id']] = $row3['club_name'];//save in club array with some index and some value
}
?>
    <div class="container">
        <form name="atch_result_form" action="<?=$action?>" method="post" class="fullwidth">
            <h4>경기결과 입력 <?=$mode?></h4> <!--php echo with ###-->
            
            <input type="hidden" name="home_club_id" value="<?=$product['home_club_id']?>"/> <!--input header 이 무엇인가-->
            <p>
                <label for="home_club_id"> 홈 구단</label>
                <select name="home_club_id" id="home_club_id">
                    <option value="-1">구단을 선택해주세요</option>
                    <? // options for select box, -1 is defaul홈t
                        foreach($clubs as $id3 => $name3) {//club list maps into id and name
                            if($id3 == $product['home_club_id']){
                                echo "<option value='{$id3}' selected>{$name3}</option>";
                            } else {
                                echo "<option value='{$id3}'>{$name3}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <input type="hidden" name="away_club_id" value="<?=$product['away_club_id']?>"/> <!--input header 이 무엇인가-->
            <p>
                <label for="away_club_id">어웨이 구단</label>
                <select name="away_club_id" id="away_club_id">
                    <option value="-1">구단을 선택해주세요</option>
                    <? // options for select box, -1 is default
                        foreach($clubs as $id2 => $name2) {//club list maps into id and name
                            if($id2 == $product['away_club_id']){
                                echo "<option value='{$id2}' selected>{$name2}</option>";
                            } else {
                                echo "<option value='{$id2}'>{$name2}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <input type="hidden" name="result" value="<?=$product['result']?>"/> <!--input header 이 무엇인가-->
            <p>
                <label for="result">경기결과</label>
                <select name="result" id="result">
                    <option value="-1">승패를 정해주세요</option>
                    <option value='win' selected>홈팀 승</option>
					<option value='lose'>홈팀 패</option>
					<option value='draw'>무승부</option>
                </select>
            </p>
			<p>
                <label for="date">날짜</label>
                <input type="text" placeholder="XXXX-XX-XX" id="date" name="date" value="<?=$product['date']?>"/>
            	<button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button>
            </p>
            <script>
                function validate() {
                	if(document.getElementById("home_club_id").value == "-1") {
                        alert ("홈 구단을 선택해주십시오"); return false;
                    }
                    else if(document.getElementById("away_club_id").value == "-1") {
                        alert ("어웨이 구단을 선택해주십시오"); return false;
                    }
                    if(document.getElementById("date").value == "") {
                        alert ("날짜를 입력해주세요"); return false;
                    }
                    if(/\d{4}-[0-2]\d-[0-3]\d/.test(document.getElementById("date").value) == "") {
                        alert ("올바른 날짜를 입력해주세요"); return false;
                    }
                    return true;
                }
            </script>
        </form>
    </div>
    
</div>
<? include("footer.php") ?>
