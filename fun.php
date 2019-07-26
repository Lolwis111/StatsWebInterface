<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Levins DEV Server</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body onload="getAFact();">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="scripts/facts.js" ></script>
                
        <div class="floater">
            <button id="phpmyadmin_button" class="navbutton" onclick="phpMyAdmin();">
                PHPMyAdmin
            </button>
            <br>
            <button id="fact_button" class="navbutton" onclick="getAFact();">
                Get a fact
            </button>
            <br>
            <button id="stats_button" class="navbutton" onclick="stats();">
                Stats Server
            </button>
        </div>
    
        <hr>
        
        <br>
        
        <div id="body">
           
           <div id="fact"></div> 
           
        </div>
    </body>
</html>
