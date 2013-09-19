<?php
// home.php: Landing page for entering the pw web client
// 9-17-13
// Arthur Wuterich
?>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<h2> I'll email you your password... </h2>
	<form action="index.php" method="POST">
		<label for="email">Email</label>
		<input type="textfield" name="email"><BR/>
		<button type="submit" name="goto" value="login.php">Back</button>
		<button type="submit" name="goto" value="new_user.php">Send It</button>
	</form>
</div>
