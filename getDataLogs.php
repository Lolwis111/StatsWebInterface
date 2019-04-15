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
    
    $json = "{";
    
    $json = $json . '"uptime":"' . substr(exec("uptime -p"), 3) . '",';
    $json = $json . '"kernel":"' . exec("uname -r") . '",';
    $json = $json . getDatacount($mysqli) . ",";
    $json = $json . getRawLogs($mysqli) . ",";
    $json = $json . getRawEnvironment($mysqli) . ",";
    
    $json = $json . getTempStats($mysqli) . ",";
    $json = $json . getHumidityStats($mysqli) . ",";
    
    $json = $json . getRAMStats($mysqli) . ",";
    $json = $json . getCPUTempStats($mysqli) . ",";
    $json = $json . getPingStats($mysqli) . ",";
    
    $json = $json . getDailyAveragesEnvironment($mysqli) . ",";
    $json = $json . getDailyAveragesLogs($mysqli) . ",";
    $json = $json . getWeeklyTemperature($mysqli) . ",";
    $json = $json . getWeeklyHumidity($mysqli) . ",";
    $json = $json . getAveragePing($mysqli) . ",";
    $json = $json . getMonthlyHumidity($mysqli) . ",";
    $json = $json . getMonthlyTemps($mysqli) . ",";
    $json = $json . getMonthlyCPUTemps($mysqli);
    
    $json = $json . "}";
    
    echo $json;
    

    $mysqli->close();
    
    function getDatacount($mysqli)//
    {
        $query = "SELECT COUNT(`ID`) as datacount from `logs`";
    
        $result = querySql($query, $mysqli);
        $json = "";
        if($row = $result->fetch_assoc())
        {
            $json = '"datacountLogs":"' . $row["datacount"] . '",';
        }
        
        $result->free();
        
        $query = "SELECT COUNT(`ID`) as datacount from `environment`";
    
        $result = querySql($query, $mysqli);

        if($row = $result->fetch_assoc())
        {
            $json = $json . '"datacountEnvironment":"' . $row["datacount"] . '"';
        }
        
        $result->free();
        
        return $json;
    }
    
    function getTempStats($mysqli)//
    {
        $query = "SELECT ROUND(MAX(`Temperature`), 3) as maxtemp," 
            . "ROUND(MIN(`Temperature`), 3) as mintemp, "
            . "ROUND(AVG(`Temperature`), 3) as avgtemp "
            . "FROM `environment`;";
                
        $result = querySql($query, $mysqli);
        $json = "";
        if($row = $result->fetch_assoc())
        {
            $json = '"environmenttempstats":{"min":' . $row["mintemp"] 
                    . ',"max":' . $row["maxtemp"] 
                    . ',"avg":' . $row["avgtemp"] 
                    . '}';
        }
        
        $result->free();
        return $json;
    }
    
    function getHumidityStats($mysqli)//
    {
        $query = "SELECT ROUND(MAX(`Humidity`), 3) as maxhumidity,"
            . "ROUND(MIN(`Humidity`), 3) as minhumidity,"
            . "ROUND(AVG(`Humidity`), 3) as avghumidity "
            . "FROM `environment`;";
            
        $result = querySql($query, $mysqli);
        $json = "";
        if($row = $result->fetch_assoc())
        {
            $json = '"humiditystats":{"min":' . $row["minhumidity"] 
                    . ',"max":' . $row["maxhumidity"] 
                    . ',"avg":' . $row["avghumidity"] . '}';
        }
        
        $result->free();
        return $json;
    }
    
    function getPingStats($mysqli)//
    {
        // select stats of ping
        $query = "SELECT ROUND(MAX(`Ping`), 3) as maxping," 
            . "ROUND(MIN(`Ping`), 3) as minping, "
            . "ROUND(AVG(`Ping`), 3) as avgping FROM `logs`;";
                
        $result = querySql($query, $mysqli);
        $json = "";
        if($row = $result->fetch_assoc())
        {
            $json = '"pingstats":{"min":' . $row["minping"] 
                    . ',"max":' . $row["maxping"] 
                    . ',"avg":' . $row["avgping"] 
                    . '}';
        }
        
        $result->free();
        return $json;
    }
    
    function getCPUTempStats($mysqli)//
    {
        // select stats of temp
        $query = "SELECT ROUND(MAX(`CPUTemp`), 3) as maxcpu,"
            . "ROUND(MIN(`CPUTemp`), 3) as mincpu,"
            . "ROUND(AVG(`CPUTemp`), 3) as avgcpu FROM `logs`;";
            
        $result = querySql($query, $mysqli);
        $json = "";
        if($row = $result->fetch_assoc())
        {
            $json = '"cputempstats":{"min":' . $row["mincpu"] 
                    . ',"max":' . $row["maxcpu"] 
                    . ',"avg":' . $row["avgcpu"] . '}';
        }
        
        $result->free();
        return $json;
    }
        
    function getRAMStats($mysqli)//
    {
        // select stats of ram
        $query = "SELECT ROUND(MAX(`UsedRAM`), 3) as maxram,"
            . "ROUND(MIN(`UsedRAM`), 3) as minram,"            
            . "ROUND(AVG(`UsedRAM`), 3) as avgram FROM `logs`"
            . "WHERE `UsedRAM` > 0;";
            
        $result = querySql($query, $mysqli);
        $json = "";
        if($row = $result->fetch_assoc())
        {
            $json = '"ramstats":{"min":' . $row["minram"] 
                    . ',"max":' . $row["maxram"] 
                    . ',"avg":' . $row["avgram"]. '}';
        }
        
        $result->free();
        return $json;
    }
    
    function getRawEnvironment($mysqli)//
    {
        // query the raw data here
        $json = '"environmentData":{"values":[';
        
        $where = parseDate();
        $query = "SELECT `Date`,`Time`,`Temperature`,`Humidity` "
            . "FROM `environment` "
            . "{$where} ORDER BY `Date` DESC, `Time` DESC LIMIT 48;";
            
        $result = querySql($query, $mysqli);

        // Build a new json object for each selected row
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"DateTime":"' . $row["Date"] . ' ' . $row["Time"] 
                . '", "Temperature":' . $row["Temperature"] 
                . ',"Humidity":' . $row["Humidity"] . '}';
                
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        
        $json = $json . "]}";
        $result->free();
        return $json;
    }
    
    function getRawLogs($mysqli)//
    {
        // query the raw data here
        $json = '"logsData":{"values":[';
    
        $where = parseDate();
        $query = "SELECT `Date`,`Time`,`Ping`,`CPUTemp`,`UsedRAM` FROM `logs`"
            . "{$where} ORDER BY `Date` DESC, `Time` DESC LIMIT 48;";
            
        $result = querySql($query, $mysqli);

        // Build a new json object for each selected row
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"DateTime":"' . $row["Date"] . ' ' . $row["Time"] 
                . '", "Ping":' . $row["Ping"] 
                . ',"CPUTemp":' . $row["CPUTemp"] 
                . ',"RAM":' . $row["UsedRAM"] . '}';
                
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        
        $json = $json . "]}";
        $result->free();
        return $json;
    }
    
    function getDailyAveragesEnvironment($mysqli)//
    {
        // select the daily averages
        $query = "SELECT `Date`, ROUND(AVG(`Temperature`), 3) as avgtemperature," 
            . "ROUND(AVG(`Humidity`), 3) as avghumidity "
            . "FROM `environment` "
            . "GROUP BY `Date` ORDER BY `Date` DESC LIMIT 12;";
            
        $result = querySql($query, $mysqli);

        $json = '"dailyAveragesEnvironment":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"Date":"' . $row["Date"] 
                . '","AVGTemperature":' . $row["avgtemperature"] 
                . ',"AVGHumidity":' . $row["avghumidity"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        
        $json = $json . "]}";
        $result->free();
        return $json;
    }
    
    function getDailyAveragesLogs($mysqli)//
    {
        // select the daily averages
        $query = "SELECT `Date`, ROUND(AVG(`Ping`), 3) as avgping," 
            . "ROUND(AVG(`CPUTemp`), 3) as avgtemp,"
            . "ROUND(AVG(`UsedRAM`), 3) as avgram FROM `logs`"
            . "GROUP BY `Date` ORDER BY `Date` DESC LIMIT 12;";
            
        $result = querySql($query, $mysqli);

        $json = '"dailyAveragesLogs":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"Date":"' . $row["Date"] 
                . '","AVGPing":' . $row["avgping"] 
                . ',"AVGCPUTemp":' . $row["avgtemp"] 
                . ',"AVGRAM":' . $row["avgram"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        $json = $json . "]}";
        $result->free();
        return $json;
    }
    
    function getWeeklyTemperature($mysqli)//
    {
        // select the daily ping averages by day of week
        $query = "SELECT DAYNAME(`Date`) as weekday,"
            . "ROUND(MAX(`Temperature`), 3) as maxtemperature," 
            . "ROUND(MIN(`Temperature`), 3) as mintemperature, "
            . "ROUND(AVG(`Temperature`), 3) as avgtemperature "
            . "FROM `environment` "
            . "GROUP BY DAYNAME(`Date`)"
            . "ORDER BY WEEKDAY(`Date`)";
            
        $result = querySql($query, $mysqli);

        $json = '"weeklyTemperature":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"WeekDay":"' . $row["weekday"]
                . '","MinTemperature":' . $row["mintemperature"] 
                . ',"MaxTemperature":' . $row["maxtemperature"] 
                . ',"AVGTemperature":' . $row["avgtemperature"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        $json = $json . "]}";
        $result->free();
        
        return $json;
    }
    
    function getWeeklyHumidity($mysqli)//
    {
        // select the daily ping averages by day of week
        $query = "SELECT DAYNAME(`Date`) as weekday,"
            . "ROUND(MAX(`Humidity`), 3) as maxhumidity," 
            . "ROUND(MIN(`Humidity`), 3) as minhumidity, "
            . "ROUND(AVG(`Humidity`), 3) as avghumidity "
            . "FROM `environment` "
            . "GROUP BY DAYNAME(`Date`)"
            . "ORDER BY WEEKDAY(`Date`)";
            
        $result = querySql($query, $mysqli);

        $json = '"weeklyHumidity":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"WeekDay":"' . $row["weekday"]
                . '","MinHumidity":' . $row["minhumidity"] 
                . ',"MaxHumidity":' . $row["maxhumidity"] 
                . ',"AVGHumidity":' . $row["avghumidity"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        $json = $json . "]}";
        
        $result->free();
        return $json;
    }
    
    function getAveragePing($mysqli)
    {
        // select the daily ping averages by day of week
        $query = "SELECT DAYNAME(`Date`) as weekday,"
            . "ROUND(MAX(`Ping`), 3) as maxping," 
            . "ROUND(MIN(`Ping`), 3) as minping, "
            . "ROUND(AVG(`Ping`), 3) as avgping FROM `logs`"
            . "GROUP BY DAYNAME(`Date`)"
            . "ORDER BY WEEKDAY(`Date`)";
            
        $result = querySql($query, $mysqli);

        $json = '"weeklyPing":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"WeekDay":"' . $row["weekday"]
                . '","MinPing":' . $row["minping"] 
                . ',"MaxPing":' . $row["maxping"] 
                . ',"AVGPing":' . $row["avgping"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        $json = $json . "]}";
        
        $result->free();
        return $json;
    }
    
    function getMonthlyTemps($mysqli)
    {
        // select the monthly temp averages
        $query = "SELECT MONTHNAME(`Date`) as month,"
            . "ROUND(MAX(`Temperature`), 3) as maxtemp," 
            . "ROUND(MIN(`Temperature`), 3) as mintemp, "
            . "ROUND(AVG(`Temperature`), 3) as avgtemp FROM `environment`"
            . "GROUP BY MONTHNAME(`Date`)"
            . "ORDER BY MONTH(`Date`)";
            
        $result = querySql($query, $mysqli);
    
        $json = '"monthlyTemp":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"Month":"' . $row["month"]
                . '","MinTemp":' . $row["mintemp"] 
                . ',"MaxTemp":' . $row["maxtemp"] 
                . ',"AVGTemp":' . $row["avgtemp"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        $json = $json . "]}";
        
        $result->free();
        return $json;
    }
    
    function getMonthlyHumidity($mysqli)
    {
        // select the monthly temp averages
        $query = "SELECT MONTHNAME(`Date`) as month,"
            . "ROUND(MAX(`Humidity`), 3) as maxhumidity," 
            . "ROUND(MIN(`Humidity`), 3) as minhumidity, "
            . "ROUND(AVG(`Humidity`), 3) as avghumidity FROM `environment`"
            . "GROUP BY MONTHNAME(`Date`)"
            . "ORDER BY MONTH(`Date`)";
            
        $result = querySql($query, $mysqli);
    
        $json = '"monthlyTemp":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"Month":"' . $row["month"]
                . '","MinHumidity":' . $row["minhumidity"] 
                . ',"MaxHumidity":' . $row["maxhumidity"] 
                . ',"AVGHumidity":' . $row["avghumidity"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        $json = $json . "]}";
        
        $result->free();
        return $json;
    }
    
    function getMonthlyCPUTemps($mysqli)
    {
        // select the monthly temp averages
        $query = "SELECT MONTHNAME(`Date`) as month,"
            . "ROUND(MAX(`CPUTemp`), 3) as maxtemp," 
            . "ROUND(MIN(`CPUTemp`), 3) as mintemp, "
            . "ROUND(AVG(`CPUTemp`), 3) as avgtemp FROM `logs`"
            . "GROUP BY MONTHNAME(`Date`)"
            . "ORDER BY MONTH(`Date`)";
            
        $result = querySql($query, $mysqli);
    
        $json = '"monthlyCPUTemp":{"values":[';
        $rows = $result->num_rows;
        for($i = 0; $i < $rows; $i++)
        {
            $row = $result->fetch_assoc();
            $json = $json . '{"Month":"' . $row["month"]
                . '","MinTemp":' . $row["mintemp"] 
                . ',"MaxTemp":' . $row["maxtemp"] 
                . ',"AVGTemp":' . $row["avgtemp"] . '}';
        
            if($i < $rows - 1)
            {
                $json = $json . ",";
            }
        }
        $json = $json . "]}";
        
        $result->free();
        return $json;
    }
?>
