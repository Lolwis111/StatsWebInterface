function initTabs()
{
    var cookie = getCookie("tabpage");
    
    if(cookie == "")
    {
        openTab('Pings');
    }
    else
    {
        openTab(cookie);
    }
}

function openTab(tab)
{
    var tabPages = document.getElementsByClassName("tabpage");
    var tabButtons = document.getElementsByClassName("tab_button");
    
    for(var index = 0; index < tabPages.length; index++)
    {
        tabPages[index].style.display = "none";
    }
    
    for(var index = 0; index < tabButtons.length; index++)
    {
        tabButtons[index].style.color = "black";
        tabButtons[index].style.backgroundColor = "white";
        tabButtons[index].style.border = "1px solid black";
    }
    
    document.getElementById(tab).style.display = "block";
    
    var button = document.getElementById("Btn" + tab);
    
    button.style.color = "white";
    button.style.backgroundColor = "black";
    button.style.border = "1px solid white;";
    
    setCookie("tabpage", tab, 7);
}