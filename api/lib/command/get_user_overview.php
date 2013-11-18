<?php
//	get_user_overview.php: Will return an array with the three most current study groups, The users next three classes, and the current day's availability
//	$user_id: ID number to reference against
//	11-6-13
//	Arthur Wuterich

DB_Connect();

$user_id = Get( 'user_id' );

$user_data = array();

// Get study group info
$post = array( 'student_id' => $user_id );
$user_data['groups'] = PWTask( 'grab_study_groups', $post );

// Get class info
$post = array( 'student_id' => $user_id );
$user_data['classes'] = PWTask( 'grab_instances', $post );

// Get availability info
$post = array( 'student_id' => $user_id );
$user_data['time_string'] = PWTask( 'grab_availability', $post );

// Limit the timestring to only today
$user_data['time_string'] = substr( $user_data['time_string'], 24*(intval( date('N'))-1), 24 );

return( OutputFormatting( $user_data ) );

?>
