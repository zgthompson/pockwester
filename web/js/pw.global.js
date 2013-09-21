// Will bounce the current page after time secondsOB
function BouncePage( time )
{
	setTimeout( "location.href = 'index.php'", time*1000);
}

$(document).ready(function() {
    $("body").css("display", "none");
 
    $("body").fadeIn(250);
          
});