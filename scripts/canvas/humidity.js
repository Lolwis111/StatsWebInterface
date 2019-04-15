function renderCanvasHumidity(json)
{
    canvas = document.getElementById("canvas_diagramm_humidity");
    
    canvas.setAttribute('width', bigCanvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, bigCanvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (bigCanvasWidth - graphPadding) / json.environmentData.values.length;

    for(var i = 0; i < json.environmentData.values.length; i++)
    {
        temp = json.environmentData.values[i].Humidity;
        scaledTemp = (temp * graphMax) / 100;
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();
        
        context.fillStyle = createColor(scaledTemp);
        
        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        context.fillText(~~temp + "%", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasAvgHumidity(json)
{
    canvas = document.getElementById("canvas_diagramm_avghumidity");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / json.weeklyHumidity.values.length;

    for(var i = 0; i < json.weeklyHumidity.values.length; i++)
    {
        temp = json.weeklyHumidity.values[i].AVGHumidity;
        scaledTemp = (temp * graphMax) / 100;
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();

        context.fillStyle = createColor(scaledTemp);

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);

        context.fillStyle = graphTextcolor;
        context.fillText(~~temp + "%", graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasAvgHumidityMonth(json)
{
    canvas = document.getElementById("canvas_diagramm_avghumiditymonth");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', canvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var graphMax = 255;
    var graphPadding = 10;
    var graphFactor = (canvasHeight - (2 * graphPadding)) / graphMax;
    var graphWidth = (smallCanvasWidth - graphPadding) / json.monthlyTemp.values.length;

    for(var i = 0; i < json.monthlyTemp.values.length; i++)
    {
        temp = json.monthlyTemp.values[i].AVGHumidity;
        scaledTemp = (temp * graphMax) / 100;
        
        tmpTop = (canvasHeight - (graphFactor * scaledTemp)).toFixed() - graphPadding;
        tmpHeight = ((scaledTemp * graphFactor)).toFixed();

        context.fillStyle = createColor(scaledTemp);

        context.fillRect(graphWidth + ((i - 1) * graphWidth) + graphPadding, 
                        tmpTop, graphWidth - graphPadding, tmpHeight);
        
        context.fillStyle = graphTextcolor;
        var text = json.monthlyTemp.values[i].Month + " (" + ~~temp + "%)";
        context.fillText(text, graphWidth + ((i - 1) * graphWidth) + graphPadding + 2, canvasHeight - 2, graphWidth);
    }
}

function renderCanvasVarHumidity(json)
{
    canvas = document.getElementById("canvas_diagramm_varhumidity");
    
    canvas.setAttribute('width', smallCanvasWidth.toFixed());
    canvas.setAttribute('height', smallCanvasHeight.toFixed());
    context = canvas.getContext("2d");
    
    renderGrid(context, smallCanvasWidth);
    
    var variance = [];
    
    for(var i = 0; i < 100; i++)
    {
        variance[i] = 0;
    }
    
    for(var i = 0; i < json.environmentData.values.length; i++)
    {
        if(json.environmentData.values[i].Humidity > 100)
            variance[100]++;
        else
            variance[~~json.environmentData.values[i].Humidity]++;
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
