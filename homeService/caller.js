function callAll()
{
    call('levin');
    call('linus');
    call('lasse');
}

function call(who)
{
    var url = "caller.php?name=" + who;
    
    console.log(url);
    
    result = $.getJSON(url, function(data, status, xhr) {
        alert(who + " wurde informiert.");
    });
}
