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
    
    for(var index = 0; index < tabPages.length; index++)
    {
        tabPages[index].style.display = "none";
    }
    
    document.getElementById(tab).style.display = "block";
    
    setCookie("tabpage", tab, 7);
}