<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM member";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where member_name like '%$search_keyword%' or member_id like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    <form action="member_list.php" method="post">
		<input type="text" name="search_keyword" placeholder="회원아이디 이름">
	</form>
	<br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>회원 ID</th>
            <th>회원이름</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['member_id']}</td>";
            echo "<td>{$row['member_name']}</td>";
            echo "<td width='10%'>
                 <button onclick='javascript:deleteConfirm({$row['member_id']})' class='button danger small'>삭제</button>
                </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(member_id) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "member_delete.php?member_id=" + member_id.toString();
            }else{   //취소
                return;
            }
        }
    </script>
    
    <?
$mode = "입력";
$action = "member_insert.php";// next file,this file must redirect if possible

?>
    <div class="container">
        <form name="member_form" action="<?=$action?>" method="post" class="fullwidth">
            <p>
                <label for="member_id">회원 아이디</label>
                <input type="text" placeholder="회원 아이디 입력(네자리 숫자)" id="member_id" name="member_id" value="<?=$product['member_id']?>"/>
                <label for="member_name">회원 이름</label>
                <input type="text" placeholder="회원 이름 입력" id="member_name" name="member_name" value="<?=$product['member_name']?>"/>
            	<button class="button primary large" onclick="javascript:return validate();"><?=$mode?>!</button>
            </p>

            <script>
                function validate() {
                    if(document.getElementById("member_id").value == "") {
                        alert ("회원 아이디를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("member_name").value == "") {
                        alert ("이름을 입력해 주십시오"); return false;
                    }else if(/\d{4}/.test(document.getElementById("member_id").value) == ""){
                    	alert("유효한 ID를 입력해주세요"); return false;
                    }
                    return true;
                }
            </script>
        </form>
    </div>
</div>


<? include("footer.php") ?>
