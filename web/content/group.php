<?php

//	group.php: Shows a group and allows operation on groups
//   $group_name: The name of the group to display and perform operations on
//	9-27-13
//	Arthur Wuterich

// Retuns a member name in a member block
// Precondition: Valid string name
function GroupMemberBlock( $name )
{
	return "<div class=\"member_block\">{$name}</div>";
}

// Returns a meeting block string
function MeetingBlock( $value )
{
	return "<div class=\"group_meeting_row\">{$value}</div>";
}

// Returns a details block string
function DetailsBlock( $detail )
{
	return "<div class=\"group_detail_row\">{$detail}</div>";
}

// Switch on internal functions
if( isset( $_POST['this'] ) )
{
	switch( $_POST['this'] )
	{
		case 'leave_group':
			$post = array( 	'student_id' 	=> $_SESSION['USER_ID'], 
							'group_id' 		=> $_POST['group_id'],
							'action'		=> 'leave' );
			PWTask( 'group_action', $post );
		break;

		case 'join_group':
			$post = array( 	'student_id' 	=> $_SESSION['USER_ID'], 
							'group_id' 		=> $_POST['group_id'],
							'action'		=> 'join' );
			PWTask( 'group_action', $post );
		break;
		
	}
}

$group_id = $_POST['group_id'];
$post = array( 'group_id' => $group_id );
$group = json_decode( PWTask( 'grab_study_groups', $post ) );
$group = $group->study_groups[0];


// Details
$detailsHtml = '';
$actionsHtml = '';
$userHtml = '';

// Leave group button
$actionsHtml .= '<button name="this" value="leave_group" >Leave Group</button>';
$actionsHtml .= '<button name="this" value="join_group" >Join Group</button>';

// User html
foreach( $group->students as $student )
{
	$userHtml .= GroupMemberBlock( $student );
}

?>
<script type="text/javascript">
	var group_id = <?php echo $_POST['group_id']; ?>;
	var user_id = <?php echo $_SESSION['USER_ID']; ?>;
	
	//http://stackoverflow.com/questions/1912501/unescape-html-entities-in-javascript
	function htmlDecode(value){ 
	  return $('<div/>').html(value).text(); 
	}
	//http://stackoverflow.com/questions/1144783/replacing-all-occurrences-of-a-string-in-javascript
	function replaceAll(find, replace, str) {
	  return str.replace(new RegExp(find, 'g'), replace);
	}	
	
	// Loads messages for a given group
	function LoadMessages( group_id )
	{
		var post = 
		{ 
			"apikey" : "test",
			"apitask" : "get_messages",
			"group_id" : group_id,
		};
		$.post(
			"http://www.arthurwut.com/pockwester/api/",
			post,
			function(data) {
				// Get the messages
				var messages = JSON.parse(data);
								
				// Clear the chat window
				$("#chat_window").empty();
				
				// Add each message to the chat window
				for( m in messages )
				{
					// Process message text
					var text = htmlDecode(messages[m].message);
					text = text.split('\\"').join( '"'); // *** REFACTOR ***
					
					var sender = messages[m].sender;
					var date = messages[m].sent;
					var $line = $("<div>",
								{
									class:"chat_line",
								});
					var $sender = $("<div>",
									{
										class:"chat_line_sender",
										text: sender,
									});
									
					var $date = $("<div>",
									{
										class:"chat_line_date",
										text: date,
									});
									
					var $message = $("<div>",
									{
										class:"chat_line_message",
										text: text,
									});
									
					var $clear = $("<div>",
									{
										class:"clear",
									});									
					
					$line.append( $sender ).append( $message ).append( $date ).append( $clear );
					$("#chat_window").append( $line );
				}
				
				// Scroll to bottom of chat window
				$("#chat_window").scrollTop($("#chat_window")[0].scrollHeight);
			}
		);
	}
	
	// Loads messages for a given group
	function SendMessage( group_id, sender_id )
	{
		var message = $('#chat_window_message').val();
		
		// Don't send empty messages
		if( message.length <= 0 )
		{
			return;
		}
		// Reset UI
		$('#chat_window_message').val("");
		var post = 
		{ 
			"apikey" : "test",
			"apitask" : "send_message",
			"sender_id" : sender_id,
			"group_id" : group_id,
			"message" : message,
		};
		$.post(
			"http://www.arthurwut.com/pockwester/api/",
			post,
			function(data) {
				LoadMessages(group_id);
			}
		);
	}	
	
	$(document).ready( function(){
		LoadMessages( group_id );
	});
</script>
<div class="window_background center_on_page large_window drop_shadow group">
	<h1> <?php echo $group->title ?> Details </h1>
	<div class="large_table">
		<div class="large_table_row">
			<div class="large_table_cell">
				<h2> Users </h2>
				<?php echo $userHtml; ?>	
			</div>
			<div class="large_table_cell">
				<h2> Meeting Time </h2>
				<?php echo DetailsBlock( $group->time ); ?>
			</div>			
		</div>
		<div class="large_table_row">
			<div class="large_table_cell">		
				<h2> Messages </h2>
				<div id="chat">
					<div id="chat_window" disabled>
					</div>
					<div id="chat_input">
						<input type="text" id="chat_window_message" value="" />
						<button id="chat_window_send" onclick="SendMessage( group_id, user_id );">Send</button>
					</div>
				</div>
			</div>
			<div class="large_table_cell">
				<h2> Actions </h2>
				<form method="POST">
					<?php echo $actionsHtml; ?>
					<input type="hidden" name="group_id" value="<?php echo $_POST['group_id']; ?>" >
				</form>
			</div>
		</div>
	</div>
	<form method="POST">
		<button type="submit" onclick="Back( this );">Back</button>
	</form>
</div>
