<?php
// messages.php: Displays messages for the user
// 10-10-13
// Arthur Wuterich

// Builds a message block
function MessageBlock( $messageObj )
{
	return "<tr><td>{$messageObj->MESSAGE_ID}</td><td class=\"small\"><input type=\"checkbox\" name=\"select[]\" value=\"{$messageObj->MESSAGE_ID}\"/></td><td>{$messageObj->SENDER_NAME}</td><td>{$messageObj->MESSAGE}</td><td>{$messageObj->SENT}</td></tr>";
}

// Delete messages if requested
if( isset($_POST['this']) && $_POST['this'] == 'messages_delete' )
{
}


// Get the messages for the user
$post = array( 'user_id' => $_SESSION['USER_ID'] );
$messages = json_decode( PWTask( 'get_messages', $post ) );
$messageHtml = '';

foreach( $messages as $msg )
{
	$messageHtml .= MessageBlock( $msg );
}

?>
<script>
$("document").ready( function(){
	$("#select_all").click( function(event){
		event.preventDefault();
	});
	
	$("#select_all").mousedown( function(event){
		event.preventDefault();
	});	
	
	$("#select_all").mouseup( function( event ){
		event.preventDefault();
		if( $('#select_all').is(":checked") )
		{
			$("input[type='checkbox']").removeAttr('checked');		
		}
		else
		{
			$("input[type='checkbox']").prop ( "checked" ,"checked" );		
		}
	});
});
</script>
<div id="login_window" class="window_background center_on_page large_window drop_shadow no_wrap messages">
	<form  method="POST">
		<h2>Messages</h2>
		<table class="message_table">
		<tr class="first_row"><td>ID</td><td class="small" ><input type="checkbox" id="select_all" />Flag</td><td>Sender</td><td>Message</td><td>Date</td></tr>
			<?php echo $messageHtml; ?>
		</table>
		<button type="submit" name="this" value="messages_delete">Delete Selected</button>
		<button type="submit" name="goto" value="home.php">Back</button>
	</form>
</div>
