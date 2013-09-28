<?php
// account.php: Allows the user to manage the groups they are a part of
// 9-17-13
// Arthur Wuterich

// Takes a groupname and returns a group block
// Precondition: valid group name string
function CreateGroupBlock( $groupName )
{
	$html = 
	"
	<div class=\"group_block\">
	<form method=\"POST\">
		<input type=\"hidden\" name=\"group_name\" value=\"{$groupName}\" />
		<button name=\"goto\" value=\"group.php\">{$groupName}</button>
	</form>
	</div>
	";	
	
	return $html;
}


$outputHtml = '';

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

?>

<div class="window_background center_on_page large_window drop_shadow">
	<h1> <?php echo $_SESSION['USER'] ?>'s Groups </h1>
	<form method="POST">
		<?php echo $outputHtml; ?>
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
