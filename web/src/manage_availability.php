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
		$block = "<span class=\"availability_title_wrapper\"><span class=\"availability_title\">{$dayhour}</span></span>";
		
		if( ($i)%24 == 0 && $i != 0 )
		{
			$pos = floor(($i+1)/24);
			$html .= "<h3>{$value_day[$pos]}</h3>";
		}			
		
		// Depending on what each char is add a different piece of HTML
		switch( $timeString[$i] )
		{		
			case '_':
				$html .= "<span class=\"availability_inactive\">{$block}</span>";
			break;
			case '-':
				$html .= "<span class=\"availability_active\">{$block}</span>";
			break;			
		}
		
	}
	
	return $html;
}

$post = array( 'user' => $_SESSION['USER_ID'] );
$availString = PWTask( 'get_avail', $post );

?>
<div id="login_window" class="window_background center_on_page large_window drop_shadow no_wrap">
	<h1> Availability at a Glance </h1>
	<?php echo FormatTimeString( $availString ) ?>
	<form  method="POST">
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
