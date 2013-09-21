<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

// Get the groups this user is part of
$post = array( 'user' => $_SESSION['USER_ID'] );
$groups = json_decode( PWTask( 'get_groups', $post ) );

?>
<h1> <?php echo $_SESSION['USER']; ?> is part of these groups: </h1>
<?php
	foreach( $groups as $group )
	{
		echo "{$group[0]}<BR/>";
	}
?>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Home </h1>
	<form action="index.php" method="POST">
		<button type="submit" name="goto" value="search_classes.php">Add Classes</button>
		<button type="submit" name="goto" value="logout.php">Logoff <?php echo $_SESSION['USER']; ?></button>
	</form>
</div>
