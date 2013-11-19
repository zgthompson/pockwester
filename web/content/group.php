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
			$post = array( 	'student_id' 	=> $_SESSION['USER_ID'], 
							'group_id' 		=> $_POST['group_id'],
							'action'		=> 'leave' );
			PWTask( 'group_action', $post );
		break;

		case 'join_group':
			$post = array( 	'student_id' 	=> $_SESSION['USER_ID'], 
							'group_id' 		=> $_POST['group_id'],
							'action'		=> 'join' );
			PWTask( 'group_action', $post );
		break;
		
	}
}

$group_id = $_POST['group_id'];
$post = array( 'group_id' => $group_id );
$group = json_decode( PWTask( 'grab_study_groups', $post ) );
$group = $group->study_groups[0];


// Details
$detailsHtml = '';
$actionsHtml = '';
$userHtml = '';

// Leave group button
$actionsHtml .= '<button name="this" value="leave_group" >Leave Group</button>';
$actionsHtml .= '<button name="this" value="join_group" >Join Group</button>';

// User html
foreach( $group->students as $student )
{
	$userHtml .= GroupMemberBlock( $student );
}

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
				<h2> Meeting Time </h2>
				<?php echo DetailsBlock( $group->time ); ?>
			</div>			
		</div>
	</div>
	<HR/>
	<h2> Actions </h2>
	<form method="POST">
		<?php echo $actionsHtml; ?>
		<input type="hidden" name="group_id" value="<?php echo $_POST['group_id']; ?>" >
	</form>
	<HR/>
	<form method="POST">
		<button type="submit" onclick="Back( this );">Back</button>
	</form>
</div>
