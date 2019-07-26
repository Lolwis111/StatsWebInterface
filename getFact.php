<?php

    include 'sql.php';

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // open up the connection
    $mysqli = new mysqli($sqlServer['server'], 
            $sqlServer['username'], 
            $sqlServer['password'], 
            "weird_flex");

    // check if that worked
    if($mysqli->connect_errno)
    {
        echo "Sorry, this website is experiencing problems.";
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
    
        exit;
    }
    
    $json = "{";

    $json = $json . getFact();
    
    $json = $json . "}";
    
    echo $json;
    

    $mysqli->close();
    
    function getFact($mysqli)
    {
        $query = "SELECT * FROM `facts` WHERE `ID` >= (RAND() * ( SELECT MAX(`ID`) FROM `facts` )) + 1 ORDER BY `ID` LIMIT 1;";
    
        $result = querySql($query, $mysqli);
        $json = "";
        if($row = $result->fetch_assoc())
        {
            $json = $json . '"fact": ' . $row['Fact'];
        }
        
        $result->free();
        
        return $json;
    }
?>
