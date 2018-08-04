<?php
    $sqlServer = [
        'server' => 'localhost', 
        'username' => 'calluser', 
        'password' => 'callpsw', 
        'database' => 'caller'
    ];
    
    function querySql($query, $mysqli)
    {
        if(!$result = $mysqli->query($query))
        {
            echo "Sorry, this website is experiencing problems.";
            echo "Error: Failed to make a MySQL connection\n";
            echo "Errno: " . $mysqli->connect_errno . "\n";
            echo "Error: " . $mysqli->connect_error . "\n";    
            exit;
        }
        else
        {
            return $result;
        }
    }
    
    function parseName($mysqli)
    {
        // check if a date filter is applied
        if(isset($_GET["name"]) && !empty($_GET["name"]))
        {
            return $mysqli->real_escape_string($_GET["name"]);
        }
        else
        {
            return "#noname";
        }
    }
?>
