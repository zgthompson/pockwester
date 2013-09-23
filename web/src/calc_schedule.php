<?php
//	calc_schedule.php: Will take multiple class times and compute a schedule
//						Precondition: Post variable ['class1', 'class2', ..., 'class{n}'] is defined
// 9-18-2013
// Arthur Wuterich

// Dirty reflection! *** REFACTOR ***
$post_val = 1;

$schedule = array();
$group_names = array();
$timeString = MakeTimeString();

// If the post variable this is set to this page 
// and a timestring is defined then add this user to course groups
if( $_POST['this'] == 'calc_schedule.php' && isset( $_POST['timestring']) )
{
	// Add user to each group
	while( isset($_POST["group{$post_val}"] ) )
	{
		$value = $_POST["group{$post_val}"];
		$post = array( 'user' => $_SESSION['USER_ID'], 'group_name' => $value );
		PWTask( 'add_to_group', $post );
		$post_val++;
	}
	
	// Add the avail restrictions of the classes
	$post = array( 'user' => $_SESSION['USER_ID'], 'time_string' => $_POST['timestring'] );
	PWTask( 'set_avail', $post );
	
	$updatedClasses = true;
	$_SESSION['CURRENT_PAGE'] = DEFAULT_CONTENT;
}

while( isset($_POST["class{$post_val}"]) )
{
	// Get all of the class information from the previous page
	$value = explode(',', $_POST["class{$post_val}"]);
	
	// Don't try to add the same group more than once
	if( in_array( $value[0], $group_names ) )
	{
		$post_val++;
		continue;
	}
	
	$group_names[] = $value[0];
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

// Generate timestring
foreach( $schedule as $timeBlock )
{
	for( $i = $timeBlock[0]; $i < $timeBlock[1]; $i++ )
	{
		AlterTimeString( $timeString, floor($i/24), $i%24, '_' );
	}
}

if( $updatedClasses ){
?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_NORMAL; ?> );
</script>
<div id="schedule_accept_classes" class="window_background center_on_page small_window drop_shadow" >
<h1> You have joined the class groups and your avail has been altered </h1>
	<form  method="POST" >
		<button type="submit" name="goto" value="home.php">Home</button>
		<button type="submit" name="goto" value="search_classes.php">Search for More Classes</button>
	</form>
</div>
<?php exit(0); }?>
<div id="schedule_accept_classes" class="window_background center_on_page large_window drop_shadow" >
<div class="calc_schedule_left_align">
<h1> Confirm Schedule Restrictions and Courses </h1>
<h2> These are the group(s) you will join: </h2>
<?php foreach( $group_names as $groupName ){ echo "<group_name>{$groupName}<BR/></group_name>";} ?>
<BR/>	
<h2> Based on the class times you will be unavailable at these times: </h2>
	<form  method="POST" >
		<?php echo FormatSchedule( $schedule )?>
		<input type="hidden" name="timestring" value="<?php echo $timeString; ?>">
		<?php $i = 1; foreach( $group_names as $groupName ){ echo "<input type=\"hidden\" name=\"group{$i}\" value=\"{$groupName}\">"; $i++; } ?>
</div>
		<button type="submit" name="goto" value="search_classes.php">Back</button>
		<button type="submit" name="this" value="calc_schedule.php">Join Class Groups and Alter Availibility</button>
		<button type="submit" name="this" value="calc_schedule.php">Join Class Groups</button>
	</form>
</div>