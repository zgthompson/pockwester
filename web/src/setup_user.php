<?php
//	setup_user.php: Will give the user direction to setup their account
//	10-31-13
//	Arthur Wuterich


?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow new_user">
	<h1> New User Setup </h1>
	<form  method="POST">
		<h2>Please setup your class schedule and availability to start using Forge:</h2>
		<button type="submit" name="goto" value="manage_availability.php">Set Availability</button>
		<button type="submit" name="goto" value="search_classes.php">Set Classes</button>
		<BR/>
		<BR/>
		<button type="submit" name="goto" value="home.php">Skip</button>
	</form>
</div>