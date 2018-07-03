<!DOCTYPE html>

<html>
    <head>
        <title>Levins DEV Server</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body onload="initTabs();asyncReload();">
        <script type="text/javascript" src="canvas.js" ></script>
        <script type="text/javascript" src="tabs.js" ></script>
        <script type="text/javascript" src="cookies.js" ></script>
        <script type="text/javascript" src="async.js" ></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
                    last refresh: <span id="lastRefresh"></span>
                </p>
            </div>
        </div>
        <hr>
        <button id="reload_button" onclick="asyncReload()">Refresh</button>
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
                    Ping RTTs between <span class="dateTimeRange"></span><br>
                    <canvas id="canvas_diagramm_ping"></canvas>
                    <br>
                    Average Ping RTT last <span class="dailyDataLength"></span> days<br>
                    <canvas id="canvas_diagramm_avgping"></canvas>
                    <br>
                    Distribution of Pings<br>
                    <canvas id="canvas_diagramm_varping"></canvas>
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
