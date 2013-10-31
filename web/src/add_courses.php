<?php
//	add_courses.php: Will add the provided courses to the current students account
// 10-30-2013
// Arthur Wuterich

// Add each instance_id to the user
foreach( $_POST['section_instance'] as $instance_id )
{
	$post = array(	'student_id'	=>	$_SESSION['USER_ID_BETA'],
					'instance_id'	=>	$instance_id,
					'action'		=>	'add'					  );
	PWTask( 'update_student_courses', $post );
}
?>

<script type="text/javascript">
</script>

<div id="course_form" class="window_background center_on_page large_window drop_shadow search_sections" >
<div class="search_classes_left_align" >
	<h1> Courses Added </h1>
		<form  method="POST" >
</div>			
			<BR />
			<button type="submit" name="goto" value="classes.php">Back To Classes</button>
		</form>
</div>