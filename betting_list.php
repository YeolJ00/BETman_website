<?
include "header.php";
include "config.php";
include "util.php";
?>
<div class="container">
    <?
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    $query = "SELECT * FROM betting NATURAL JOIN member NATURAL JOIN club";
    if (array_key_exists("search_keyword", $_POST)) {  //comes from line 20
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where member_name like '%$search_keyword%' or club_name like '%$search_keyword%'";
    
    }// additional query for search
    $res = mysqli_query($conn, $query);
    if (!$res) {
         die('Query Error : ' . mysqli_error());
    }
    ?>
    <form action="betting_list.php" method="post">
		<input type="text" name="search_keyword" placeholder="회원이름 구단이름">
	</form>
	<br>
    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>NO.</th>
            <th>회원이름</th>
            <th>구단 이름</th>
            <th>구매 금액</th>
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['member_name']}</td>";
            echo "<td>{$row['club_name']}</td>";
            echo "<td>{$row['amount']}</td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    
    
    
 <?
$mode = "등록";
$action = "betting_insert.php";// next file,this file must redirect if possible

$clubs = array();// make array (index can be string format)
$query2 = "SELECT * FROM club"; // string format query : we want the list of manufacturer
$res2 = mysqli_query($conn, $query2);
while($row = mysqli_fetch_array($res2)) {// for each row~
    $clubs[$row['club_id']] = $row['club_name'];//save in club array with some index and some value
}
?>
    <div class="container">
        <form name="club_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="club_id" value="<?=$product['club_id']?>"/> <!--input header 이 무엇인가-->
            <h4>베팅 <?=$mode?></h4> <!--php echo with ###-->
            <p>
                <label for="club_id">구단</label>
                <select name="club_id" id="club_id">
                    <option value="-1">선택해 주십시오.</option>
                    <? // options for select box, -1 is default
                        foreach($clubs as $id => $name) {//club list maps into id and name
                            if($id == $product['club_id']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="member_id">회원 아이디</label>
                <input type="text" placeholder="회원 아이디 입력" id="member_id" name="member_id" value="<?=$product['member_id']?>"/>
                <label for="amount">가격</label>
                <input type="number" placeholder="정수로 입력" id="amount" name="amount" value="<?=$product['amount']?>" />
            	<button class="button primary large" onclick="javascript:return validate();"><?=$mode?>!</button>
            </p>

            <script>
                function validate() {
                    if(document.getElementById("club_id").value == "-1") {
                        alert ("구단을 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("member_id").value == "") {
                        alert ("회원 아이디를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("amount").value == "") {
                        alert ("금액을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>
        </form>
    </div>
</div>
<? include("footer.php") ?>
