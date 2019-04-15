function asyncReload()
{
    result = $.getJSON("getDataLogs.php", function(data, status, xhr)
    {
        console.log(status);
        
        json = result.responseJSON;
        
        $('#pingstatsTable tr').remove();
        $('#tempstatsTable tr').remove();
        $('#ramstatsTable tr').remove();
        
        $('#pingstatsTable').append(
            "<tr><th>Min Ping</th><th>Max Ping</th><th>Avg Ping</th></tr>"
        );
        
        $('#pingstatsTable').append(
            "<tr><td>" + json.pingstats.min + " ms</td><td>" 
            + json.pingstats.max + " ms</td><td>" 
            + json.pingstats.avg + " ms</td></tr>"
        );
            
        $('#tempstatsTable').append(
            "<tr><th>Min Temp</th><th>Max Temp</th><th>Avg Temp</th></tr>"
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
        
        $('.dateTimeRangeLogs').text(
            json.logsData.values[json.logsData.values.length - 1].DateTime 
            + " and " 
            + json.logsData.values[0].DateTime
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
