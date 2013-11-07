<?php
//	get_user_overview.php: Will return an array with the three most current study groups, The users next three classes, and the current day's availability
//	$user_id: ID number to reference against
//	11-6-13
//	Arthur Wuterich

DB_Connect();

$user_id = Get( 'user_id' );

$user_data = array();

// Composite user_key *** REMOVE ***
$user_id = explode( ',', $user_id );

// Get study group info
$post = array( 'user' => $user_id[0] );
$user_data['groups'] = PWTask( 'get_groups', $post );

// Get class info
$post = array( 'student_id' => $user_id[1] );
$user_data['classes'] = PWTask( 'grab_instances', $post );

// Get availability info
$post = array( 'user' => $user_id[0] );
$user_data['time_string'] = PWTask( 'get_avail', $post );


return( OutputFormatting( $user_data ) );
	
	
?>