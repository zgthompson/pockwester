<?php
//	calc_schedule.php: Will take multiple class times and compute a schedule
//						Precondition: Post variable ['class1', 'class2', ..., 'class{n}'] is defined
// 9-18-2013
// Arthur Wuterich

// Dirty reflection! *** REFACTOR ***
$post_val = 1;

$schedule = array();

while( isset($_POST["class{$post_val}"]) )
{
	$value = explode(',', $_POST["class{$post_val}"]);
	$value = $value[1];
	$schedule_array = GetTimeValue($value);
	
	// Take each pair of values and place them into their own array
	while( count($schedule_array) > 0 )
	{
		$schedule[] = array( array_shift($schedule_array), array_shift($schedule_array) );
	}
	$post_val++; 
}

// Sort the schedule array based on the start times
usort($schedule, function($a, $b)
{
	return $a[0] > $b[0];
});

?>
<div id="schedule_accept_classes" class="rounded_window center_on_page large_window drop_shadow" >
<h1> Confirm Schedule Restrictions and Courses </h1>
<h2> So, based on your courses, your busy at these hours: </h2>
	<form action="index.php" method="POST" >
		<?php echo FormatSchedule( $schedule )?>
		<button type="submit" name="goto" value="home.php">Back Home</button>
		<button type="submit" name="goto" value="search_classes.php">Change Classes</button>
	</form>
</div>