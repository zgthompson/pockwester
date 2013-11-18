<?php

//	group.php: Shows a group and allows operation on groups
//   $group_name: The name of the group to display and perform operations on
//	9-27-13
//	Arthur Wuterich

// Retuns a member name in a member block
// Precondition: Valid string name
function GroupMemberBlock( $name, $lfg = false )
{
	if( $lfg )
	{
		return "<div class=\"member_block group_lfg\">{$name}</div>";
	}
	return "<div class=\"member_block\">{$name}</div>";
}

// Returns a meeting block string
function MeetingBlock( $value )
{
	return "<div class=\"group_meeting_row\">{$value}</div>";
}

// Returns a details block string
function DetailsBlock( $detail )
{
	return "<div class=\"group_detail_row\">{$detail}</div>";
}

// Switch on internal functions
if( isset( $_POST['this'] ) )
{
	switch( $_POST['this'] )
	{
		case 'leave_group':
			$post = array( 'user_id' => $_SESSION['USER_ID'], 'group_name' => $_POST['group_name'] );
			//PWTask( 'remove_from_group', $post );
			echo 'left group';
		break;

		case 'join_group':
			$post = array( 'user' => $_SESSION['USER_ID'], 'group_name' => $_POST['group_name'] );
			//PWTask( 'add_to_group', $post );
			echo 'joined group';			
		break;
		
	}
}

$userHtml = '';

$group_id = $_POST['group_id'];
$post = array( 'group_id' => $group_id );
$group = json_decode( PWTask( 'grab_study_groups', $post ) );
$group = $group->study_groups;


// Details
$detailsHtml = '';
$actionsHtml = '';

// Leave group button
$actionsHtml .= '<button name="this" value="leave_group" >Leave Group</button>';
$actionsHtml .= '<button name="this" value="join_group" >Join Group</button>';

?>

<div class="window_background center_on_page large_window drop_shadow group">
	<h1> <?php echo $group->title ?> Details </h1>
	<div class="large_table">
		<div class="large_table_row">
			<div class="large_table_cell">
				<h2> Users </h2>
				<?php echo $userHtml; ?>	
			</div>
			<div class="large_table_cell">
				<h2> More Details </h2>
				<?php echo $detailsHtml; ?>
			</div>			
		</div>
		<div class="large_table_row">
			<div class="large_table_cell">
				<h2> Actions </h2>
				<form method="POST">
					<?php echo $actionsHtml; ?>
					<input type="hidden" name="group_id" value="<?php echo $_POST['group_id']; ?>" >
				</form>
			</div>
			<div class="large_table_cell">
				<h2> Meeting Time </h2>
				<?php echo $group->time; ?>
			</div>					
		</div>
	</div>
	<form method="POST">
		<button type="submit" onclick="Back( this );">Back</button>
	</form>
</div>
