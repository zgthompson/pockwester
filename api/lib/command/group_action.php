<?php
//	group_action.php: Will perform an action on a student in a study group
//	$student_id: The id of the student to operate on
//	$group_id: The id of the grout the student is in
//	$action: The action to perform

DB_Connect();

$student_id = Get( 'student_id' );
$group_id = Get( 'group_id' );
$action = strtolower( Get( 'action' ) );

switch( $action )
{
	// Remove the student from the study group
	case "leave":
		DB_Query( "DELETE FROM student_study_group WHERE student_id = {$student_id} AND study_group_id = {$group_id}" );
		return '1';
	break;
	
	// Add the student to the study group
	case "join":
		DB_Query( "INSERT INTO student_study_group 
		(student_id, study_group_id) 
		VALUES
		({$student_id}, {$group_id})" );
		return '1';
	break;
}
?>