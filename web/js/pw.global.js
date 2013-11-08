// Will assume that PAGE_ROOT is defined before using any of these function

// Will bounce the current page after time secondsOB
function BouncePage( time, page )
{

	if( page == undefined )
	{
		page = '/';
	}

	setTimeout( "location.href = '"+ PAGE_ROOT + page + "'", time*1000);
}


// Fade effect for transitions
$(document).ready(function() {
});

// Will change the action of the current form to provided location
function GotoPage( obj, page )
{
	if( page.charAt(0) == '/' )
	{
		obj.form.action=PAGE_ROOT+page;
	}
	else
	{
		obj.form.action=window.location.pathname+page;
	}
}

// Will go back a page
function Back( obj, levels )
{

	if( levels == undefined )
	{
		levels = 1;
	}

	var url = window.location.href;
	if (url.substr(-1) == '/') url = url.substr(0, url.length - 2);
	url = url.split('/');
	for( var i=0; i<levels; i++ )
	{
		url.pop();
	}
	
	obj.form.action = url.join('/') + '/';	
}
