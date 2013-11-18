<?php
// manage_groups.php: Allows the user to manage the groups they are a part of
// 9-17-13
// Arthur Wuterich

// Takes a groupname and returns a group block
// Precondition: valid group name string
function CreateGroupBlock( $group )
{
	$html = 
	"
	<div class=\"group_block\">
	<form method=\"POST\">
		<input type=\"hidden\" name=\"group_id\" value=\"{$group->id}\" />
		<button onclick=\"GotoPage( this, 'group/' );\">{$group->title}, {$group->time}</button>
	</form>
	</div>
	";	
	
	return $html;
}
// Set LFG flag
if( isset( $_POST['set_lfg'] ) )
{
	$post = array( 'student_id' => $_SESSION['USER_ID'], 'instance_id' => $_POST['set_lfg'], 'flag' => 'y' );
	PWTask( 'set_lfg_flag', $post );
}
/*
function CreateClassBlock( $groupName )
{
	$html = 
	"
	<div class=\"class_block\">
	<form method=\"POST\">
		<input type=\"hidden\" name=\"group_id\" value=\"{$groupName}\" />
		<button onclick=\"GotoPage( this, 'group/' );\">{$groupName}</button>
	</form>
	</div>
	";	
	
	return $html;
}
*/


$studyGroupHtml = '';
$classHtml = '';
$searchHtml = '';
$resultSize = 0;

// Get the groups this user is part of
$post = array( 'student_id' => $_SESSION['USER_ID'] );
$groups = json_decode( PWTask( 'grab_study_groups', $post ) );
if( is_array( $groups->study_groups ) )
{
	foreach( $groups->study_groups as $group )
	{
		$studyGroupHtml .= CreateGroupBlock( $group );
	}
}
else if( is_object( $groups->study_groups ) )
{
	$studyGroupHtml .= CreateGroupBlock( $groups->study_groups );
}

if( isset($_POST['group_search_value']) && $_POST['group_search_value'] != '' )
{
	/*
	$post = array( 'like' => $_POST['group_search_value'] );
	$searchGroups = json_decode( PWTask( 'grab_study_groups', $post ) );
	
	if( is_array( $searchGroups->studygroups ) )
	{
		foreach( $searchGroups as $group )
		{
			$resultSize++; 
			$searchHtml .= CreateGroupBlock( $group );
		}
	}
	*/	
}
else
if( isset($_POST['course_instance_id']) && $_POST['course_instance_id'] != '' )
{
	
	$post = array( 'instance_id' => $_POST['course_instance_id'] );
	$searchGroups = json_decode( PWTask( 'grab_study_groups', $post ) );
	
	if( is_array( $searchGroups->studygroups ) )
	{
		foreach( $searchGroups->studygroups as $group )
		{
			$resultSize++; 
			$searchHtml .= CreateGroupBlock( $group );	
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
					echo ($resultSize==0)?"<h2>no study groups found":"<h2>found {$resultSize} group(s)</h2>";
					
					if( isset( $_POST['course_instance_id'] ) )
					{
						echo "
						<form method=\"post\">
							<button name=\"set_lfg\" value=\"{$_POST['course_instance_id']}\">Start Looking For Group</button>
						</form>";
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
