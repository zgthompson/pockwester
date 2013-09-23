<?php
// account.php: Allows the user to manage the groups they are a part of
// 9-17-13
// Arthur Wuterich

// Get the groups this user is part of
$post = array( 'user' => $_SESSION['USER_ID'] );
$groups = json_decode( PWTask( 'get_groups', $post ) );

$groups_html = '';

foreach( $groups as $group )
{
	$groups_html .= CreateGroupBlock( $group[0] );
}

?>
<div class="window_background center_on_page large_window drop_shadow">
	<h1> <?php echo $_SESSION['USER'] ?>'s Groups </h1>
	<form method="POST">
		<?php echo $groups_html; ?>
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
