<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM (news LEFT JOIN related ON news.news_id = related.news_id) LEFT JOIN club ON related.club_id = club.club_id";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " WHERE club_name like '%$search_keyword%' or article like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
	<form action="news_list.php" method="post">
		<input type="text" name="search_keyword" placeholder="구단이름 뉴스내용">
	</form>
	<br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>연관 구단</th>
            <th>기사</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['club_name']}</td>";
            echo "<td>{$row['article']}</td>";
            echo "<td width='17%'>
                <a href='news_form.php?news_id={$row['news_id']}&club_id={$row['club_id']}'><button class='button primary small'>수정</button></a>
                 <button onclick='javascript:deleteConfirm({$row['club_id']},{$row['news_id']})' class='button danger small'>삭제</button>
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
        function deleteConfirm(club_id, news_id) {
        	
        	var cid = Number(String(club_id));
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "news_delete.php?club_id=" + cid.toString(8).padStart(4,'0') + "&news_id="+ news_id;
            }else{   //취소
                return;
            }
            
        }
    </script>
    
<?
$mode = "입력";
$action = "news_insert.php";// next file,this file must redirect if possible

$clubs = array();// make array (index can be string format)
$query3 = "SELECT * FROM club"; // string format query : we want the list of manufacturer
$res3 = mysqli_query($conn, $query3);
while($row3 = mysqli_fetch_array($res3)) {// for each row~
    $clubs[$row3['club_id']] = $row3['club_name'];//save in club array with some index and some value
}
?>
    <div class="container">
        <form name="expert_form" action="<?=$action?>" method="post" class="fullwidth">
            <h4>새로운 기사 <?=$mode?></h4> <!--php echo with ###-->
            
            <input type="hidden" name="club_id" value="<?=$product['club_id']?>"/> <!--input header 이 무엇인가-->
            <p>
                <label for="club_id">연관 구단</label>
                <select name="club_id" id="club_id">
                    <option value="-1">구단을 선택해주세요</option>
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
                <label for="article">기사</label>
                <input type="text" placeholder="기사 내용 입력" id="article" name="article" value="<?=$product['article']?>"/>
            	<button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button>
            </p>

            <script>
                function validate() {
                	if(document.getElementById("club_id").value == "-1") {
                        alert ("구단을 선택해주십시오"); return false;
                    }
                    if(document.getElementById("article").value == "") {
                        alert ("기사를 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>
        </form>
    </div>
    
</div>
<? include("footer.php") ?>
