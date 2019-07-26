<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Levins DEV Server</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body onload="initTabs();asyncReload();" onresize="asyncReload();" onmouseover="notificationCount = 0; notify();">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="scripts/canvas/base.js" ></script>
        <script type="text/javascript" src="scripts/canvas/ram.js" ></script>
        <script type="text/javascript" src="scripts/canvas/tempCPU.js" ></script>
        <script type="text/javascript" src="scripts/canvas/ping.js" ></script>
        <script type="text/javascript" src="scripts/canvas/tempEnvironment.js" ></script>
        <script type="text/javascript" src="scripts/canvas/humidity.js" ></script>
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
            
            <div class="floater" id="infotables2">
                <table class="minmaxTable" id="roomtempstatsTable" border="1"></table>
                <table class="minmaxTable" id="humiditystatsTable" border="1"></table>
                <table class="minmaxTable" id="medianTable" border="1"></table> 
                <table class="minmaxTable" id="currentValues" border="1"></table>
            </div>
            
            <div class="floater" id="infotext">
                <p>
                    <span id="datacountLogs"></span> entries available in table logs.<br>
                    <span id="datacountEnvironment"></span> entries available in table environment.<br>
                    Uptime: <span id="uptime"></span><br>
                    This site uses one cookie to remember which tab<br>
                    page you used on your last visit.<br>
                    last refresh: <span id="lastRefresh"></span><br>
                    Kernel: <span id="kernelVersion"></span><br>
                </p>
            </div>
            
            <div class="floater">
                <button id="phpmyadmin_button" class="navbutton" onclick="phpMyAdmin();">
                    PHPMyAdmin
                </button>
                <br>
                <button id="reload_button" class="navbutton" onclick="asyncReload();">
                    Refresh
                </button>
                <br>
                <button id="homeservice_button" class="navbutton" onclick="homeService();">
                    Home Service
                </button>
                <br>
                <button id="tasks_button" class="navbutton" onclick="tasks();">
                    Tasks
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
                    <button class="tab_button" id="BtnSetup" onclick="openTab('Setup')">The setup</button>
                    <button class="tab_button" id="BtnPings" onclick="openTab('Pings')">Ping RTTs</button>
                    <button class="tab_button" id="BtnTempsCPU" onclick="openTab('TempsCPU')">Temperatures (CPU)</button>
                    <button class="tab_button" id="BtnRAM" onclick="openTab('RAM')">RAM</button>
                    <button class="tab_button" id="BtnTempsRoom" onclick="openTab('TempsRoom')">Temperatures (room)</button>
                    <button class="tab_button" id="BtnHumidity" onclick="openTab('Humidity')">Humidity</button>
                    <button class="tab_button" id="BtnToggleTable" onclick="toggleTable()">Toggle table</button>
                </div>
                
                <div id="Setup" class="tabpage">
                    <h1>The Setup</h1>
                    <img src="setup.jpg" width="1000px" alt="the setup" id="setupImage">
                </div>
                
                <div id="Pings" class="tabpage">
                    Ping<sup>(1)</sup> RTTs between <span class="dateTimeRangeLogs"></span><br>
                    <canvas id="canvas_diagramm_ping"></canvas>
                    <br>
                    Average Ping RTT last <span class="dailyDataLengthLogs"></span> days<br>
                    <canvas id="canvas_diagramm_avgping"></canvas>
                    <br>
                    Distribution of Pings<br>
                    <canvas id="canvas_diagramm_varping"></canvas>
                    <br>
                    Average Ping RTT on day weeks<br>
                    <canvas id="canvas_diagramm_avgpingdow"></canvas>
                    <br>
                    <sup>(1)</sup>Average RTT of ICMP Ping to 8.8.8.8 (Google DNS)
                </div>
                
                <div id="TempsCPU" class="tabpage" style="display: none;">
                    CPU temperatures between <span class="dateTimeRangeLogs"></span><br>
                    <canvas id="canvas_diagramm_temp_cpu" ></canvas>
                    <br>
                    Average CPU Temperature last <span class="dailyDataLengthLogs"></span> days<br>
                    <canvas id="canvas_diagramm_avgtemp_cpu"></canvas>
                    <br>
                    Distribution of Temperatures<br>
                    <canvas id="canvas_diagramm_vartemp_cpu"></canvas>
                    <br>
                    Average CPU Temperature by month<br>
                    <canvas id="canvas_diagramm_avgtempmonth_cpu"></canvas>
                </div>
                
                <div id="RAM" class="tabpage" style="display: none;">
                    RAM usage between <span class="dateTimeRangeLogs"></span><br>
                    <canvas id="canvas_diagramm_ram" ></canvas>
                    <br>
                    Average RAM usage last <span class="dailyDataLengthLogs"></span> days<br>
                    <canvas id="canvas_diagramm_avgram"></canvas>
                    <br>
                    Distribution of RAM usage<br>
                    <canvas id="canvas_diagramm_varram"></canvas>
                </div>
                
                <div id="TempsRoom" class="tabpage" style="display: none;">
                    Room temperatures between <span class="dateTimeRangeEnvironment"></span><br>
                    <canvas id="canvas_diagramm_temp_room" ></canvas>
                    <br>
                    Average room Temperature last <span class="dailyDataLengthEnvironment"></span> days<br>
                    <canvas id="canvas_diagramm_avgtemp_room"></canvas>
                    <br>
                    Distribution of Temperatures<br>
                    <canvas id="canvas_diagramm_vartemp_room"></canvas>
                    <br>
                    Average room Temperature by month<br>
                    <canvas id="canvas_diagramm_avgtempmonth_room"></canvas>
                </div>
                
                <div id="Humidity" class="tabpage" style="display: none;">
                    Humidity between <span class="dateTimeRangeEnvironment"></span><br>
                    <canvas id="canvas_diagramm_humidity" ></canvas>
                    <br>
                    Average humidity last <span class="dailyDataLengthEnvironment"></span> days<br>
                    <canvas id="canvas_diagramm_avghumidity"></canvas>
                    <br>
                    Distribution of humidities<br>
                    <canvas id="canvas_diagramm_varhumidity"></canvas>
                    <br>
                    Average humidity by month<br>
                    <canvas id="canvas_diagramm_avghumiditymonth"></canvas>
                </div>
            </div>
        </div>
    </body>
</html>
