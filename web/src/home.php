<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich

?>
<div id="login_window" class="window_background center_on_page small_window drop_shadow home">
	<h1> Home </h1>
	<form  method="POST">
		<button type="submit" name="goto" value="manage_groups.php">Manage Groups</button>
		<button type="submit" name="goto" value="search_classes.php">Join Class Groups</button>
		<button type="submit" name="goto" value="manage_availability.php">Manage Availability</button>
		<button type="submit" name="goto" value="logout.php">Logoff <?php echo $_SESSION['USER']; ?></button>
	</form>
</div>
