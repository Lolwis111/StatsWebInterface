<?php
    include 'sql.php';

    // open up the connection
    $mysqli = new mysqli($sqlServer['server'],
            $sqlServer['username'],
            $sqlServer['password'],
            "assignments");

    // check if that worked
    if($mysqli->connect_errno)
    {
        echo "Sorry, this website is experiencing problems.";
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";

        exit;
    }

    $result = querySql("SELECT * FROM `tasks`", $mysqli);
    
    $rows = $result->num_rows;
    
    echo '{"tasks":{"values":[';
    for($i = 0; $i < $rows; $i++)
    {
        $row = $result->fetch_assoc();
        
        echo '{';
        echo '"ID":' . $row['ID'] . ',';
        echo '"Name":"' . $row['Name'] . '",';
        echo '"Description":"' . $row['Description'] . '",';
        echo '"StartDate":"' . $row['StartDate'] . '",';
        echo '"EndDate":"' . $row['EndDate'] . '",';
        echo '"Status":"' . $row['Status'] . '"';
        echo '}';
        
        if($i < $rows - 1)
        {
            echo ',';
        }
    }
    
    $result->free();
    
    echo ']}}';
?>
