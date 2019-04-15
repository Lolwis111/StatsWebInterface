function initButtons()
{
    $('#levin').on('click', function() {
        
        $('#levin').prop("disabled", true);
        $('#levin').text("Levin (gesperrt)");
        
        call('levin');
        
        window.setTimeout(function() { 
            $('#levin').prop("disabled", false); 
            $('#levin').text("Levin"); 
        } , 30000);
        
    });
    
    $('#lasse').on('click', function() {
        
        $('#lasse').prop("disabled", true);
        $('#lasse').text("Lasse (gesperrt)");
        
        call('lasse');
        
        window.setTimeout(function() { 
            $('#lasse').prop("disabled", false); 
            $('#lasse').text("Lasse"); 
        } , 30000);
    });
    
    $('#linus').on('click', function() {
        
        $('#linus').prop("disabled", true);
        $('#linus').text("Linus (gesperrt)");
        
        call('linus');
        
        window.setTimeout(function() { 
            $('#linus').prop("disabled", false); 
            $('#linus').text("Linus");
        } , 30000);
    });
    
    $('#michaela').on('click', function() {
        
        $('#michaela').prop("disabled", true);
        $('#michaela').text("Michaela (gesperrt)");
        
        call('michaela');
        
        window.setTimeout(function() { 
            $('#michaela').prop("disabled", false); 
            $('#michaela').text("Michaela");
        } , 30000);
        
    });
    
    $('#steffen').on('click', function() {
        
        $('#steffen').prop("disabled", true);
        $('#steffen').text("Steffen (gesperrt)");
        
        call('steffen');
        
        window.setTimeout(function() { 
            $('#steffen').prop("disabled", false); 
            $('#steffen').text("Steffen");
        }, 30000);
    });
    
    $('#all').on('click', function() {
        
        $('#all').prop("disabled", true);
        $('#all').text("Alle (gesperrt)");
        
        $('#levin').prop("disabled", true);
        $('#levin').text("Levin (gesperrt)");
        $('#linus').prop("disabled", true);
        $('#linus').text("Linus (gesperrt)");
        $('#lasse').prop("disabled", true);
        $('#lasse').text("Lasse (gesperrt)");
        
        $('#michaela').prop("disabled", true);
        $('#michaela').text("Michaela (gesperrt)");
        $('#steffen').prop("disabled", true);
        $('#steffen').text("Steffen (gesperrt)");
        
        call('levin');
        call('linus');
        call('lasse');
        call('michaela');
        call('steffen');
        
        window.setTimeout(function() { 
            $('#all').prop("disabled",false); 
            $('#all').text("Alle");
            
            $('#levin').prop("disabled", false);
            $('#levin').text("Levin");
            $('#linus').prop("disabled", false);
            $('#linus').text("Linus");
            $('#lasse').prop("disabled", false);
            $('#lasse').text("Lasse");
            
            $('#michaela').prop("disabled", false);
            $('#michaela').text("Michaela");
            $('#steffen').prop("disabled", false);
            $('#steffen').text("Steffen");
            
        }, 30000);
    });
    
    $('#allKids').on('click', function() {
        
        $('#allKids').prop("disabled", true);
        $('#allKids').text("Alle Kinder (gesperrt)");
        
        $('#levin').prop("disabled", true);
        $('#levin').text("Levin (gesperrt)");
        $('#linus').prop("disabled", true);
        $('#linus').text("Linus (gesperrt)");
        $('#lasse').prop("disabled", true);
        $('#lasse').text("Lasse (gesperrt)");
        
        call('levin');
        call('linus');
        call('lasse');
        
        window.setTimeout(function() { 
            
            $('#allKids').prop("disabled", false); 
            $('#allKids').text("Alle Kinder");
            
            $('#levin').prop("disabled", false);
            $('#levin').text("Levin");
            $('#linus').prop("disabled", false);
            $('#linus').text("Linus");
            $('#lasse').prop("disabled", false);
            $('#lasse').text("Lasse");
            
        }, 30000);
    });
}

function call(who)
{
    var url = "caller.php?name=" + who;
    console.log(url);
    
    result = $.getJSON(url, function(data, status, xhr) {
        alert(who + " wurde informiert.");
    });
}
