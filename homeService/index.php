<!DOCTYPE html>

<html>
    <head>
        <title>In Home Services</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name=viewport content="width=device-width, initial-scale=1">
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="caller.js" ></script>
        
        <div id="wrapper">
        
            <h1>Wer soll gerufen werden?</h1>

            <button id="lasse" class="caller" onclick="call('lasse');">
                Lasse
            </button>
        
            <br>
    
            <button id="levin" class="caller" onclick="call('levin');">
                Levin
            </button>
        
            <br>
        
            <button id="linus" class="caller" onclick="call('linus');">
                Linus
            </button>
        
            <br>
        
            <button id="all" class="caller" onclick="callAll();">
                Alle
            </button>
        
            <br>
        
            <span id="result"></span>
        
            <br>
            
            <a href="InHomeService.application">Download des Desktop Client</a>
            
            <br>
            
            <a href="InHomeService.zip">Download the Project [C# Visual Studio 2017 Enterprise]</a>
            
        </div>
        
    </body>
</html>

