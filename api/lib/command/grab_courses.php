<?php
// grab_courses.php: Pulls the course information from database, formats
//                  into json object, and returns the results
//      -Returns the courses for provided campus matching $like
//      -Precondition: Constants in api.cfg.php are defined
//      -$like: Will only return courses that have a name that is similar to $like
// Zachary Thompson, Arthur Wuterich
// 10-11-13

DB_Connect();

// Get like
$like = Get('like', false, '');

/*
if ( isset($like) )
{
*/
    WhereAdd( $where, "title LIKE \"%{$like}%\"" );
    WhereAdd( $where, "CONCAT(subject, catalog_no) LIKE \"%{$like}%\"", "OR");
    WhereAdd( $where, "CONCAT(subject, ' ', catalog_no) LIKE \"%{$like}%\"", "OR");

    $columns = "id, subject, catalog_no, title";

    $courses = DB_GetArray( DB_Query( "SELECT {$columns} FROM course {$where}" ), true);

    return ( OutputFormatting( array( 'courses' => $courses ) ) );
/*
}

else {
    return "like parameter must be set";
}
*/




