<?php
// classes.php: Shows the classes of a student
// 10-30-13
// Arthur Wuterich

// Builds a class block
function CreateClassBlock( $class, $classes )
{
	// Create the time html
	$timeHtml = '';
	foreach( $classes as $class_time )
	{
		// We only care about sections with the matching ID
		if( $class->section_id == $class_time->section_id )
		{
			$timeHtml .= "{$class_time->day} {$class_time->start_time} - {$class_time->end_time}<BR/>";
		}
	}
	
	// Generate the class block
	return "
	<div class=\"class_block\">
		<div class=\"header\">
		{$class->subject} {$class->catalog_no}: {$class->title}
		</div>
		<div class=\"times\">
			{$timeHtml}
		</div>
		{$class->location}
		<form method=\"POST\">
			<button name=\"classes_remove\" value=\"{$class->course_instance_id}\">Remove</button>
		</form>
	</div>
	";	
}

// Leave classes if requested
if( isset( $_POST['classes_remove'] ) && is_numeric( $_POST['classes_remove'] ) )
{
	$post = array(	'student_id'	=>	$_SESSION['USER_ID_BETA'],
					'instance_id'	=>	$_POST['classes_remove'],
					'action'		=>	'remove'					  );
	echo PWTask( 'update_student_courses', $post );
}

// Get the student's classes
$post = array( 'student_id' => $_SESSION['USER_ID_BETA'] );
$classes = json_decode( PWTask( 'grab_instances', $post ) );

$servicedInstances = array();
$classHtml = '';
foreach( $classes->instances as $class )
{
	// Only display a course_instance once
	if( !in_array( $class->course_instance_id, $servicedInstances ) )
	{
		$servicedInstances[] = $class->course_instance_id;
	}
	else
	{
		continue;
	}
	
	$classHtml .= CreateClassBlock( $class, $classes->instances );
}

?>
<div id="classes" class="window_background center_on_page small_window drop_shadow classes">
	<h1> Current Classes </h1>
	<?php echo $classHtml; ?>
	<form  method="POST">
		<button type="submit" name="goto" value="search_classes.php">Add Classes</button>
		<button type="submit" name="goto" value="back">Back</button>
	</form>
</div>
