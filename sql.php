<?php
    $sqlServer = [
        'server' => 'localhost', 
        'username' => 'loguser', 
        'password' => 'pylogpsw', 
        'database' => 'logger',
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
    
    function parseDate()
    {
        // check if a date filter is applied
        if(isset($_GET["date"]) && !empty($_GET["date"]))
        {
            $date = $mysqli->real_escape_string($_GET["date"]);
                
            if(isset($_GET["am"]))
            {
                return "WHERE `Date` = '{$date}' AND `Time`<='12:00:05'";
            }
            else if(isset($_GET["pm"]))
            {
                return "WHERE `Date` = '{$date}' AND `Time`>'12:00:05'";
            }
            else
            {
                return "";
            }
        }
    }
?>
