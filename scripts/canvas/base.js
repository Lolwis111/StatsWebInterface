var canvasHeight = 320;
var smallCanvasHeight = 100;
var bigCanvasWidth = 250;
var smallCanvasWidth = bigCanvasWidth;

var graphTextcolor = "#DBDBDB";

function initCanvas()
{
    bigCanvasWidth = $(document).width() - $('#left_table').width() - 25;
    smallCanvasWidth = bigCanvasWidth;
}

/**
 * This function renders the horizontal lines onto the canvas
 * to make the diagramms appear more diagrammy
 **/
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

/**
 * This function takes a value and creates an RGB-Color
 * ranging from green to red, where 0 is a solid green
 * and 255 a solid red. Values get clamped.
 **/
function createColor(value)
{
    if(value > 255)
    {
        value = 255;
    }
    else if(value < 0)
    {
        value = 0;
    }
    
    hex1 = (~~value).toString(16);
    hex2 = (255 - (~~value)).toString(16);
    
    var color = "#" + hex1 + "" + hex2 + "00";
    
    console.log(value + ": " + color);
    
    return color;
}
