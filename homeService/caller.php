<?php

    include 'sql.php';

    // open up the connection
    $mysqli = new mysqli($sqlServer['server'], 
            $sqlServer['username'], 
            $sqlServer['password'], 
            $sqlServer['database']);

    // check if that worked
    if($mysqli->connect_errno)
    {
        echo '{"result":"database error"}';
    
        exit;
    }

    $name = parseName($mysqli);
    
    if($name == "#noname")
    {
        echo '{"result":"invalid name"}';
        
        $mysqli->close();
    
        exit;
    }

    $time = date("H:i:s");
    $date = date("y-m-d");
    
    $query = "INSERT INTO requests(`Name`, `Reason`, `Priority`, `Date`, `Time`, `Processed`) VALUES ('{$name}', 'Essen', 'Normal', '{$date}', '{$time}', 0);";

    $result = querySql($query, $mysqli);

    if($result == true)
    {
        echo '{"result":"success"}';
        exec("./homeService.py");
    }
    else
    {
        echo '{"result":"insert error"}';
    }

    $mysqli->close();
?>
