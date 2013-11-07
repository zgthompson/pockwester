<?php
// logout.php: Logs out the current user and provideds a redirect 
// 9-17-13
// Arthur Wuterich

//unset($_SESSION);
unset($_POST);
session_unset();
$_SESSION['CURRENT_PAGE'] = LOGIN_PAGE;

?>
<script type="text/javascript">
	BouncePage( <?php echo BOUNCE_QUICK; ?>, '/login/' );
</script>
<div id="login_window" class="window_background center_on_page small_window drop_shadow logout">
	<h1> Pockwester Scheduling Application </h1>
	<h2> Logged out Successfully </h2>
	<form  method="POST">
		<button type="submit" onclick="GotoPage( this, '/login/' );">Login</button>
	</form>
</div>
