<?php
//	pw_bar.php: Defined the content bar on the top of the website
// 9-22-13
// Arthur Wuterich

// Get the count of user messages
$post = array( 'user_id' => $_SESSION['USER_ID'] );
$newMessages = json_decode( PWTask( "get_new_messages", $post ) );
$newMessages = $newMessages[0]->NUMBER_NEW_MESSAGES;

// If the count is 0 or less then dont display the number
if( intval($newMessages) <= 0 )
{
	$newMessages = '';
}

?>
<div id="pw_bar">
	Pockwester <?php echo PW_VERSION; ?>
	<a href="https://github.com/zgthompson/pockwester" target="_blank">Github Source</a>
	<a href="http://pwa.arthurwut.com/test_driver.html" target="_blank">PWApi Test Driver</a>
	<div id="page_title">
		<?php echo GetTitle(); ?>
	</div>
	<?php if( isset($_SESSION['USER']) ) { ?>
	<form method="post">
		<button name="goto" value="messages.php"><?php echo $newMessages; ?> Messages</button>
		<button name="goto" value="home.php">Home</button>
		<button name="goto" value="account.php">My Account</button>
		<button name="goto" value="logout.php">Logoff <?php echo $_SESSION['USER']; ?></button>
	</form>
	<?php } ?>
</div>
