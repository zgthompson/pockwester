<?php
// grab_instances.php: Pulls the course instance information from database, formats
//                  into json object, and returns the results
//      -Returns the course instances for provided campus matching $course_id
//      -Precondition: Constants in api.cfg.php are defined
//      -$course_id: Will only return course instances that have a course id matching $course_id
// Zachary Thompson, Arthur Wuterich
// 10-15-13

DB_Connect();

// Get like
$course_id = Get('course_id', false);
$instance_ids = Get('instance_ids', false);
$student_id = Get('student_id', false);

if ( isset($course_id) || isset($instance_ids) || isset($student_id) )
{
    WhereAdd( $where, "course.id = course_id" );
    WhereAdd( $where, "course_instance.id = course_instance_id" );
    WhereAdd( $where, "section.id = section_id" );

    if (isset($course_id)) {
        WhereAdd( $where, "course.id = {$course_id}");
    }
    else if (isset($instance_ids)) {
        WhereAdd( $where, "course_instance.id IN ({$instance_ids})");
    }
    else if (isset($student_id)) {
        WhereAdd( $where, "course_instance.id IN (SELECT course_instance_id FROM student_course_instance WHERE student_id = {$student_id})");
    }

    $columns = "title, subject, catalog_no, course_instance_id, section_id, day, start_time, end_time, location, component";
    $tables = "course, course_instance, section, section_time";

    $instances = DB_GetArray( DB_Query( "SELECT {$columns} FROM {$tables} {$where} ORDER BY course_instance_id" ), true);

    return ( OutputFormatting( array( 'instances' => $instances ) ) );
}

else {
    return "course_id, student_id or instance_ids parameter must be set";
}


