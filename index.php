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
/* Get Number of Series and users */
$nbr_series = count_series($db);
$nbr_users = count_users($db);
/* always use template 'cards' */
$right_column = use_template('cards');

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
/*
else {
    http_response_code(404);
}
*/


