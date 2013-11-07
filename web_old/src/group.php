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
			PWTask( 'remove_from_group', $post );
		break;

		case 'join_group':
			$post = array( 'user' => $_SESSION['USER_ID'], 'group_name' => $_POST['group_name'] );
			PWTask( 'add_to_group', $post );
		break;
		
		case 'set_lfg_flag':
			$post = array( 'group_name' => $_POST['group_name'], 'user_id' => $_SESSION['USER_ID'], 'bit_flag' => FLAG_LFG );
			PWTask( 'set_user_group_flag', $post );

			// Attempt to form a subgroup
			$post = array(' group_name' => $_POST['group_name']);
			$newGroup = PWTask( 'form_subgroup', $post );	

		break;

		case 'unset_lfg_flag':
			$post = array( 'group_name' => $_POST['group_name'], 'user_id' => $_SESSION['USER_ID'], 'bit_flag' => FLAG_LFG, 'remove' => 1 );
			PWTask( 'set_user_group_flag', $post );
		break;
	}
}

$userHtml = '';

// This function will assume that the post variable $group_name is set to the group to view
$group = $_POST['group_name'];

$post = array( 'group' => $group, 'group_name' => $group );
$users = json_decode( PWTask( 'get_users', $post ) );

$post['flag'] = FLAG_LFG;
$LFGUsers = json_decode( PWTask( 'get_users', $post ) );

if( count($users) <= 0 )
{
	$userHtml .= GroupMemberBlock( "No Users in Group" );
}
else
{
	foreach( $users as $user )
	{
		$userHtml .= GroupMemberBlock( $user, in_array( $user, $LFGUsers ) );
	}
}

// Get the details about the group
$groupDetails = json_decode( PWTask( 'get_group_details', $post ) );



// Details
$detailsHtml = '';
$detailsHtml .= DetailsBlock( "Number of Members: {$groupDetails->NUMBER_OF_MEMBERS}" );

// Actions
$actionsHtml = '';

// Change join group button and text if user is in the group
$inGroup = in_array( strtolower($_SESSION['USER']), $users );
if( $inGroup )
{
	$actionsHtml .= "<button name=\"this\" value=\"leave_group\" class=\"group_action_row\">Leave Group</button>";
}
else
{
	$actionsHtml .= "<button name=\"this\" value=\"join_group\" class=\"group_action_row\">Join Group</button>";
}

// Change the button text and behavior depending on if the user is already searching for a group
$lookingForGroup = in_array( strtolower($_SESSION['USER']), $LFGUsers );
if( $lookingForGroup )
{
	$actionsHtml .= "<button name=\"this\" value=\"unset_lfg_flag\" class=\"group_action_row\">Stop Looking For Group</button>";
}
else
{
	$actionsHtml .= "<button name=\"this\" value=\"set_lfg_flag\" class=\"group_action_row\">Start Looking For Group</button>";
}

// Meetings
$meetingsHtml = '';
if( !isset($groupDetails->MEETING_TIMES)  || !is_array($groupDetails->MEETING_TIMES) || count( $groupDetails->MEETING_TIMES ) <= 0 )
{
	$meetingsHtml .= MeetingBlock( "This group has no meeting time" );
}
else
{
	foreach( $groupDetails->MEETING_TIMES as $time )
	{
		$meetingsHtml .= MeetingBlock( GetDayHourString( $time ) );
	}
}
?>

<div class="window_background center_on_page large_window drop_shadow group">
	<h1> <?php echo $group ?> Details </h1>
	<div class="large_table">
		<div class="large_table_row">
			<div class="large_table_cell">
				<h2> Users (green=lfg)</h2>
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
					<input type="hidden" name="group_name" value="<?php echo $_POST['group_name']; ?>" >
				</form>
			</div>
			<div class="large_table_cell">
				<h2> Meeting Times </h2>
				<?php echo $meetingsHtml; ?>
			</div>					
		</div>
	</div>
	<form method="POST">
		<button type="submit" name="goto" value="back">Back</button>
	</form>
</div>
