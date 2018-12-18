<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt_project', 'ddwt18','ddwt18');

$template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/ddwt18_project/'
    ),
    2 => Array(
        'name' => 'Overview',
        'url' => '/ddwt18_project/overview/'
    ),
    3 => Array(
        'name' => 'Add series',
        'url' => '/ddwt18_project/add/'
    ),
    4 => Array(
        'name' => 'My Account',
        'url' => '/ddwt18_project/myaccount/'
    ),
    5 => Array(
        'name' => 'Register',
        'url' => '/ddwt18_project/register/'
    ));

/* Overview page */
elseif (new_route('/DDWT18/ddwt18_project/overview/', 'get')) {
    /* Page info */
$page_title = 'Overview';
$breadcrumbs = get_breadcrumbs([
    'DDWT18' => na('/DDWT18/', False),
    'Week 2' => na('/DDWT18/ddwt18_project/', False),
    'Overview' => na('/DDWT18/ddwt18_project/overview', True)
]);
$navigation = get_navigation($template, '2');

/* Page content */
$page_subtitle = 'The overview of all rooms available';
$page_content = 'On this page you will find all available rooms for internationals.';
$left_content = get_room_table(get_rooms($db), $db);

/* Get error msg from POST route */
if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }

/* Choose Template */
include use_template('main');
}

/*
else {
    http_response_code(404);
}
*/


