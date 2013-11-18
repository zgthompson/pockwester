<?php
// manage_availability.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

// Takes in a timestring and formats a block of html that will represent it
function FormatTimeString( $timeString )
{
	$timeStringLength = strlen( $timeString );
	$value_day = GetValueDayArray();
	
	$html = "";
	
	for( $day = 0; $day < 7; $day++ )
	{
		$html .= "<h3>{$value_day[$day]}</h3>";

		for( $hour = 0; $hour < 16; $hour++ )
		{
			$timeValue = ($day*24)+$hour;
			$dayHour = GetDayHourString( ( $timeValue + 8 ) % 168 );
			$block = "<span class=\"availability_title_wrapper\" time_id=\"{$timeValue}\"><span class=\"availability_title\">{$dayHour}</span></span>";

			// Depending on what each char is add a different piece of HTML
			switch( $timeString[$timeValue] )
			{		
				case '0':
					$html .= "<span class=\"availability_inactive timeblock\">{$block}</span>";
				break;
				case '1':
					$html .= "<span class=\"availability_empty timeblock\">{$block}</span>";
				break;			
				case '2':
					$html .= "<span class=\"availability_active timeblock\">{$block}</span>";
				break;				
			}



		}
	}

	return $html;
}

if( isset($_POST['this']) && $_POST['this'] == 'manage_availability_alter' )
{
	$availString = $_POST['timestring'];
	$post = array( 'student_id' => $_SESSION['USER_ID'], 'avail_string' => $_POST['timestring'] );
	PWTask( 'update_availability', $post );
}
else
{
	$post = array( 'student_id' => $_SESSION['USER_ID'] );
	$availString = PWTask( 'grab_availability', $post );
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
	
	// On click handler for changing availability
	$( ".availability_title_wrapper" ).click( function() {
		
		// The new character to place into the timestring
		c = '1';
		time_value = parseInt($(this).attr('time_id'));		
		
		// Get the object with correct time value
		child = $("[time_id="+time_value+"]");
		obj = child.parent(".timeblock");
		
		// Switch to the next class
		if( obj.hasClass( "availability_empty" ) )
		{
			obj.toggleClass( 'availability_empty').toggleClass( 'availability_active');
			c = '2';
		}
		else if( obj.hasClass( "availability_active" ) )
		{
			obj.toggleClass( 'availability_active').toggleClass( 'availability_inactive');
			c = '0';
		}
		else
		{
			obj.toggleClass( 'availability_inactive').toggleClass( 'availability_empty');
			c = '1';
		}
		
		// Set the value in the time-string
		time_string = $("#timestring").val().toString();
		time_string = time_string.substring(0, time_value) + c + time_string.substring(time_value+1);
		$("#timestring").val( time_string );			
	});
	
	$( ".availability_title_wrapper" ).on('mouseenter', function() {
	
		if( !isDown )
		{
			return;
		}

		
		// The new character to place into the timestring
		c = '1';
		time_value = parseInt($(this).attr('time_id'));		
		
		// Get the object with correct time value
		child = $("[time_id="+time_value+"]");
		obj = child.parent(".timeblock");
		
		// Switch to the next class
		if( obj.hasClass( "availability_empty" ) )
		{
			obj.toggleClass( 'availability_empty').toggleClass( 'availability_active');
			c = '2';
		}
		else if( obj.hasClass( "availability_active" ) )
		{
			obj.toggleClass( 'availability_active').toggleClass( 'availability_inactive');
			c = '0';
		}
		else
		{
			obj.toggleClass( 'availability_inactive').toggleClass( 'availability_empty');
			c = '1';
		}
		
		// Set the value in the time-string
		time_string = $("#timestring").val().toString();
		time_string = time_string.substring(0, time_value) + c + time_string.substring(time_value+1);
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
		<button type="submit" onclick="Back( this );">Back</button>
	</form>
</div>
