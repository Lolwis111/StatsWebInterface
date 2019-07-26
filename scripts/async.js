var notificationCount = 0;

function notify()
{
    if(notificationCount > 0)
    {
        document.title = "(" + notificationCount + ") Levin's DEV Server";
    }
    else
    {
        document.title = "Levin's DEV Server";
    }
}

function asyncReload()
{
    result = $.getJSON("getDataLogs.php", function(data, status, xhr)
    {
        notificationCount++;
        
        notify();
        
        console.log(status);
        
        json = result.responseJSON;
        
        $('#pingstatsTable tr').remove();
        $('#tempstatsTable tr').remove();
        $('#ramstatsTable tr').remove();
        $('#roomtempstatsTable tr').remove();
        $('#humiditystatsTable tr').remove();
        $('#medianTable tr').remove();
        $('#currentValues tr').remove();
        
        $('#roomtempstatsTable').append(
            "<tr><th>Min temp</th><th>Max temp</th><th>Avg temp</th></tr>"
        );
        
        $('#roomtempstatsTable').append(
            "<tr><td>" + json.environmenttempstats.min + "&deg;C</td><td>" 
            + json.environmenttempstats.max + "&deg;C</td><td>" 
            + json.environmenttempstats.avg + "&deg;C</td></tr>"
        );
        
        $('#humiditystatsTable').append(
            "<tr><th>Min humidity</th><th>Max humidity</th><th>Avg humidity</th></tr>"
        );
        
        $('#humiditystatsTable').append(
            "<tr><td>" + json.humiditystats.min + " %</td><td>" 
            + json.humiditystats.max + " %</td><td>" 
            + json.humiditystats.avg + " %</td></tr>"
        );
        
        
        $('#pingstatsTable').append(
            "<tr><th>Min RTT</th><th>Max RTT</th><th>Avg RTT</th></tr>"
        );
        
        $('#pingstatsTable').append(
            "<tr><td>" + json.pingstats.min + " ms</td><td>" 
            + json.pingstats.max + " ms</td><td>" 
            + json.pingstats.avg + " ms</td></tr>"
        );
            
        $('#tempstatsTable').append(
            "<tr><th>Min cpu-temp</th><th>Max cpu-temp</th><th>Avg cpu-temp</th></tr>"
        );
        
        $('#tempstatsTable').append(
            "<tr><td>" + json.cputempstats.min + "&deg;C</td><td>" 
            + json.cputempstats.max + "&deg;C</td><td>" 
            + json.cputempstats.avg + "&deg;C</td></tr>"
        );
            
        $('#ramstatsTable').append(
            "<tr><th>Min RAM</th><th>Max RAM</th><th>Avg RAM</th></tr>"
        );
        
        $('#ramstatsTable').append(
            "<tr><td>" + json.ramstats.min + " MB</td><td>" 
            + json.ramstats.max + " MB</td><td>" 
            + json.ramstats.avg + " MB</td></tr>"
        );
    
        $('#statsTable tr').remove();
        
        $('#statsTable').append(
            "<tr><th>Date  Time</th><th>Ping<sup>(1)</sup></th>"
            + "<th>CPU Temp</th><th>RAM</th></tr>"
        );
    
        for(i = 0; i < json.logsData.values.length; i++)
        {
            $('#statsTable').append(
                "<tr><td>" + json.logsData.values[i].DateTime + "</td>"
                + "<td>" + json.logsData.values[i].Ping + " ms</td>"
                + "<td>" + json.logsData.values[i].CPUTemp + " &deg;C</td>"
                + "<td>" + json.logsData.values[i].RAM + " MB</td></tr>"
            );
        }
        
        $('#medianTable').append(
            "<tr><th>Median temperture</th><th>median humidity</th></tr>"
            + "<tr><td>" + json.medianTemperatureRoom + "&deg;C</td><td>" 
            + json.medianHumidity + " %</td></tr>"
        );
        
        $('#currentValues').append(
            "<tr><th>Current temperature</th><th>Current humidity</th></th>"
            + "<tr><td>" + json.environmentData.values[0].Temperature + " &deg;C</td>"
            + "<td>" + json.environmentData.values[0].Humidity + " %</td></tr>"
        );
        
        $('.dateTimeRangeLogs').text(
            json.logsData.values[json.logsData.values.length - 1].DateTime 
            + " and " 
            + json.logsData.values[0].DateTime
        );
        
        $('.dateTimeRangeEnvironment').text(
            json.environmentData.values[json.environmentData.values.length - 1].DateTime 
            + " and " 
            + json.environmentData.values[0].DateTime
        );
        
        $('.dailyDataLengthLogs').text(json.dailyAveragesLogs.values.length);
        
        $('#datacountLogs').text(json.datacountLogs);
        $('#datacountEnvironment').text(json.datacountEnvironment);
        
        $('#uptime').text(json.uptime);
        $("#kernelVersion").text(json.kernel);
        
        var date = new Date();
        hours = date.getHours();
        minutes = date.getMinutes();
        seconds = date.getSeconds();
        
        $('#lastRefresh').text(
            (hours < 10 ? '0' + hours : hours)
            + ':'
            + (minutes < 10 ? '0' + minutes : minutes)
            + ':'
            + (seconds < 10 ? '0' + seconds : seconds)
        );
        
        initCanvas();
        
        renderCanvasPings(json);
        renderCanvasTemps(json);
        renderCanvasMemory(json);
        
        renderCanvasAvgPings(json);
        renderCanvasAvgPingsDOW(json);
        renderCanvasAvgTemps(json);
        renderCanvasAvgTempsMonth(json);
        renderCanvasAvgMemory(json);
        
        renderCanvasVarPings(json);
        renderCanvasVarTemps(json);
        renderCanvasVarMemory(json);
        
        renderCanvasRoomtemps(json);
        renderCanvasAvgRoomtemps(json);
        renderCanvasAvgRoomtempsMonth(json);
        renderCanvasVarRoomtemps(json);
        
        renderCanvasHumidity(json);
        renderCanvasAvgHumidity(json);
        renderCanvasAvgHumidityMonth(json);
        renderCanvasVarHumidity(json);
    });
}
