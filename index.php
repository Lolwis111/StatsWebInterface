<!DOCTYPE html>

<html>
    <head>
        <title>Levins DEV Server</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body onload="initTabs();asyncReload();">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="scripts/canvas.js" ></script>
        <script type="text/javascript" src="scripts/tabs.js" ></script>
        <script type="text/javascript" src="scripts/cookies.js" ></script>
        <script type="text/javascript" src="scripts/async.js" ></script>
        
        <!-- refresh every 5 minutes via ajax -->
        <script>window.setInterval(asyncReload, 5 * 60 * 1000);</script>
        
        <div id="header">
            
            <div class="floater" id="infotables">
                <table class="minmaxTable" id="pingstatsTable" border="1"></table>
                <table class="minmaxTable" id="tempstatsTable" border="1"></table>
                <table class="minmaxTable" id="ramstatsTable" border="1"></table>
            </div>
            
            <div class="floater" id="infotext">
                <p>
                    <span id="datacount"></span> entries available.<br>
                    Uptime: <span id="uptime"></span><br>
                    This site uses one cookie to remember which tab page you
                    used on your last visit.<br>
                    last refresh: <span id="lastRefresh"></span><br>
                    Kernel: <span id="kernelVersion"></span>
                </p>
            </div>
            
            <div class="floater">
                <button id="phpmyadmin_button" class="navbutton" onclick="phpMyAdmin();">
                    PHPMyAdmin
                </button>
                <br>
                <button id="reload_button" class="navbutton" onclick="asyncReload()'">
                    Refresh
                </button>
                <br>
                <button id="homeservice_button" class="navbutton" onclick="homeService();">
                    Home Service
                </button>
            </div>
            
        </div>
        
        <hr>
        
        <br>
        
        <div id="body">
            
            <div id="left_table" class="floater">
                <table id="statsTable" border="1"></table>
            </div>
            
            <div id="right_graph" class="floater">
                
                <div class="tab_menu">
                    <button class="tab_button" id="BtnPings" onclick="openTab('Pings')">Pings</button>
                    <button class="tab_button" id="BtnTemps" onclick="openTab('Temps')">Temperatures</button>
                    <button class="tab_button" id="BtnRAM" onclick="openTab('RAM')">RAM</button>
                </div>
                
                <div id="Pings" class="tabpage">
                    Ping<sup>(1)</sup> RTTs between <span class="dateTimeRange"></span><br>
                    <canvas id="canvas_diagramm_ping"></canvas>
                    <br>
                    Average Ping RTT last <span class="dailyDataLength"></span> days<br>
                    <canvas id="canvas_diagramm_avgping"></canvas>
                    <br>
                    Distribution of Pings<br>
                    <canvas id="canvas_diagramm_varping"></canvas>
                    <br>
                    Average Ping RTT on day weeks<br>
                    <canvas id="canvas_diagramm_avgpingdow"></canvas>
                    <br>
                    <sup>(1)</sup>Average RTT of ICMP Ping to 8.8.8.8 (Google DNS)
                    <br>
                </div>
                
                <div id="Temps" class="tabpage" style="display: none;">
                    CPU temperatures between <span class="dateTimeRange"></span><br>
                    <canvas id="canvas_diagramm_temp" ></canvas>
                    <br>
                    Average CPU Temperature last <span class="dailyDataLength"></span> days<br>
                    <canvas id="canvas_diagramm_avgtemp"></canvas>
                    <br>
                    Distribution of Temperatures<br>
                    <canvas id="canvas_diagramm_vartemp"></canvas>
                    <br>
                    Average CPU Temperature by month<br>
                    <canvas id="canvas_diagramm_avgtempmonth"></canvas>
                </div>
                
                <div id="RAM" class="tabpage" style="display: none;">
                    RAM usage between <span class="dateTimeRange"></span><br>
                    <canvas id="canvas_diagramm_ram" ></canvas>
                    <br>
                    Average RAM usage last <span class="dailyDataLength"></span> days<br>
                    <canvas id="canvas_diagramm_avgram"></canvas>
                    <br>
                    Distribution of RAM usage<br>
                    <canvas id="canvas_diagramm_varram"></canvas>
                </div>
            </div>
        </div>
    </body>
</html>
