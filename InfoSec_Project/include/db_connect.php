<?php
    $db_server = "localhost"; 
    $db_user = "root";
    $db_pass = ""; 
    $db_name = "try_db";
    $port = 3306;
        
    try {
        $conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name, $port);    
    }
    catch (mysqli_sql_exception) {
        echo "Failed to connect";
    }
?>