function renderCanvasMemory(json)
{
    canvas = document.getElementById("canvas_diagramm_ram");
    
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
        ram = json.logsData.values[i].RAM;
        scaledRam = (ram * graphMax) / 1024;
        tmpTop = (canvasHeight - (graphFactor * scaledRam)).toFixed() - graphPadding;
        tmpHeight = ((scaledRam * graphFactor)).toFixed();
        
        if(scaledRam > graphMax)
        {
            context.fillStyle = "#FF0000";
        }
        else 
        {
            context.fillStyle = createColor(scaledRam);
        }
        
        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~ram + "MB", 
                        graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, 
                        canvasHeight - 2, graphWidth);
    }
}

function renderCanvasVarMemory(json)
{
    canvas = document.getElementById("canvas_diagramm_varram");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', smallCanvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var variance = [];
    
    for(var i = 0; i < 1024; i++)
    {
        variance[i] = 0;
    }
    
    for(var i = 0; i < json.logsData.values.length; i++)
    {
        if(json.logsData.values[i].RAM > 1024)
            variance[1024]++;
        else
            variance[~~json.logsData.values[i].RAM]++;
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

function renderCanvasAvgMemory(json)
{
    canvas = document.getElementById("canvas_diagramm_avgram");

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
        ram = json.dailyAveragesLogs.values[i].AVGRAM;
        scaledRam = (ram * graphMax) / 1024;
        tmpTop = (canvasHeight - (graphFactor * scaledRam)).toFixed() - graphPadding;
        tmpHeight = ((scaledRam * graphFactor)).toFixed();

        if(scaledRam > graphMax)
        {
            context.fillStyle = "#FF0000";
        }
        else 
        {
            context.fillStyle = createColor(scaledRam);
        }

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);

        context.fillStyle = graphTextcolor;
        context.fillText(~~ram + "MB", 
            graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, 
            canvasHeight - 2, graphWidth);
    }
}
