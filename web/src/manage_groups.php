<?php
// account.php: Allows the user to manage the groups they are a part of
// 9-17-13
// Arthur Wuterich

// Retuns a member name in a member block
// Precondition: Valid string name
function GroupMemberBlock( $name )
{
	return "<div class=\"member_block\">{$name}</div>";
}

// Takes a groupname and returns a group block
// Precondition: valid group name string
function CreateGroupBlock( $groupName )
{
	$html = 
	"
	<div class=\"group_block\">
	<button name=\"this\" value=\"{$groupName}\">{$groupName}</button>
	</div>
	";	
	
	return $html;
}


$outputHtml = '';

// Get information about individual groups
if( isset($_POST['this']) && $_POST['this'] != '' )
{
	// Get members in the group
	$post = array( 'group' => $_POST['this'] );
	$groupMembers = PWTask( 'get_users', $post );
	$groupMembers = json_decode( $groupMembers ); 
	
	$outputHtml = 
	"
	<h1>{$_POST['this']}</h1>
	<h2>Users part of group:</h2>";
	
	// Format them into a list
	foreach( $groupMembers as $member )
	{
		$outputHtml .= GroupMemberBlock( $member );
	}
	
	$outputHtml .= "<button name=\"this\" value=\"\">All Groups</button>";
}
else
{
	// Get the groups this user is part of
	$post = array( 'user' => $_SESSION['USER_ID'] );
	$groups = json_decode( PWTask( 'get_groups', $post ) );
	
	if( is_array( $groups ) )
	{
		foreach( $groups as $group )
		{
			$outputHtml .= CreateGroupBlock( $group[0] );
		}
	}
}
?>

<div class="window_background center_on_page large_window drop_shadow">
	<h1> <?php echo $_SESSION['USER'] ?>'s Groups </h1>
	<form method="POST">
		<?php echo $outputHtml; ?>
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
