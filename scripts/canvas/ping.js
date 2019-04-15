function renderCanvasPings(json)
{
    canvas = document.getElementById("canvas_diagramm_ping");
    
    canvas.setAttribute('width', bigCanvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, bigCanvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (bigCanvasWidth - graphPadding) / json.logsData.values.length;

    for(var i = 0; i < json.logsData.values.length; i++)
    {
        ping = json.logsData.values[i].Ping;
        tmpTop = (canvasHeight - (graphFactor * ping)).toFixed() - graphPadding;
        tmpHeight = ((ping * graphFactor)).toFixed();

        context.fillStyle = createColor(ping);
        

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding + 2, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~ping + "ms", graphWidth + ((i - 1) * graphWidth) + graphPadding, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasAvgPings(json)
{
    canvas = document.getElementById("canvas_diagramm_avgping");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / json.dailyAveragesLogs.values.length;

    for(var i = 0; i < json.dailyAveragesLogs.values.length; i++)
    {
        ping = json.dailyAveragesLogs.values[i].AVGPing;
        tmpTop = (canvasHeight - (graphFactor * ping)).toFixed() - graphPadding;
        tmpHeight = ((ping * graphFactor)).toFixed();

        context.fillStyle = createColor(ping);

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~ping + "ms", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasAvgPingsDOW(json)
{
    var height = canvasHeight;
    canvas = document.getElementById("canvas_diagramm_avgpingdow");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', height.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var maxPing = 0;
    for(var i = 0; i < 7; i++)
    {
        var ping = json.weeklyPing.values[i].AVGPing;
        if(ping > maxPing)
        {
            maxPing = ping;
        }
    }
    
    // var graphMax = 255;
    var graphMax = maxPing + 10;
    var graphPadding = 10;
    var graphFactor = (height - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / 7;

    for(var i = 0; i < 7; i++)
    {
        ping = json.weeklyPing.values[i].AVGPing;
        tmpTop = (height - (graphFactor * ping)).toFixed() - graphPadding;
        tmpHeight = ((ping * graphFactor)).toFixed();

        context.fillStyle = createColor(ping);

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        var text = json.weeklyPing.values[i].WeekDay + " (" + ~~ping + "ms)";
        context.fillText(text, graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, height - 2, graphWidth);
    }
}

function renderCanvasVarPings(json)
{
    canvas = document.getElementById("canvas_diagramm_varping");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', smallCanvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var variance = [];
    
    for(var i = 0; i < 256; i++)
    {
        variance[i] = 0;
    }
    
    for(var i = 0; i < json.logsData.values.length; i++)
    {
        if(json.logsData.values[i].Ping > 255)
            variance[255]++;
        else
            variance[~~(json.logsData.values[i].Ping)]++;
    }
    
    var graphMax = 100;
    var graphPadding = 10;
    var graphFactor = (smallCanvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / variance.length;

    for(var i = 0; i < variance.length; i++)
    {
        val = variance[i];
        scaledVal = (val / variance.length) * graphMax;
        
        tmpTop = (smallCanvasHeight - (graphFactor * scaledVal)).toFixed() - graphPadding;
        tmpHeight = ((scaledVal * graphFactor)).toFixed();

        context.fillStyle = "#FF6600";

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
    }
}
