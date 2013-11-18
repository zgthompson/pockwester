<?php
//	grab_study_groups.php: Will return a list of study groups
//		[$instance_id]: Will filter the results based on a specific 
//		[$student_id]: Will filter the results based on a specific student id.
// ZT & AW
// 11-12-2013

DB_Connect();

$student_id = Get( 'student_id', false );
$instance_id = Get( 'instance_id', false );

// Require that one of the variables is set
if( !isset( $student_id ) && !isset( $instance_id ) )
{
	return 'student_id or instance_id needs to be defined';
}

$where = '';

if( isset( $student_id ) )
{
	WhereAdd( $where, "id in ( select study_group_id from student_study_group where student_id = {$student_id} )" );
	$groups = DB_GetArray( DB_Query( "SELECT * FROM study_group {$where} " ) );
}

if( isset( $instance_id ) )
{
	WhereAdd( $where, "course_instance_id = {$instance_id}" );
	$groups = DB_GetArray( DB_Query( "SELECT * FROM study_group {$where} " ) );
}

if( count($groups[0]) <= 0 )
{
	return OutputFormatting( array( 'study_groups' => $groups ) );
}

$result_array = array();

foreach( $groups as $group )
{
	// Get the name of the study group
	$courseData = DB_GetArray( DB_Query( "SELECT title, subject, catalog_no from course as a, course_instance as b where a.id = b.course_id and b.id = {$group[2]}" ));

	// Modified because of small offset(timezone?)
	$modifiedMeetingEpoc = $group[4]+25200;
	$modifiedMeetingTime = date( "D hA", $modifiedMeetingEpoc );
	$result_array[] = array(
		'id' => $group[0],
		'title' => $courseData[0][0],
		'subject_no' => "{$courseData[0][1]} {$courseData[0][2]}",
		'time' => $modifiedMeetingTime, 
		'date' => date( "n-d gA", $modifiedMeetingEpoc )
	);
}

return OutputFormatting( array( 'study_groups' => $result_array ));















?>
