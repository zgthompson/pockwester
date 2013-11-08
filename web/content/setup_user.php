<?php
//	setup_user.php: Will give the user direction to setup their account
//	10-31-13
//	Arthur Wuterich

$saHtml = '';
$scHtml = '';
$buttonText = 'Skip';
$post = array( 'user_id' => $_SESSION['USER_ID'] );
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

// Change the button text if everything is setup
if( $needs[0] > 0 && $needs[1] > 0 )
{
	$buttonText = 'Continue';
}
?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow new_user">
	<h1> New User Setup </h1>
	<form  method="POST">
		<h2>Please setup your class schedule and availability to start using Forge:</h2>
		<button type="submit" onclick="GotoPage( this, 'manage_availability/' );">Set Availability</button>
		<?php echo $saHtml; ?><BR/>
		<button type="submit" onclick="GotoPage( this, 'search_classes/' );">Set Classes</button>
		<?php echo $scHtml; ?><BR/>
		<BR/>
		<BR/>
	</form>
	<form method="POST">
		<input type="hidden" name="bypass_needs" value="1" />
		<button type="submit" onclick="GotoPage( this, '/home/' );"><?php echo $buttonText; ?></button>
	</form>
</div>
