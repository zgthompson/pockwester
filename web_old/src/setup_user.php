<?php
//	setup_user.php: Will give the user direction to setup their account
//	10-31-13
//	Arthur Wuterich

$saHtml = '';
$scHtml = '';

$post = array( 'user_id' => "{$_SESSION['USER_ID']},{$_SESSION['USER_ID_BETA']}");
$needs = json_decode( PWTask( 'user_is_setup', $post ) );

// Availability
if( $needs[0] <= 0 )
{
	$saHtml = "<span class=\"setup_incomplete\"></span>";
}
else
{
	$saHtml = "<span class=\"setup_complete\"></span>";
}

// Classes
if( $needs[1] <= 0 )
{
	$scHtml = "<span class=\"setup_incomplete\"></span>";
}
else
{
	$scHtml = "<span class=\"setup_complete\"></span>";
}
?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow new_user">
	<h1> New User Setup </h1>
	<form  method="POST">
		<h2>Please setup your class schedule and availability to start using Forge:</h2>
		<button type="submit" name="goto" value="manage_availability.php">Set Availability</button>
		<?php echo $saHtml; ?><BR/>
		<button type="submit" name="goto" value="search_classes.php">Set Classes</button>
		<?php echo $scHtml; ?><BR/>
		<BR/>
		<BR/>
		<button type="submit" name="goto" value="home.php">Skip</button>
	</form>
</div>
