<?php
function dbconnect($host, $id, $pass, $db)
{
    $conn = mysqli_connect($host, $id, $pass, $db);

    if ($conn == false) {
        die('Not connected : ' . mysqli_error());
    }

    return $conn;
}

function msg($msg) 
{
    echo "
        <script>
             window.alert('$msg');
             history.go(-1);
        </script>";
    exit;
}

function s_msg($msg) 
{
    echo "
        <script>
            window.alert('$msg');
        </script>";
}

?>
