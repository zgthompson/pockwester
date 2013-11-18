<?php
// classes.php: Shows the classes of a student
// 10-30-13
// Arthur Wuterich

// Builds a class block
function CreateClassBlock( $class, $classes )
{
	
	// Generate the class block
	return "
	<div class=\"class_block\">
		<div class=\"header\">
		{$class->subject} {$class->catalog_no}: {$class->title}
		</div>
		<div class=\"times\">
			{$class->time}
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
	$post = array(	'student_id'	=>	$_SESSION['USER_ID'],
					'instance_id'	=>	$_POST['classes_remove'],
					'action'		=>	'remove'					  );
	PWTask( 'update_student_courses', $post );
}

// Get the student's classes
$post = array( 'student_id' => $_SESSION['USER_ID'] );
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
		<button type="submit" onclick="GotoPage( this, 'search_classes/' );">Add Classes</button>
		<button type="submit" onclick="Back( this );">Back</button>
	</form>
</div>
