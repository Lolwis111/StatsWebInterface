function asyncReload()
{
    result = $.getJSON("getData.php", function(data, status, xhr)
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
            "<tr><td>" + json.tempstats.min + "&deg;C</td><td>" 
            + json.tempstats.max + "&deg;C</td><td>" 
            + json.tempstats.avg + "&deg;C</td></tr>"
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
    
        for(i = 0; i < json.data.values.length; i++)
        {
            $('#statsTable').append(
                "<tr><td>" + json.data.values[i].DateTime + "</td>"
                + "<td>" + json.data.values[i].Ping + " ms</td>"
                + "<td>" + json.data.values[i].CPUTemp + " &deg;C</td>"
                + "<td>" + json.data.values[i].RAM + " MB</td></tr>"
            );
        }
        
        /* $('#weekdayPings tr').remove();
        
        $('#weekdayPings').append(
            "<tr><th>Day of week</th><th>Min Ping</th>"
            + "<th>Max Ping</th><th>Avg Ping</th></tr>"
        );
    
        for(i = 0; i < json.weekdaydata.values.length; i++)
        {
            $('#weekdayPings').append(
                "<tr><td>" + json.weekdaydata.values[i].WeekDay + "</td>"
                + "<td>" + json.weekdaydata.values[i].MinPing + " ms</td>"
                + "<td>" + json.weekdaydata.values[i].MaxPing + " ms</td>"
                + "<td>" + json.weekdaydata.values[i].AVGPing + " ms</td></tr>"
            );
        }*/
        
        $('.dateTimeRange').text(
            json.data.values[json.data.values.length - 1].DateTime 
            + " and " 
            + json.data.values[0].DateTime
        );
        
        $('.dailyDataLength').text(json.dailydata.values.length);
        
        $('#datacount').text(json.datacount);
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
        renderCanvasAvgMemory(json);
        
        renderCanvasVarPings(json);
        renderCanvasVarTemps(json);
        renderCanvasVarMemory(json);
    });
}
