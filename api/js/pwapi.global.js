function onBlur(el) {
    if (el.value == '') {
        el.value = el.defaultValue;
    }
}
function CheckForComp(el)
{
	var boxNumber = parseInt( el.name.slice(1) )
	
	if( $('[name="p' + boxNumber + '"]').val() != $('[name="p' + boxNumber + '"]').prop("defaultValue") &&
		$('[name="v' + boxNumber + '"]').val() != $('[name="v' + boxNumber + '"]').prop("defaultValue") && 
		$('[name="p' + boxNumber + '"]').attr('onkeyup') != ''												&&
		$('[name="v' + boxNumber + '"]').attr('onkeyup') != ''												  )
	{
		$('[name="p' + boxNumber + '"]').attr('onkeyup', '');
		$('[name="v' + boxNumber + '"]').attr('onkeyup', '');
		AddField();
	}
}
function onFocus(el) {
    if (el.value == el.defaultValue) {
        el.value = '';
    }
}

var nextField = 2;
function AddField()
{

	//<input class="post_name" onblur="onBlur(this)" onfocus="onFocus(this)" name="p1" type="text" value="post_name">onchange="CheckForComp();"
	$('<input>').attr({
		class: 'post_name',
		onblur: 'onBlur(this)',
		onfocus: 'onFocus(this)',
		onkeyup: 'CheckForComp(this)',
		name: 'p'+(nextField),
		value: 'post_name',
		type: 'text'
	}).insertBefore('#add');
	
	// <input class="post_value" onblur="onBlur(this)" onfocus="onFocus(this)" name="v1" type="text" value="post_value">
	$('<input>').attr({
		class: 'post_value',
		onblur: 'onBlur(this)',
		onfocus: 'onFocus(this)',
		onkeyup: 'CheckForComp(this)',
		name: 'v'+(nextField++),
		value: 'post_value',
		type: 'text'
	}).insertBefore('#add');
}

function SetPostFields()
{
	var post_name = new Array();
	var post_value = new Array();
		
	$(".post_name").each( function(index){
	
		if($(this).val() == $(this).prop("defaultValue"))
		{
			post_name.push( null );
			$(this).attr('name', '');
			return;
		}
		
		post_name.push( $(this).val() );
		$(this).attr('name', '');
	});
	
	$(".post_value").each( function(index){
	
		if($(this).val() == $(this).prop("defaultValue"))
		{
			post_value.push( null );
			$(this).attr('name', '');
			return;
		}
		
		post_value.push( $(this).val() );
		$(this).attr('name', '');
	});
	
	for( var i=0; i<post_name.length; i++ )
	{
		if( post_name[i] == null || post_value[i] == null )
		{
			continue;
		}
			$('<input>').attr({
				type: 'hidden',
				id: post_name[i],
				name: post_name[i],
				value: post_value[i]
			}).appendTo('#main_form');		
	}

	return true;
}
















