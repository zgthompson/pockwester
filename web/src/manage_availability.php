<?php
// manage_availability.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

$post = array( 'user' => $_SESSION['USER_ID'] );
$availString = PWTask( 'get_avail', $post );

?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow no_wrap">
	<h1> Availability at a Glance </h1>
	<?php echo FormatTimeString( $availString ) ?>
	<form  method="POST">
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
