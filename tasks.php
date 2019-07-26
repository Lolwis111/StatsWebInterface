<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Levins DEV Server</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="style2.css">
    </head>
    <body onload="initPage();">
        <script src="scripts/tasks.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            function asyncReload()
            {
                result_tasks = $.getJSON("getTasks.php", function(data, status, xhr)
                {
                    console.log(status);
                    
                    json_tasks = result_tasks.responseJSON;
                    
                    
                    $('#tasks_table tr').remove();
                
                    $('#tasks_table').append("<tr><th>ID</th><th>Name</th><th>Beschreibung</th><th>Startdatum</th><th>Enddatum</th><th>Status</th></tr>");
                
                    for(i = 0; i < json_tasks.tasks.values.length; i++)
                    {
                        $('#tasks_table').append(
                            "<tr><td>" + json_tasks.tasks.values[i].ID + "</td>"
                            + "<td>" + json_tasks.tasks.values[i].Name + "</td>"
                            + "<td>" + json_tasks.tasks.values[i].Description + "</td>"
                            + "<td>" + json_tasks.tasks.values[i].StartDate + "</td>"
                            + "<td>" + json_tasks.tasks.values[i].EndDate + "</td>"
                            + "<td>" + json_tasks.tasks.values[i].Status + "</td></tr>"
                        );
                    }
            
                });
            }
            
            function testSend()
            {
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "test.php",
                    data: { "string1":"Hallo Welt" },
                    success: function(data){
                        alert('Items added');
                    },
                    error: function(e){
                        console.log(e.message);
                    }
                });
            }
        </script>
        
        <div class="menu">
            <h1>Men&uuml;</h1>
            <button id="phpmyadmin_button" class="navbutton" onclick="">
                PHPMyAdmin
            </button>
            <br>
            <button id="reload_button" class="navbutton" onclick="">
                Refresh
            </button>
            <br>
            <button id="homeservice_button" class="navbutton" onclick="">
                Home Service
            </button>
        </div>
        
        <div class="content">
            <div class="floater" style="width: 50%; min-height: 100px;">
                <h1>Aufgaben</h1>
                <button id="reload_button" class="navbutton" onclick="asyncReload();">
                    Reload
                </button>
                <table id="tasks_table" border="1">
                </table>
                
            </div>
            
            <div class="floater" style="width: 50%; min-height: 100px;">
                <h1>Neue Aufgabe erstellen</h1>
                <button id="vacuum_button" class="navbutton_small" onclick="vacuum();">Saugen</button>
                <button id="dishwasher_button" class="navbutton_small" onclick="dishwasher();">Sp&uuml;ler</button>
                <button id="flowers_button" class="navbutton_small" onclick="flowers();">Blumen gie&szlig;en</button>
                
                <div id="vacuum_box">
                    <h1>Saugen</h1>
                    <button id="vacuum_button1" class="navbutton_small" onclick="vacuum_upstairs();">Oben</button>
                    <button id="vacuum_button2" class="navbutton_small" onclick="vacuum_stairs();">Treppe</button>
                    <button id="vacuum_button3" class="navbutton_small" onclick="vacuum_downstairs();">Unten</button>
                    <button id="vacuum_button4" class="navbutton_small" onclick="vacuum_basement();">Keller</button>
                    <button id="vacuum_button5" class="navbutton_small" onclick="vacuum_all();">Alles</button>
                </div>
                <div id="dishwasher_box">
                    <h1>Geschirr</h1>
                    <button id="dishwasher_button1" class="navbutton_small" onclick="dishwasher_out();;">Ausr&auml;umen</button>
                    <button id="dishwasher_button2" class="navbutton_small" onclick="dishwasher_in();">Einr&auml;umen</button>
                </div>
                <div id="flowers_box">
                    <h1>Blumen</h1>
                    <button id="flowers_button1" class="navbutton_small" onclick="flowers_outside();">Drau&szlig;en</button>
                    <button id="flowers_button2" class="navbutton_small" onclick="flowers_inside();">Drinnen</button>
                    <button id="flowers_button2" class="navbutton_small" onclick="flowers_all();">Alle</button>
                </div>
                <br>
                <div id="users">
                    <h1>Zuweisen</h1>
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
            
                        $result = querySql("SELECT * FROM `users`", $mysqli);
            
                        while ($row = mysqli_fetch_array($result))
                        {
                            $firstName = $row['FirstName'];
                            $id = $row['ID'];
                            echo '<button id="user_button' 
                                 . $id 
                                 . '" class="navbutton_small" onclick="select_user(\'' 
                                 . $firstName 
                                 . '\');">' 
                                 . $firstName 
                                 . '</button>
                            ';
                            
                        }
                        
                        $result->free();
                        
                        $mysqli->close();
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>
