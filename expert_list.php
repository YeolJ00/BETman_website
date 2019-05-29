<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM expert NATURAL JOIN analysis NATURAL JOIN club";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " WHERE club_name like '%$search_keyword%' or expert_name like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
	<form action="expert_list.php" method="post">
		<input type="text" name="search_keyword" placeholder="전문가이름 구단이름">
	</form>
	<br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>전문가</th>
            <th>등급</th>
            <th>분석 팀</th>
            <th>분석</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['expert_name']}</td>";
            echo "<td>{$row['rank']}</td>";
            echo "<td>{$row['club_name']}</td>";
            echo "<td>{$row['comment']}</td>";
            echo "<td width='17%'>
                <a href='analysis_form.php?club_id={$row['club_id']}&expert_id={$row['expert_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['club_id']},{$row['expert_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        //str_pad($number, 2, '0', STR_PAD_LEFT)
        //str_pad($row['club_id'], 4, '0', STR_PAD_LEFT);
        //{$row['club_id']}
        //
        //cid.toString().padStart(4,'0')
        //
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(club_id, expert_id) {
        	
        	var cid = Number(String(club_id));
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "analysis_delete.php?club_id=" + cid.toString(8).padStart(4,'0') + "&expert_id="+ expert_id;
            }else{   //취소
                return;
            }
            
        }
    </script>
    
<?
$mode = "입력";
$action = "expert_insert.php";// next file,this file must redirect if possible

$experts = array();// make array (index can be string format)
$query2 = "SELECT * FROM expert"; // string format query : we want the list of manufacturer
$res2 = mysqli_query($conn, $query2);
while($row = mysqli_fetch_array($res2)) {// for each row~
    $experts[$row['expert_id']] = $row['expert_name'];//save in club array with some index and some value
}
$clubs = array();// make array (index can be string format)
$query3 = "SELECT * FROM club"; // string format query : we want the list of manufacturer
$res3 = mysqli_query($conn, $query3);
while($row3 = mysqli_fetch_array($res3)) {// for each row~
    $clubs[$row3['club_id']] = $row3['club_name'];//save in club array with some index and some value
}
?>
    <div class="container">
        <form name="expert_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="expert_id" value="<?=$product['expert_id']?>"/> <!--input header 이 무엇인가-->
            <h4>새로운 분석 <?=$mode?></h4> <!--php echo with ###-->
            <p>
                <label for="expert_id">전문가</label>
                <select name="expert_id" id="expert_id">
                    <option value="-1">선택해 주십시오.</option>
                    <? // options for select box, -1 is default
                        foreach($experts as $id => $name) {//club list maps into id and name
                            if($id == $product['expert_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            
            <input type="hidden" name="club_id" value="<?=$product['club_id']?>"/> <!--input header 이 무엇인가-->
            <p>
                <label for="club_id">구단</label>
                <select name="club_id" id="club_id">
                    <option value="-1">선택해 주십시오.</option>
                    <? // options for select box, -1 is default
                        foreach($clubs as $id3 => $name3) {//club list maps into id and name
                            if($id3 == $product['club_id']){
                                echo "<option value='{$id3}' selected>{$name3}</option>";
                            } else {
                                echo "<option value='{$id3}'>{$name3}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="comment">분석</label>
                <input type="text" placeholder="분석 내용 입력" id="comment" name="comment" value="<?=$product['comment']?>"/>
            	<button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button>
            </p>

            <script>
                function validate() {
                    if(document.getElementById("club_id").value == "-1") {
                        alert ("구단을 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("expert_id").value == "") {
                        alert ("전문가를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("comment").value == "") {
                        alert ("분석을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>
        </form>
    </div>
    
</div>
<? include("footer.php") ?>
