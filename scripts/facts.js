function getAFact()
{
    result = $.getJSON("getFact.php", function(data, status, xhr)
    {
        $("#fact").text(result.responseJSON.fact);
    }
}
