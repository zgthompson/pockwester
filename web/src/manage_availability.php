<?php
// manage_availability.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

// Takes in a timestring and formats a block of html that will represent it
function FormatTimeString( $timeString )
{
	$timeStringLength = strlen( $timeString );
	$value_day = GetValueDayArray();
	
	$html = "<h3>{$value_day[0]}</h3>";
	// Iterate over the entire string
	for( $i = 0; $i < $timeStringLength; $i++ )
	{
	
		$dayhour = GetDayHourString( $i );
		$block = "<span class=\"availability_title_wrapper\" time_id=\"{$i}\"><span class=\"availability_title\">{$dayhour}</span></span>";
		
		if( ($i)%24 == 0 && $i != 0 )
		{
			$pos = floor(($i+1)/24);
			$html .= "<h3>{$value_day[$pos]}</h3>";
		}			
		
		// Depending on what each char is add a different piece of HTML
		switch( $timeString[$i] )
		{		
			case '_':
				$html .= "<span class=\"availability_inactive\" time_id=\"{$i}\">{$block}</span>";
			break;
			case '-':
				$html .= "<span class=\"availability_active\" time_id=\"{$i}\">{$block}</span>";
			break;			
		}
		
	}
	
	return $html;
}

if( isset($_POST['this']) && $_POST['this'] == 'manage_availability_alter' )
{
	$availString = $_POST['timestring'];
	$post = array( 'user' => $_SESSION['USER_ID'], 'time_string' => $_POST['timestring'] );
	PWTask( 'set_avail', $post );
}
else
{
	$post = array( 'user' => $_SESSION['USER_ID'] );
	$availString = PWTask( 'get_avail', $post );
}

?>
<script type="text/javascript">
$( document ).ready(function() {
	var isDown = false;	
	$(document).mousedown(function(){
		isDown = true;
	});

	$(document).mouseup(function(){
		isDown = false;
	});

	$( ".availability_title_wrapper" ).click( function() {

		time_value = parseInt($(this).attr('time_id'));
		newChar = '-';
		
		obj = $(".availability_inactive[time_id="+time_value+"]");
		
		if( obj.size() <= 0 )
		{
			obj = $(".availability_active[time_id="+time_value+"]")
			newChar = '_';
		}
		
		obj.toggleClass( 'availability_inactive').toggleClass( 'availability_active');
		
		time_string = $("#timestring").val().toString();
		time_string = time_string.substring(0, time_value) + newChar + time_string.substring(time_value+1);
		$("#timestring").val( time_string );
		
	});

	$( ".availability_title_wrapper" ).on('mouseenter', function() {
		if( !isDown )
		{
			return;
		}

		time_value = parseInt($(this).attr('time_id'));
		newChar = '-';
		
		obj = $(".availability_inactive[time_id="+time_value+"]");
		
		if( obj.size() <= 0 )
		{
			obj = $(".availability_active[time_id="+time_value+"]")
			newChar = '_';
		}
		
		obj.toggleClass( 'availability_inactive').toggleClass( 'availability_active');
		
		time_string = $("#timestring").val().toString();
		time_string = time_string.substring(0, time_value) + newChar + time_string.substring(time_value+1);
		$("#timestring").val( time_string );
		
	});


});
</script>
<div id="login_window" class="window_background center_on_page large_window drop_shadow no_wrap manage_availability">
	<h1> Availability at a Glance </h1>
	<?php echo FormatTimeString( $availString ) ?>
	<form  method="POST">
		<input type="hidden" id="timestring" name="timestring" value="<?php echo$availString; ?>" >
		<button type="submit" name="this" value="manage_availability_alter">Alter</button>
		<button type="submit" name="goto" value="back">Back</button>
	</form>
</div>
