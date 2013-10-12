<?php
// get_courses.php: Pulls the course information from database, formats
//                  into json object, and returns the results
//      -Returns the courses for provided campus matching $like
//      -Precondition: Constants in api.cfg.php are defined
//      -$like: Will only return courses that have a name that is similar to $like
// Zachary Thompson
// 10-11-13

DB_Connect();

// Get like
$like = Get('like', false);


if ( isset($like) )
{
    WhereAdd( $where, "(title LIKE \"%{like}%\" OR 
                        concat(subject, catalog_no) LIKE \"%{like}%\" OR
                        concat(subject, ' ', catalog_no) LIKE \"%{like}%\")")

