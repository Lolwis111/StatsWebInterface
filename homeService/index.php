<!DOCTYPE html>

<html>
    
    <head>
        
        <title>In Home Services</title>
        
        <link rel="stylesheet" type="text/css" href="style.css">
        
        <meta name=viewport content="width=device-width, initial-scale=1">
        
    </head>
    
    <body onload="initButtons();">
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="caller.js" ></script>
        <?php
            include 'sql.php';
            
            $mysqli = new mysqli($sqlServer['server'], 
                $sqlServer['username'], 
                $sqlServer['password'], 
                $sqlServer['database']);
                
                
            if($mysqli->connect_errno)
            {
                echo '<span id="error">Die Verbindung zur Datenbank ist fehlgeschlagen!</span>';
            
                exit;
            }
            
            $query = "SELECT Online,LastSeenDate,LastSeenTime,MachineName FROM `users` WHERE `Name` = 'levin';";
            $result = querySql($query, $mysqli);
            $levin = $result->fetch_assoc();
            
            $query = "SELECT Online,LastSeenDate,LastSeenTime,MachineName FROM `users` WHERE `Name` = 'linus';";
            $result = querySql($query, $mysqli);
            $linus = $result->fetch_assoc();
            
            $query = "SELECT Online,LastSeenDate,LastSeenTime,MachineName FROM `users` WHERE `Name` = 'lasse';";
            $result = querySql($query, $mysqli);
            $lasse = $result->fetch_assoc();
            
            $query = "SELECT Online,LastSeenDate,LastSeenTime,MachineName FROM `users` WHERE `Name` = 'michaela';";
            $result = querySql($query, $mysqli);
            $michaela = $result->fetch_assoc();
            
            $query = "SELECT Online,LastSeenDate,LastSeenTime,MachineName FROM `users` WHERE `Name` = 'steffen';";
            $result = querySql($query, $mysqli);
            $steffen = $result->fetch_assoc();
        ?>
        
        <div id="wrapper">
        
            <table>
                <tr>
                    <th>Anfrage stellen</th>
                    <th>Status</th>
                    <th>
                        Zuletzt Online<br>
                        <span id="smalltext">YYYY-mm-dd - hh:mm:ss</span>
                    </th>
                    <th>Computer</th>
                </tr>
                <tr>
                    <td>
                        <button id="lasse" class="caller">
                            Lasse
                        </button>
                    </td>
                    <td>
                        <?php 
                            if($lasse['Online'] == 0) echo '<span class="offline">Offline</span>';
                            else echo '<span class="online">Online</span>';
                        ?>
                    </td>
                    <?php
                        if($lasse['LastSeenDate'] != null) 
                        {
                            echo "<td>" 
                                . $lasse['LastSeenDate'] 
                                . " - " 
                                . $lasse['LastSeenTime']
                                . "</td><td>"
                                . $lasse['MachineName']
                                . "</td>";
                        }
                        else
                        {
                            echo "<td>Niemals</td><td>&nbsp;</td>";
                        }
                    ?>
                </tr>
                
                <tr>
                    <td>
                        <button id="levin" class="caller">
                            Levin
                        </button>
                    </td>
                    <td>
                        <?php 
                            if($levin['Online'] == 0) echo '<span class="offline">Offline</span>';
                            else echo '<span class="online">Online</span>';
                        ?>
                    </td>
                    <?php
                        if($levin['LastSeenDate'] != null) 
                        {
                            echo "<td>" 
                                . $levin['LastSeenDate'] 
                                . " - " 
                                . $levin['LastSeenTime']
                                . "</td><td>"
                                . $levin['MachineName']
                                . "</td>";
                        }
                        else
                        {
                            echo "<td>Niemals</td><td>&nbsp;</td>";
                        }
                    ?>
                </tr>
                
                <tr>
                    <td>
                        <button id="linus" class="caller">
                            Linus
                        </button>
                    </td>
                    <td>
                        <?php 
                            if($linus['Online'] == 0) echo '<span class="offline">Offline</span>';
                            else echo '<span class="online">Online</span>';
                        ?>
                    </td>
                    <?php
                        if($linus['LastSeenDate'] != null) 
                        {
                            echo "<td>" 
                                . $linus['LastSeenDate'] 
                                . " - " 
                                . $linus['LastSeenTime']
                                . "</td><td>"
                                . $linus['MachineName']
                                . "</td>";
                        }
                        else
                        {
                            echo "<td>Niemals</td><td>&nbsp;</td>";
                        }
                    ?>
                </tr>
            
                <tr>
                    <td>
                        <button id="michaela" class="caller">
                            Michaela
                        </button>
                    </td>
                    <td>
                        <?php 
                            if($michaela['Online'] == 0) echo '<span class="offline">Offline</span>';
                            else echo '<span class="online">Online</span>';
                        ?>
                    </td>
                    <?php
                        if($michaela['LastSeenDate'] != null) 
                        {
                            echo "<td>" 
                                . $michaela['LastSeenDate'] 
                                . " - " 
                                . $michaela['LastSeenTime']
                                . "</td><td>"
                                . $michaela['MachineName']
                                . "</td>";
                        }
                        else
                        {
                            echo "<td>Niemals</td><td>&nbsp;</td>";
                        }
                    ?>
                </tr>
                
                <tr>
                    <td>
                        <button id="steffen" class="caller">
                            Linus
                        </button>
                    </td>
                    <td>
                        <?php 
                            if($steffen['Online'] == 0) echo '<span class="offline">Offline</span>';
                            else echo '<span class="online">Online</span>';
                        ?>
                    </td>
                    <?php
                        if($steffen['LastSeenDate'] != null) 
                        {
                            echo "<td>" 
                                . $steffen['LastSeenDate'] 
                                . " - " 
                                . $steffen['LastSeenTime']
                                . "</td><td>"
                                . $steffen['MachineName']
                                . "</td>";
                        }
                        else
                        {
                            echo "<td>Niemals</td><td>&nbsp;</td>";
                        }
                    ?>
                </tr>
        
                <tr>
                    <td>
                        <button id="allKids" class="caller">
                            Alle Kinder
                        </button>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>                
        
                <tr>
                    <td>
                        <button id="all" class="caller">
                            Alle
                        </button>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
        
            </table>
            <p id="info">
                Nach jedem Klick wird der entsprechende Button f&uuml;r 30 Sekunden gesperrt
                um exessives Spammen zu vermeiden.
            </p>
            
            <br>
            
            <br>
            
            <table id="downloads" border="1">
                <tr>
                    <td>Desktop Client</td>
                    <td>Windows x86/x64</td>
                    <td><a href="InHomeService.application">Download</a></td>
                </tr>
                
                <tr>
                    <td>Sourcecode</td>
                    <td>C# Projekt Visual Studio 2017 Enterprise</td>
                    <td><a href="InHomeService.zip">Download</a></td>
                </tr>
            </table>
            
        </div> <!-- end wrapper -->
        
    </body>
    
</html>

