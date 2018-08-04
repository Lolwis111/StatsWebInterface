<?php

    include 'sql.php';

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // open up the connection
    $mysqli = new mysqli($sqlServer['server'], 
            $sqlServer['username'], 
            $sqlServer['password'], 
            $sqlServer['database']);

    // check if that worked
    if($mysqli->connect_errno)
    {
        echo "Sorry, this website is experiencing problems.";
        echo "Error: Failed to make a MySQL connection, here is why: \n";
        echo "Errno: " . $mysqli->connect_errno . "\n";
        echo "Error: " . $mysqli->connect_error . "\n";
    
        exit;
    }

    // select stats of ping
    $query = "SELECT COUNT(`ID`) as datacount,"
            . "ROUND(MAX(`Ping`), 3) as maxping," 
            . "ROUND(MIN(`Ping`), 3) as minping, "
            . "ROUND(AVG(`Ping`), 3) as avgping FROM `logs`;";
                
    $result = querySql($query, $mysqli);

    if($row = $result->fetch_assoc())
    {
        echo '{"pingstats":{"min":' . $row["minping"] 
                    . ',"max":' . $row["maxping"] 
                    . ',"avg":' . $row["avgping"] 
                    . '},"datacount":' . $row["datacount"] . ',';
    }
            
    // select stats of temp
    $query = "SELECT ROUND(MAX(`CPUTemp`), 3) as maxcpu,"
            . "ROUND(MIN(`CPUTemp`), 3) as mincpu,"
            . "ROUND(AVG(`CPUTemp`), 3) as avgcpu FROM `logs`;";
            
    $result = querySql($query, $mysqli);

    if($row = $result->fetch_assoc())
    {
        echo '"tempstats":{"min":' . $row["mincpu"] 
                    . ',"max":' . $row["maxcpu"] 
                    . ',"avg":' . $row["avgcpu"] . '},';
    }

    // select stats of ram
    $query = "SELECT ROUND(MAX(`UsedRAM`), 3) as maxram,"
            . "ROUND(MIN(`UsedRAM`), 3) as minram,"            
            . "ROUND(AVG(`UsedRAM`), 3) as avgram FROM `logs`"
            . "WHERE `UsedRAM` > 0;";
            
    $result = querySql($query, $mysqli);
            
    if($row = $result->fetch_assoc())
    {
        echo '"ramstats":{"min":' . $row["minram"] 
                    . ',"max":' . $row["maxram"] 
                    . ',"avg":' . $row["avgram"]. '},';
    }
    
    
    // query the raw data here
    echo '"data":{"values":[';
        
    $where = parseDate();
    $query = "SELECT `Date`,`Time`,`Ping`,`CPUTemp`,`UsedRAM` FROM `logs`"
            . "{$where} ORDER BY `Date` DESC, `Time` DESC LIMIT 48;";
            
    $result = querySql($query, $mysqli);

    // Build a new json object for each selected row
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; $i++)
    {
        $row = $result->fetch_assoc();
        echo '{"DateTime":"' . $row["Date"] . ' ' . $row["Time"] 
                . '", "Ping":' . $row["Ping"] 
                . ',"CPUTemp":' . $row["CPUTemp"] 
                . ',"RAM":' . $row["UsedRAM"] . '}';
                
        if($i < $rows - 1)
        {
            echo ",";
        }
    }
    echo "]},";
    
    // select the daily averages
    $query = "SELECT `Date`, ROUND(AVG(`Ping`), 3) as avgping," 
            . "ROUND(AVG(`CPUTemp`), 3) as avgtemp,"
            . "ROUND(AVG(`UsedRAM`), 3) as avgram FROM `logs`"
            . "GROUP BY `Date` ORDER BY `Date` DESC LIMIT 12;";
            
    $result = querySql($query, $mysqli);

    echo '"dailydata":{"values":[';
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; $i++)
    {
        $row = $result->fetch_assoc();
        echo '{"Date":"' . $row["Date"] 
                . '","AVGPing":' . $row["avgping"] 
                . ',"AVGCPUTemp":' . $row["avgtemp"] 
                . ',"AVGRAM":' . $row["avgram"] . '}';
        
        if($i < $rows - 1)
        {
            echo ",";
        }
    }
    echo "]},";
    
    // select the daily ping averages by day of week
    $query = "SELECT DAYNAME(`Date`) as weekday,"
            . "ROUND(MAX(`Ping`), 3) as maxping," 
            . "ROUND(MIN(`Ping`), 3) as minping, "
            . "ROUND(AVG(`Ping`), 3) as avgping FROM `logs`"
            . "GROUP BY DAYNAME(`Date`)"
            . "ORDER BY WEEKDAY(`Date`)";
            
    $result = querySql($query, $mysqli);

    echo '"weekdaydata":{"values":[';
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; $i++)
    {
        $row = $result->fetch_assoc();
        echo '{"WeekDay":"' . $row["weekday"]
                . '","MinPing":' . $row["minping"] 
                . ',"MaxPing":' . $row["maxping"] 
                . ',"AVGPing":' . $row["avgping"] . '}';
        
        if($i < $rows - 1)
        {
            echo ",";
        }
    }
    echo "]},";
    
    // select the monthly temp averages
    $query = "SELECT MONTHNAME(`Date`) as month,"
            . "ROUND(MAX(`CPUTemp`), 3) as maxtemp," 
            . "ROUND(MIN(`CPUTemp`), 3) as mintemp, "
            . "ROUND(AVG(`CPUTemp`), 3) as avgtemp FROM `logs`"
            . "GROUP BY MONTHNAME(`Date`)"
            . "ORDER BY MONTH(`Date`)";
            
    $result = querySql($query, $mysqli);
    
    echo '"monthlydata":{"values":[';
    $rows = $result->num_rows;
    for($i = 0; $i < $rows; $i++)
    {
        $row = $result->fetch_assoc();
        echo '{"Month":"' . $row["month"]
                . '","MinTemp":' . $row["mintemp"] 
                . ',"MaxTemp":' . $row["maxtemp"] 
                . ',"AVGTemp":' . $row["avgtemp"] . '}';
        
        if($i < $rows - 1)
        {
            echo ",";
        }
    }
    echo "]},";
    
    // add some system information
    echo '"uptime":' . '"' . substr(exec("uptime -p"), 3) . '",';
    echo '"kernel":' . '"' . exec("uname -r") . '"}';

    $result->free();
    $mysqli->close();
?>
