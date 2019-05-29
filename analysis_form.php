<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);//where is dbname??????????????????????????

if (array_key_exists("expert_id", $_GET)) { // get array에서 product_id key가 있으면~ == product id 는 product_list.php에서 전달받음
    $expert_id = $_GET["expert_id"];
    $club_id = $_GET["club_id"];
    $query =  "SELECT * FROM analysis NATURAL JOIN club NATURAL JOIN expert WHERE expert_id = $expert_id AND club_id = $club_id";
    $res = mysqli_query($conn, $query);
    $product = mysqli_fetch_array($res);
    $mode = "수정";
    $action = "analysis_modify.php";
}
?>
    <div class="container">
        <form name="analysis_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="expert_id" value="<?=$product['expert_id']?>"/> <!--input header 이 무엇인가-->
            <input type="hidden" name="club_id" value="<?=$product['club_id']?>"/>
        	<h4>전문가: <?=$product['expert_name']?></h4>
        	<h4>구단: <?=$product['club_name']?></h4>
            <p>
                <label for="comment">분석 내용 수정</label>
                <textarea placeholder="분석 입력" id="comment" name="comment" rows="10"><?=$product['comment']?></textarea>
            </p>
			<!-- headers can have options-->
            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("comment").value == "") {
                        alert ("분석 내용을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>