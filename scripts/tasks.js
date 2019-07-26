
function initPage()
{
    document.getElementById('vacuum_box').style.display = 'none';
    document.getElementById('dishwasher_box').style.display = 'none';
    document.getElementById('flowers_box').style.display = 'none';
    document.getElementById('users').style.display = 'none';
    
    console.log("init page");
}

function vacuum()
{
    $("#dishwasher_box").hide();
    $("#flowers_box").hide();
    $("#users").hide();
    
    $("#vacuum_box").show();
    
    console.log("vacuum");
}

function dishwasher()
{
    $("#vacuum_box").hide();
    $("#flowers_box").hide();
    $("#users").hide();
    
    $("#dishwasher_box").show();
    
    console.log("dishwasher");
}

function flowers()
{
    $("#vacuum_box").hide();
    $("#dishwasher_box").hide();
    $("#users").hide();
    
    $("#flowers_box").show();
    
    console.log("flowers");
}


function vacuum_upstairs()
{
    $("#users").show();
}

function vacuum_stairs()
{
    $("#users").show();
}
    
function vacuum_downstairs()
{
    $("#users").show();
}

function vacuum_basement()
{
    $("#users").show();
}

function vacuum_all()
{
    $("#users").show();
}


function dishwasher_out()
{
    $("#users").show();
}

function dishwasher_in()
{
    $("#users").show();
}


function flowers_inside()
{
    $("#users").show();
}

function flowers_outside()
{
    $("#users").show();
}

function flowers_all()
{
    $("#users").show();
}


function select_user(args)
{
    alert(args);
}
