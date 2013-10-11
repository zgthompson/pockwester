<?php
// messages.php: Displays messages for the user
// 10-10-13
// Arthur Wuterich

// Builds a message block
function MessageBlock( $message )
{
	return "<div class=\"message_block\">{$message}</div>";
}

// Get the messages for the user
$post = array( 'user_id' => $_SESSION['USER_ID'] );
$messages = json_decode( PWTask( 'get_messages', $post ) );
$messageHtml = '';

foreach( $messages as $msg )
{
	$messageHtml .= MessageBlock( $msg->MESSAGE );
}

?>

<div id="login_window" class="window_background center_on_page large_window drop_shadow no_wrap messages">
	<form  method="POST">
		<h2>Messages</h2>
		<?php echo $messageHtml; ?>
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
