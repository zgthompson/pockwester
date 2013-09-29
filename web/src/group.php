<?php

//	group.php: Shows a group and allows operation on groups
//   $group_name: The name of the group to display and perform operations on
//	9-27-13
//	Arthur Wuterich

// Retuns a member name in a member block
// Precondition: Valid string name
function GroupMemberBlock( $name )
{
	return "<div class=\"member_block\">{$name}</div>";
}

$userHtml = '';

// This function will assume that the post variable $group_name is set to the group to view
$group = $_POST['group_name'];

$post = array( 'group' => $group );
$users = json_decode( PWTask( 'get_users', $post ) );

foreach( $users as $user )
{
	$userHtml .= GroupMemberBlock( $user );
}

?>

<div class="window_background center_on_page large_window drop_shadow">
	<h1> <?php echo $group ?> Details </h1>
	
	<div class="large_table">
		<div class="large_table_row">
			<div class="large_table_cell">
				<h2> Users </h2>
				<?php echo $userHtml; ?>	
			</div>
			<div class="large_table_cell">
				<h2> More Details </h2>
			</div>			
		</div>
		<div class="large_table_row">
			<div class="large_table_cell">
				<h2> Actions </h2>
			</div>
			<div class="large_table_cell">
				<h2> Meetings </h2>
			</div>					
		</div>
	</div>
	<form method="POST">
		<button type="submit" name="goto" value="manage_groups.php">Back</button>
	</form>
</div>