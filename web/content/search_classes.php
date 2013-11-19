<?php
//	search_clases.php: Will allow the user to search for class groups 
// 9-17-2013
// Arthur Wuterich

// Get class data from PWApi
$classes = PWTask( 'grab_courses' );

$classes = json_decode( $classes, true );
$classes = $classes['courses'];

$classes_dropdown = '<select name="class[]" id="select_copy">';

$autoCompleteTags = array();

// Build the class select object
foreach( $classes as $class )
{
	$autoCompleteTags[] = array( $class['subject'], $class['catalog_no'], $class['id'], $class['title'] );
}

$classes_dropdown .= '</select>';

?>

<script type="text/javascript">

function UpdateCourseIds()
{

	var courseTags = '';
	$("*[course-data]").each(function(){
		courseTags += $(this).attr('course-data')+",";
	});
	
	$("#select_sections_ids").val( courseTags );

}

function BindAutoComplete()
{
	
    $(".classes").autocomplete({
        source: courseObjects,
		change: function(event,ui){
			if( ui.item == null )
			{
				$(this).val( "" );
				$(this).attr( 'course-data', "" );
				return;
			}
			
			$(this).attr( 'course-data', ui.item.subject + " " + ui.item.cat + ":" + ui.item.id );
			UpdateCourseIds();
		},		
    });
}


// Copies the classes drop down menu and adds to document
function AddField()
{
	// Copy the classes dropdown menu with options
	var lastOptions = $(".classes_input").last();
	var options = $(".classes_input").last().clone();
	$(options).children("input").val("");
	$(options).fadeIn(500).insertAfter(lastOptions);
	BindAutoComplete();
}
	courseObjects = [
	
	<?php
	// Pass the tags to the JS autocomplete function
	foreach( $autoCompleteTags as $tag )
	{
		echo "
		{
			subject:\"{$tag[0]}\",
			cat:\"{$tag[1]}\",
			id:\"{$tag[2]}\",
			label:\"{$tag[0]} {$tag[1]}: {$tag[3]}\",
		},";
	}
	?>
	];
	
	$( document ).ready(function() {
		BindAutoComplete();
	});
</script>

<div id="course_form" class="window_background center_on_page large_window drop_shadow search_classes" >
<div class="search_classes_left_align" >
	<h1> Select Courses </h1>	
		<form  method="POST" >
			<div class="classes_input">
				<label>Course:</label>
				<input class="classes" />
			</div>
			<button type="button" name="add" id="add" class="add" onclick="AddField();">+</button>
</div>			
			<BR />
			<input type="hidden" id="select_sections_ids" name="select_sections_ids" value="" />
			<button type="submit" onclick="Back( this );">Back</button>
			<button type="submit" onclick="GotoPage( this, 'sections/' );">Continue</button>
		</form>
</div>