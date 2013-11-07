<?php
// manage_groups.php: Allows the user to manage the groups they are a part of
// 9-17-13
// Arthur Wuterich

// Takes a groupname and returns a group block
// Precondition: valid group name string
function CreateGroupBlock( $groupName )
{
	$html = 
	"
	<div class=\"group_block\">
	<form method=\"POST\">
		<input type=\"hidden\" name=\"group_name\" value=\"{$groupName}\" />
		<button onclick=\"GotoPage( this, 'group/' );\">{$groupName}</button>
	</form>
	</div>
	";	
	
	return $html;
}

function CreateClassBlock( $groupName )
{
	$html = 
	"
	<div class=\"class_block\">
	<form method=\"POST\">
		<input type=\"hidden\" name=\"group_name\" value=\"{$groupName}\" />
		<button onclick=\"GotoPage( this, 'group/' );\">{$groupName}</button>
	</form>
	</div>
	";	
	
	return $html;
}


$studyGroupHtml = '';
$classHtml = '';
$searchHtml = '';
$resultSize = 0;

// Get the groups this user is part of
$post = array( 'user' => $_SESSION['USER_ID'] );
$groups = json_decode( PWTask( 'get_groups', $post ) );

if( is_array( $groups ) )
{
	foreach( $groups as $group )
	{
		if( strpos($group[0], '+' )  !== false )
		{
			$studyGroupHtml .= CreateClassBlock( $group[0] );
		}
		else
		{
			$classHtml .= CreateGroupBlock( $group[0] );
		}
	}
}

if( isset($_POST['group_search_value']) && $_POST['group_search_value'] != '' )
{
	$post = array( 'like' => $_POST['group_search_value'] );
	
	$searchGroups = json_decode( PWTask( 'get_groups', $post ) );
	
	if( is_array( $searchGroups ) )
	{
		
		foreach( $searchGroups as $group )
		{

		
			if( strpos($group[0], '+' )  !== false )
			{

				$resultSize++; 
		
				$searchHtml .= CreateGroupBlock( $group[0] );
			}
		}
	}	
}

?>

<div class="window_background center_on_page large_window drop_shadow manage_groups">
	<div class="large_table" >
		<div class="large_table_row">
			<div class="large_table_cell">			
				<h1> <?php echo $_SESSION['USER'] ?>'s Study Groups </h1>
					<?php echo $studyGroupHtml; ?>
			</div>
		</div>
	</div>
	
	<div class="large_table" >
		<div class="large_table_row">
			<div class="large_table_cell">
				<form method="POST">
					<h1> Search For Study Groups </h1>
					<input class="search_classes_input" type="text" name="group_search_value" value="<?php echo $_POST['group_search_value']; ?>" />
					<button class="search_classes_button" type="submit" name="this" value="search_classes">SEARCH</button>
				</form>					
				<?php 
					if( isset($_POST['group_search_value']) && $_POST['group_search_value'] != '' )
					{
						echo ($resultSize==0)?"<h2>no groups for <i>'{$_POST['group_search_value']}</i>'":"<h2>{$resultSize} groups for <i>'{$_POST['group_search_value']}'</i></h2>"; 
					}		
				?>
				<?php echo ($searchHtml=='')?'':$searchHtml; ?>
			</div>
		</div>
	</div>
	
	<form method="POST">
		<button type="submit" onclick="Back( this );">Back</button>
	</form>
</div>
