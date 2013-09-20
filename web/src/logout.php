<?php
// logout.php: Logs out the current user and provideds a redirect 
// 9-17-13
// Arthur Wuterich

unset($_SESSION['USER']);
unset($_SESSION['USER_ID']);
$_SESSION['CURRENT_PAGE'] = LOGIN_PAGE;

?>
<script type="text/javascript">
	BouncePage( 1 );
</script>
<div id="login_window" class="rounded_window center_on_page small_window drop_shadow">
	<h1> Pockwester Scheduling Application </h1>
	<h2> Logged out Successfully </h2>
	<form action="index.php" method="POST">
		<button type="submit" name="goto" value="index.php">Login</button>
	</form>
</div>
