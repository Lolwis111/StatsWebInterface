<!DOCTYPE html>

<html>
    <head>
        <title>Levins DEV Server</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body onload="initTabs()">
        <script>
var pingstats = {values:[<?php
                $link = mysql_connect("localhost", "loguser", "Galm34..") or die(mysql_error());

                $data = mysql_select_db("logger", $link) or die(mysql_error());

                $query = "SELECT COUNT(`ID`) as datacount, ROUND(MAX(`Ping`), 3) as maxping, ROUND(MIN(`Ping`), 3) as minping, ROUND(AVG(`Ping`), 3) as avgping FROM `logs`;";
                
                $result = mysql_query($query, $link) or die(mysql_error());
                    
                if($row = mysql_fetch_array($result))
                {
                    echo "{min:{$row["minping"]},max:{$row["maxping"]},avg:{$row["avgping"]}}]};";
                }
                
                echo "var datacount = {$row["datacount"]};"
            ?>
                
var tempstats = {values:[<?php
                $query = "SELECT ROUND(MAX(`CPUTemp`), 3) as maxcpu, ROUND(MIN(`CPUTemp`), 3) as mincpu, ROUND(AVG(`CPUTemp`), 3) as avgcpu FROM `logs`;";
                
                $result = mysql_query($query, $link) or die(mysql_error());
                
                if($row = mysql_fetch_array($result))
                {
                    echo "{min:{$row["mincpu"]},max:{$row["maxcpu"]},avg:{$row["avgcpu"]}}";
                }
            ?>]};

var ramstats = {values:[<?php
                $query = "SELECT ROUND(MAX(`UsedRAM`), 3) as maxram, ROUND(MIN(`UsedRAM`), 3) as minram, ROUND(AVG(`UsedRAM`), 3) as avgram FROM `logs` WHERE `UsedRAM` > 0;";
                
                $result = mysql_query($query, $link) or die(mysql_error());
                
                if($row = mysql_fetch_array($result))
                {
                    echo "{min:{$row["minram"]},max:{$row["maxram"]},avg:{$row["avgram"]}}";
                }
            ?>]};
            
var data = {values:[<?php
                $where = "";
                    
                if(isset($_GET["date"]) && !empty($_GET["date"]))
                {
                    $date = mysql_real_escape_string($_GET["date"]);
                        
                    if(isset($_GET["am"]))
                    {
                        $where = "WHERE `Date` = '{$date}' AND `Time` <= '12:00:05'";
                    }
                    else if(isset($_GET["pm"]))
                    {
                        $where = "WHERE `Date` = '{$date}' AND `Time` > '12:00:05'";
                    }
                }
                    
                $query = "SELECT `Date`,`Time`,`Ping`,`CPUTemp`,`UsedRAM` FROM `logs` {$where} ORDER BY `Date` DESC, `Time` DESC LIMIT 48;";
                $result = mysql_query($query, $link) or die(mysql_error());
                while($row = mysql_fetch_array($result))
                {
                    echo "{DateTime:'{$row["Date"]} {$row["Time"]}', Ping:{$row["Ping"]},CPUTemp:{$row["CPUTemp"]},RAM:{$row["UsedRAM"]}},";
                }
            ?>]};
var dailydata = { values:[<?php
                $query = "SELECT `Date`, ROUND(AVG(`Ping`), 3) as avgping, ROUND(AVG(`CPUTemp`), 3) as avgtemp, ROUND(AVG(`UsedRAM`), 3) as avgram FROM `logs` GROUP BY `Date` ORDER BY `Date` DESC LIMIT 12;";
                $result = mysql_query($query, $link) or die(mysql_error());
                while($row = mysql_fetch_array($result))
                {
                    echo "{Date:'{$row["Date"]}',AVGPing:{$row["avgping"]},AVGCPUTemp:{$row["avgtemp"]},AVGRAM:{$row["avgram"]}},";
                }
                mysql_close($link);
            ?>]};
        </script>
        <script type="text/javascript" src="canvas.js" ></script>
        <script type="text/javascript" src="tabs.js" ></script>
        <script type="text/javascript" src="cookies.js" ></script>
        <table border="1">
            <tr>
                <th>Min Ping</th>
                <th>Max Ping</th>
                <th>Avg Ping</th>
            </tr>
            <script>
                document.write("<tr>"
                    + "<td>" + pingstats.values[0].min + " ms</td>"
                    + "<td>" + pingstats.values[0].max + " ms</td>"
                    + "<td>" + pingstats.values[0].avg + " ms</td>"
                    + "</tr>");
            </script>
        </table>
        <br>
        <table border="1">
            <tr>
                <th>Min CPU</th>
                <th>Max CPU</th>
                <th>Avg CPU</th>
            </tr>
            <script>
                document.write("<tr>"
                    + "<td>" + tempstats.values[0].min + " &deg;C</td>"
                    + "<td>" + tempstats.values[0].max + " &deg;C</td>"
                    + "<td>" + tempstats.values[0].avg + " &deg;C</td>"
                    + "</tr>");
            </script>
        </table>
        <br>
        <table border="1">
            <tr>
                <th>Min RAM</th>
                <th>Max RAM</th>
                <th>Avg RAM</th>
            </tr>
            <script>
                document.write("<tr>"
                    + "<td>" + ramstats.values[0].min + " MB</td>"
                    + "<td>" + ramstats.values[0].max + " MB</td>"
                    + "<td>" + ramstats.values[0].avg + " MB</td>"
                    + "</tr>");
            </script>
        </table>
        <p>
            <script>document.write(datacount);</script> Datens&auml;tze vorhanden.
        </p>
        <br>
        <hr>
        <form action="index.php" method="get" style="float:clear;">
            <input type="date" name="date" id="date">
            <label for="am">AM</label>
            <input type="radio" name="am" id="am">
            <label for="pm">PM</label>
            <input type="radio" name="pm" id="pm">
            <input type="submit">
            <input type="reset" >
        </form>
        <br>
        <div id="left_table" style="float: left;">
            <table border="1">
                <tr>
                    <th>Date and Time</th>
                    <th>Ping to 8.8.8.8</th>
                    <th>CPU Temperature</th>
                    <th>RAM Usage</th>
                </tr>
                <script>
                    for(var i = 0; i < data.values.length; i++) 
                    {
                        document.write("<tr>"
                            + "<td>" + data.values[i].DateTime + "</td>"
                            + "<td>" + data.values[i].Ping + " ms</td>"
                            + "<td>" + data.values[i].CPUTemp + " &deg;C</td>"
                            + "<td>" + data.values[i].RAM + " MB</td>"
                            + "</tr>");
                    }
                </script>
            </table>
        </div>
        <div id="right_graph" style="margin-left:10px;float: left;">
            <div class="tab_menu">
                <button class="tab_button" onclick="openTab('Pings')">Pings</button>
                <button class="tab_button" onclick="openTab('Temps')">Temperatures</button>
                <button class="tab_button" onclick="openTab('RAM')">RAM</button>
            </div>
            
            <div id="Pings" class="tabpage">
                <script>
                if(data.values.length > 0)
                {
                    document.write("Ping RTTs between " + data.values[data.values.length - 1].DateTime + " and " + data.values[0].DateTime + "<br>");
                }
                </script>
            
                <canvas id="canvas_diagramm_ping"></canvas>
                <script>renderCanvas1();</script>
                <br>
                Average Ping RTT last <script>document.write(dailydata.values.length);</script> days<br>
                <canvas id="canvas_diagramm_avgping"></canvas>
                <script>renderCanvas3();</script>
                <br>
                Distribution of Pings<br>
                <canvas id="canvas_diagramm_varping"></canvas>
                <script>renderCanvas5();</script>
            </div>
            <div id="Temps" class="tabpage" style="display: none;">
                <script>
                    if(data.values.length > 0)
                    {
                        document.write("CPU temperatures between " + data.values[data.values.length - 1].DateTime + " and " + data.values[0].DateTime + "<br>");
                    }
                </script>
                
                <canvas id="canvas_diagramm_temp" ></canvas>
                <script>renderCanvas2();</script>
                <br>
                Average CPU Temperature last <script>document.write(dailydata.values.length);</script> days<br>
                <canvas id="canvas_diagramm_avgtemp"></canvas>
                <script>renderCanvas4();</script>
                <br>
                Distribution of Temperatures<br>
                <canvas id="canvas_diagramm_vartemp"></canvas>
                <script>renderCanvas6();</script>
            </div>
            <div id="RAM" class="tabpage" style="display: none;">
                <script>
                    if(data.values.length > 0)
                    {
                        document.write("RAM usage between " + data.values[data.values.length - 1].DateTime + " and " + data.values[0].DateTime + "<br>");
                    }
                </script>
                
                <canvas id="canvas_diagramm_ram" ></canvas>
                <script>renderCanvas7();</script>
                <br>
                Average RAM usage last <script>document.write(dailydata.values.length);</script> days<br>
                <canvas id="canvas_diagramm_avgram"></canvas>
                <script>renderCanvas8();</script>
                <br>
                Distribution of RAM usage<br>
                <canvas id="canvas_diagramm_varram"></canvas>
                <script>renderCanvas9();</script>
            </div>
        </div>
    </body>
</html>
