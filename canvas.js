var canvasHeight = 370;
var smallCanvasHeight = 100;
var bigCanvasWidth = 1400;
var smallCanvasWidth = bigCanvasWidth;

function renderGrid(context, width)
{
    var graphGridSize = 20;
    var graphGridX = (width / graphGridSize);

    for(var i = 0; i < graphGridX; i++)
    {
        context.moveTo(width, graphGridSize * i);
        context.lineTo(0, graphGridSize * i);
    }

    context.strokeStyle = "#DBDBDB";
    context.stroke();
}

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
    var graphWidth = (bigCanvasWidth - graphPadding) / json.data.values.length;
    var graphTextcolor = "#000000";

    for(var i = 0; i < json.data.values.length; i++)
    {
        ping = json.data.values[i].Ping;
        tmpTop = (canvasHeight - (graphFactor * ping)).toFixed() - graphPadding;
        tmpHeight = ((ping * graphFactor)).toFixed();

        if(ping > 255)
        {
            // red
            context.fillStyle = "#FF0000";
        }
        else 
        {
            // the value goes from the 0-255, where 0 is represented as green and 255 as red
            // the formula makes a smooth color transition, depending on the value
            context.fillStyle = "#" + (~~ping).toString(16) + (255 - (~~ping)).toString(16) + "00";
        }

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding + 2, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~ping + "ms", graphWidth + ((i - 1) * graphWidth) + graphPadding, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasTemps(json)
{
    canvas = document.getElementById("canvas_diagramm_temp");
    
    canvas.setAttribute('width', bigCanvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, bigCanvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (bigCanvasWidth - graphPadding) / json.data.values.length;
    var graphTextcolor = "#000000";

    for(var i = 0; i < json.data.values.length; i++)
    {
        temp = json.data.values[i].CPUTemp;
        scaledTemp = (temp * graphMax) / 100;
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();
        
        if(scaledTemp > 255)
        {
            // red
            context.fillStyle = "#FF0000";
        }
        else 
        {
            // the value goes from the 0-255, where 0 is represented as green and 255 as red
            // the formula makes a smooth color transition, depending on the value
            context.fillStyle = "#" + (~~scaledTemp).toString(16) + (255 - (~~scaledTemp)).toString(16) + "00";
        }
        
        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~temp + "C", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

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
    var graphWidth = (bigCanvasWidth - graphPadding) / json.data.values.length;
    var graphTextcolor = "#000000";

    for(var i = 0; i < json.data.values.length; i++)
    {
        ram = json.data.values[i].RAM;
        scaledRam = (ram * graphMax) / 1024;
        tmpTop = (canvasHeight - (graphFactor * scaledRam)).toFixed() - graphPadding;
        tmpHeight = ((scaledRam * graphFactor)).toFixed();
        
        if(scaledRam > graphMax)
        {
            // red
            context.fillStyle = "#FF0000";
        }
        else 
        {
            // the value goes from the 0-255, where 0 is represented as green and 255 as red
            // the formula makes a smooth color transition, depending on the value
            context.fillStyle = "#" + (~~scaledRam).toString(16) + (255 - (~~scaledRam)).toString(16) + "00";
        }
        
        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~ram + "MB", 
                        graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, 
                        canvasHeight - 2, graphWidth);
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
    var graphWidth = (smallCanvasWidth - graphPadding) / json.dailydata.values.length;
    var graphTextcolor = "#000000";

    for(var i = 0; i < json.dailydata.values.length; i++)
    {
        ping = json.dailydata.values[i].AVGPing;
        tmpTop = (canvasHeight - (graphFactor * ping)).toFixed() - graphPadding;
        tmpHeight = ((ping * graphFactor)).toFixed();

        if(ping > 255)
        {
            // red
            context.fillStyle = "#FF0000";
        }
        else 
        {
            // the value goes from the 0-255, where 0 is represented as green and 255 as red
            // the formula makes a smooth color transition, depending on the value
            context.fillStyle = "#" + (~~ping).toString(16) + (255 - (~~ping)).toString(16) + "00";
        }

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~ping + "ms", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasAvgTemps(json)
{
    canvas = document.getElementById("canvas_diagramm_avgtemp");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / json.dailydata.values.length;
    var graphTextcolor = "#000000";

    for(var i = 0; i < json.dailydata.values.length; i++)
    {
        temp = json.dailydata.values[i].AVGCPUTemp;
        scaledTemp = (temp * graphMax) / 100;
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();

        if(scaledTemp > 255)
        {
            // red
            context.fillStyle = "#FF0000";
        }
        else 
        {
            // the value goes from the 0-255, where 0 is represented as green and 255 as red
            // the formula makes a smooth color transition, depending on the value
            context.fillStyle = "#" + (~~scaledTemp).toString(16) + (255 - (~~scaledTemp)).toString(16) + "00";
        }

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);

        context.fillStyle = graphTextcolor;
        context.fillText(~~temp + "C", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
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
    
    for(var i = 0; i < json.data.values.length; i++)
    {
        if(json.data.values[i].Ping > 255)
            variance[255]++;
        else
            variance[~~(json.data.values[i].Ping)]++;
    }
    
    var graphMax = 100;
    var graphPadding = 10;
    var graphFactor = (smallCanvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / variance.length;
    var graphTextcolor = "#000000";

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
    
    for(var i = 0; i < json.data.values.length; i++)
    {
        if(json.data.values[i].RAM > 1024)
            variance[1024]++;
        else
            variance[~~json.data.values[i].RAM]++;
    }
    
    var graphMax = 100;
    var graphPadding = 10;
    var graphFactor = (smallCanvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / variance.length;
    var graphTextcolor = "#000000";

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

function renderCanvasVarTemps(json)
{
    canvas = document.getElementById("canvas_diagramm_vartemp");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', smallCanvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var variance = [];
    
    for(var i = 0; i < 100; i++)
    {
        variance[i] = 0;
    }
    
    for(var i = 0; i < json.data.values.length; i++)
    {
        if(json.data.values[i].CPUTemp > 100)
            variance[100]++;
        else
            variance[~~json.data.values[i].CPUTemp]++;
    }
    
    var graphMax = 100;
    var graphPadding = 10;
    var graphFactor = (smallCanvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / variance.length;
    var graphTextcolor = "#000000";

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
    var graphWidth = (smallCanvasWidth - graphPadding) / json.dailydata.values.length;
    var graphTextcolor = "#000000";

    for(var i = 0; i < json.dailydata.values.length; i++)
    {
        ram = json.dailydata.values[i].AVGRAM;
        scaledRam = (ram * graphMax) / 1024;
        tmpTop = (canvasHeight - (graphFactor * scaledRam)).toFixed() - graphPadding;
        tmpHeight = ((scaledRam * graphFactor)).toFixed();

        if(scaledRam > graphMax)
        {
            // red
            context.fillStyle = "#FF0000";
        }
        else 
        {
            // the value goes from the 0-255, where 0 is represented as green and 255 as red
            // the formula makes a smooth color transition, depending on the value
            context.fillStyle = "#" + (~~scaledRam).toString(16) + (255 - (~~scaledRam)).toString(16) + "00";
        }

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);

        context.fillStyle = graphTextcolor;
        context.fillText(~~ram + "MB", 
            graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, 
            canvasHeight - 2, graphWidth);
    }
}