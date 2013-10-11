<?php
//	remove_from_group.php: Will attempt to remove a user from a group
//	$user_id: User name to remove from group
//	$group_name: The group name to remove the user from
//	Arthur Wuterich
//	10-02-13
//

DB_Connect();

$user_id = Get( 'user_id' );
$group_name = Get( 'group_name' );

// Attempt to remove user from the group
DB_Query( "
DELETE FROM USER_GROUP 
WHERE USER_ID = {$user_id} AND
GROUP_ID = ( SELECT GID FROM GROUPS WHERE NAME = \"{$group_name}\")" );

// Send a message to the user that they have left the group
$post = array( 'user_id' => $user_id, 'message' => "You have left the group {$group_name}");
PWTask( 'send_message', $post );

return '1';

?>
