<?php
//	pw_bar.php: Defined the content bar on the top of the website
// 9-22-13
// Arthur Wuterich

?>
<pw_bar>
	Pockwester <?php echo PW_VERSION; ?>
	<a href="https://github.com/zgthompson/pockwester" target="_blank">Github Source</a>
	<a href="http://pwa.arthurwut.com/test_driver.html" target="_blank">PWApi Test Driver</a>
	<?php if( isset($_SESSION['USER']) ) { ?>
	<form  method="post">
		<button name="goto" value="home.php">Home</button>
		<button name="goto" value="manage_groups.php">Manage Groups</button>
		<button name="goto" value="account.php">My Account</button>
		<button name="goto" value="logout.php">Logoff <?php echo $_SESSION['USER']; ?></button>
	</form>
	<?php } ?>
</pw_bar>