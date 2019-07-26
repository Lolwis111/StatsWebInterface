var currentTab;

function initTabs()
{
    var cookie = getCookie("tabpage");
    
    if(cookie == "")
    {
        openTab('Setup');
    }
    else
    {
        openTab(cookie);
    }

}

function toggleTable()
{
    $("#statsTable").toggle();
}

function openTab(tab)
{
    currentTab = tab;
    var tabPages = document.getElementsByClassName("tabpage");
    var tabButtons = document.getElementsByClassName("tab_button");
    
    for(var index = 0; index < tabPages.length; index++)
    {
        tabPages[index].style.display = "none";
    }
    
    for(var index = 0; index < tabButtons.length; index++)
    {
        tabButtons[index].style.color = "#202020";
        tabButtons[index].style.backgroundColor = "#CCCCCC";
        tabButtons[index].style.border = "1px solid #CCCCCC";
    }
    
    document.getElementById(tab).style.display = "block";
    
    var button = document.getElementById("Btn" + tab);
    
    button.style.color = "#CCCCCC";
    button.style.backgroundColor = "#202020";
    button.style.border = "1px solid #202020;";
    
    setCookie("tabpage", tab, 7);
}

function phpMyAdmin()
{
    window.location.href = "http://192.168.178.56/phpmyadmin/";
}

function homeService()
{
    window.location.href = "http://192.168.178.56/homeService/";
}

function tasks()
{
    window.location.href = "http://192.168.178.56/tasks.php";
}
