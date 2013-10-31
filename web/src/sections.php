<?php
//	sections.php: Will take in an array of course ids and list all assoc. sections to add classes
// 10-30-2013
// Arthur Wuterich

// Will generate a row for course section selection
function BuildCourseRow( $course )
{
	// Exit conditions
	if( !is_array( $course ) )
	{
		return '';
	}
	
	// Generate the instance drop downs
	$instanceHtml = '<select class="section_instance_dropdown" name="section_instance[]">';
	$post = array( 'course_id' => $course[0] );
	$instances = json_decode( PWTask( 'grab_instances', $post ) );
	$last_instance_id = -1;
	
	// Add all of the instances to the selection list
	foreach( $instances->instances as $instance )
	{
		// Only close off options when the section_instance_id is different
		if( $last_instance_id != $instance->course_instance_id )
		{
			if( $last_instance_id != -1 )
			{
				$instanceHtml .= '</option>';
			}
			
			$instanceHtml .= "<option value={$instance->course_instance_id}>{$instance->section_id}: ";
			$last_instance_id = $instance->course_instance_id;
		}
		
		// Add day and time to select option
		$instanceHtml .= "{$instance->day} {$instance->start_time}-{$instance->end_time} ";
	}
	
	// Close off the last option and the last select	
	$instanceHtml .= '</option></select>';
	
	// Return the course row
	return
	"
	<div class=\"course_row\">
		<div class=\"row_header\">
		{$course[1]} {$course[2]}
		</div>
		{$instanceHtml}
	</div>
	";
}

$sectionHtml = '';
$servicedCourses = array();

// For each course passed to this file generate a list of sections to select from
foreach( $_POST['class'] as $course )
{
	// Break data from csv
	$courseData = explode( ',', $course );
	
	// Only display a courses once
	if( !in_array( $courseData[0], $servicedCourses ) )
	{
		$servicedCourses[] = $courseData[0];
	}
	else
	{
		continue;
	}

	$sectionHtml .= BuildCourseRow( $courseData );
}
?>

<script type="text/javascript">
</script>

<div id="course_form" class="window_background center_on_page large_window drop_shadow search_sections" >
<div class="search_classes_left_align" >
	<h1> Select Sections </h1>
		<form  method="POST" >
			<?php echo $sectionHtml; ?>
</div>			
			<BR />
			<button type="submit" name="goto" value="search_classes.php">Back</button>
			<button type="submit" name="goto" value="add_courses.php">Add Courses</button>
		</form>
</div>