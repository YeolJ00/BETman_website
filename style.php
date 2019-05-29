﻿<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);//where is dbname??????????????????????????

if (array_key_exists("news_id", $_GET)) { // get array에서 product_id key가 있으면~ == product id 는 product_list.php에서 전달받음
    $news_id = $_GET["news_id"];
    $club_id = $_GET["club_id"];
    $query =  "SELECT * FROM related NATURAL JOIN club NATURAL JOIN news WHERE news_id = $news_id AND club_id = $club_id";
    $res = mysqli_query($conn, $query);
    $product = mysqli_fetch_array($res);
    $mode = "수정";
    $action = "news_modify.php";
}
?>
    <div class="container">
        <form name="news_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="news_id" value="<?=$product['news_id']?>"/> <!--input header 이 무엇인가-->
        	<h4>구단: <?=$product['club_name']?></h4>
            <p>
                <label for="article">기사 수정</label>
                <textarea placeholder="기사 입력" id="article" name="article" rows="10"><?=$product['article']?></textarea>
            </p>
			<!-- headers can have options-->
            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("article").value == "") {
                        alert ("분석 내용을 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>