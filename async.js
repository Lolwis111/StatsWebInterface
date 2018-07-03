function asyncReload()
{
    result = $.getJSON("getData.php", function(data, status, xhr)
    {
        console.log(status);
        
        json = result.responseJSON;
        
        renderCanvas1(json);
        renderCanvas2(json);
        renderCanvas3(json);
        renderCanvas4(json);
        renderCanvas5(json);
        renderCanvas6(json);
        renderCanvas7(json);
        renderCanvas8(json);
        renderCanvas9(json);
        
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
            "<tr><th>Date and Time</th><th>Ping to 8.8.8.8</th>"
            + "<th>CPU Temperature</th><th>RAM Usage</th></tr>"
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
        
        $('.dateTimeRange').text(
            json.data.values[json.data.values.length - 1].DateTime 
            + " and " 
            + json.data.values[0].DateTime
        );
        
        $('.dailyDataLength').text(json.dailydata.values.length);
        
        $('#datacount').text(json.datacount);
        $('#uptime').text(json.uptime);
        
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
    });
}