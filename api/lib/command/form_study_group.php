<?php
//	form_study_group.php: Will set the lfg flag for a student in a paticular course
//		$instance_id: The id of the instance
// ZT & AW
// 11-12-2013

DB_Connect();

$instance_id = Get( 'instance_id' );

// Get a time where each student is available for the study group
$time = DB_GetSingleArray( DB_Query("
		SELECT 
			time_code 
		FROM 
			student_time_code AS a, student_course_instance AS b 
		WHERE 
			a.student_id = b.student_id AND 
			b.course_instance_id = {$instance_id} AND 
			looking_for_group='y' 
		GROUP BY 
			time_code 
		HAVING COUNT(*) > 2
		") );
		
if( count( $time ) <= 0 )
{
	return "There were not enough students to form a study group";
}
$time = $time[0];

// Get the student Id's for the time period
$student_ids = DB_GetSingleArray( DB_Query( "
		SELECT 
			a.student_id 
		FROM 
			student_time_code AS a, student_course_instance AS b 
		WHERE 
			a.student_id = b.student_id AND 
			b.looking_for_group = 'y' AND 
			b.course_instance_id = {$instance_id} AND
			a.time_code = {$time}" ) );

if( count( $student_ids ) <= 0 )
{
	return "There was a problem getting all of the student ID's";
}

$now = time();

// This will calculate the next meeting time epoc. 60^2*24*4 is an offset for unix epoc starting on a thursday
$meeting_time = ( ( floor ( $now / 604800 ) ) * 604800 ) + ( 60 * 60 * 24 * 4 ) + ( ( ( $time + 8 ) % 168 ) * 60 * 60 );

// Create the study group
	DB_Query( "
				INSERT INTO 
					study_group
				(time_code, course_instance_id, created_at, meeting_time)
				VALUES
				({$time}, {$instance_id}, {$now}, {$meeting_time}  )
				");

// Get the newly formed group's id
$study_group_id = DB_GetSingleArray( DB_Query("SELECT id from study_group where time_code={$time} and course_instance_id={$instance_id} LIMIT 1" ) );
$study_group_id = $study_group_id[0];

// Create an entry for each student as being part of the group
foreach( $student_ids as $student_id )
{
	DB_Query( "
			INSERT INTO student_study_group
			(student_id,study_group_id)
			VALUES
			({$student_id},{$study_group_id})
			" );
			
	// Unset LFG Flag
	$post = array( 'instance_id' => $instance_id, 'student_id' => $student_id, 'flag' => 0 );
	print_r( $post );
	PWTask( 'set_lfg_flag', $post);
	
	// Update availability 			
}

return '1';

















?>
