var canvasHeight = 320;
var smallCanvasHeight = 100;
var canvasWidth = 250;

var graphTextcolor = "#DBDBDB";
var canvasCount = -1;

function initCanvas()
{
    if($(document).width() < 1000)
    {
        canvasWidth = $(document).width() - 25;
        canvasCount = 10;
        leftTable = document.getElementById('left_table')
        leftTable.style.display = 'none';
    }
    else
    {
        canvasWidth = $(document).width() - $('#left_table').width() - 25;
        canvasCount = -1;
    }
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
    
    /* values smaller than 16 create on digit hex strings,
     * append leading 0 here */
    if(value < 16)
    {
        hex1 = "0" + hex1;
    }
    
    /* values bigger than 239 result in one digit hex strings,
     * as 255 - 239 = 16. Append leading 0 here */
    if(value > 239)
    {
        hex2 = "0" + hex2;
    }
    
    var color = "#" + hex1 + "" + hex2 + "00";
    
    /* console.log(value + ": " + color); */
    
    return color;
}
