function renderCanvasTemps(json)
{
    canvas = document.getElementById("canvas_diagramm_temp_cpu");
    
    canvas.setAttribute('width', canvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, canvasWidth);
    
    var w = json.logsData.values.length;
    if(canvasCount > -1)
    {
        w = canvasCount;
    }
    
    var graphMax = 100;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (canvasWidth - graphPadding) / w;

    for(var i = 0; i < w; i++)
    {
        temp = json.logsData.values[i].CPUTemp;
        scaledTemp = (temp * graphMax) / 100;
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();
        
        context.fillStyle = createColor(scaledTemp);
        
        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~temp + " C", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasAvgTemps(json)
{
    canvas = document.getElementById("canvas_diagramm_avgtemp_cpu");
    
    canvas.setAttribute('width', canvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, canvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (canvasWidth - graphPadding) / json.dailyAveragesLogs.values.length;

    for(var i = 0; i < json.dailyAveragesLogs.values.length; i++)
    {
        temp = json.dailyAveragesLogs.values[i].AVGCPUTemp;
        scaledTemp = (temp * graphMax) / 100;
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();

        context.fillStyle = createColor(scaledTemp);

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);

        context.fillStyle = graphTextcolor;
        context.fillText(~~temp + "C", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasAvgTempsMonth(json)
{
    canvas = document.getElementById("canvas_diagramm_avgtempmonth_cpu");
    
    canvas.setAttribute('width', canvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, canvasWidth);
    
    var graphMax = 100;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (canvasWidth - graphPadding) / json.monthlyCPUTemp.values.length;

    for(var i = 0; i < json.monthlyCPUTemp.values.length; i++)
    {
        temp = json.monthlyCPUTemp.values[i].AVGTemp;
        scaledTemp = (temp * graphMax) / 100;
        
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();

        context.fillStyle = createColor(scaledTemp);

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        var text = json.monthlyCPUTemp.values[i].Month + " (" + ~~temp + "C)";
        context.fillText(text, graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasVarTemps(json)
{
    canvas = document.getElementById("canvas_diagramm_vartemp_cpu");
    
    canvas.setAttribute('width', canvasWidth.toFixed());
    canvas.setAttribute('height', smallCanvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, canvasWidth);
    
    var variance = [];
    
    for(var i = 0; i < 100; i++)
    {
        variance[i] = 0;
    }
    
    for(var i = 0; i < json.logsData.values.length; i++)
    {
        if(json.logsData.values[i].CPUTemp > 100)
            variance[100]++;
        else
            variance[~~json.logsData.values[i].CPUTemp]++;
    }
    
    var graphMax = 100;
    var graphPadding = 10;
    var graphFactor = (smallCanvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (canvasWidth - graphPadding) / variance.length;

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
