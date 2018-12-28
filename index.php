<?php
/**
 * Controller
 * User: b.kleppe, l.janssen, t.tan, g.danoe
 * Date: 05-11-18
 * Time: 15:25
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt_project', 'ddwt18','ddwt18');

$template = Array(
    1 => Array(
        'name' => 'Home',
        'url' => '/DDWT18/ddwt18_project/'),
    2 => Array(
        'name' => 'Overview',
        'url' => '/DDWT18/ddwt18_project/overview/'),
    3 => Array(
        'name' => 'Add room',
        'url' => '/DDWT18/ddwt18_project/add/'),
    4 => Array(
        'name' => 'My Account',
        'url' => '/DDWT18/ddwt18_project/myaccount/'),
    5 => Array(
        'name' => 'Register',
        'url' => '/DDWT18/ddwt18_project/register/')
);

/* Home page */
if (new_route('/DDWT18/ddwt18_project/', 'get')) {
    /* Page info */
    $page_title = 'InterRooms';
    $navigation = get_navigation($template, '1');
    /* Get Number of rooms and users */
    $nbr_rooms = count_rooms($db);
    $nbr_users = count_users($db);
    /* always use template 'cards' */
    $right_column = use_template('cards');

    /* Page content */
    $page_subtitle = 'Rooms, especially for internationals.';
    $page_content = 'This platform is establishing a connection between international students, so that they can live together.';
    include use_template('main');
}

/* Overview page */
if (new_route('/DDWT18/ddwt18_project/overview/', 'get')) {
    /* Page info */
    $page_title = 'Overview';
    $navigation = get_navigation($template, '2');

    /* Page content */
    $page_subtitle = 'The overview of all rooms available';
    $page_content = 'On this page you will find all available rooms for internationals.';
    $left_content = get_room_table(get_rooms($db), $db);

    /* Get Number of rooms and users */
    $nbr_rooms = count_rooms($db);
    $nbr_users = count_users($db);
    /* always use template 'cards' */
    $right_column = use_template('cards');

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('main');
}

/* Add room get */
elseif (new_route('/DDWT18/ddwt18_project/add/', 'get')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    /* Page info */
    $page_title = 'Add Room';
    $navigation = get_navigation($template, '3');

    /* Page content */
    $page_subtitle = 'Search a new roommate';
    $page_content = 'Fill in the details of your room.';
    $submit_btn = "Add room";
    $form_action = '/DDWT18/ddwt18_project/add/';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    include use_template('new');
}

/* Add room POST */
elseif (new_route('/DDWT18/ddwt18_project/add/', 'post')) {
    /* Check if logged in */

    /* Add room to database */
    $feedback = add_room($db, $_POST);
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18/ddwt18_project/add/?error_msg=%s',
        json_encode($feedback)));
}

/* Single room */
elseif (new_route('/DDWT18/ddwt18_project/room/', 'get')) {
    /* Get rooms from db */
    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    $owner_name = owner_name($db, $room_info['owner']);
    $display_buttons = get_user_id() == $room_info['room_id'];

    /* Page info */
    $page_title = sprintf("%s %s", $room_info['street'], $room_info['house_number']);
    $navigation = get_navigation($template, '2');

    /* Page content */

    $added_by = $owner_name['firstname']." ".$owner_name['lastname'];
    $page_subtitle = sprintf("Information about %s %s", $room_info['street'], $room_info['house_number']);
    $description = $room_info['description'];
    $type = $room_info['type'];
    $size = $room_info['size'];
    $price = $room_info['price'];
    $tenant = $room_info['tenant'];
    $address = sprintf("%s %s", $room_info['postal_code'], $room_info['city']);
    $birthdate = $owner_name['dateofbirth'];
    $language = $owner_name['language'];
    $phonenumber = $owner_name['phonenumber'];
    $email = $owner_name['email'];
    $address_variable = sprintf("%s %s, %s", $room_info['street'], $room_info['house_number'], $room_info['city']);;

    /* always use template 'cards' */
    $right_column = use_template('owner_card');

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }

    /* Choose Template */
    include use_template('room');
}

/* Register GET */
elseif (new_route('/DDWT18/ddwt18_project/register/', 'get')){
    /* Page info */
    $page_title = 'Register';
    $navigation = get_navigation($template, 5);
    /* Page content */
    $page_subtitle = 'Register here to add rooms or to opt-in for a room';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }
    /* Choose Template */
    include use_template('register');
}

/* Register POST */
elseif (new_route('/DDWT18/ddwt18_project/register/', 'post')){
    /* Register user */
    $feedback = register_user($db, $_POST)
        /* Redirect to homepage */;
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));
}

/* myaccount GET */
elseif (new_route('/DDWT18/ddwt18_project/myaccount/', 'get')){
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    /* Page info */
    $page_title = 'My Account';
    $navigation = get_navigation($template, 4);
    /* Page content */
    $user_name = get_name($db, $_SESSION['user_id']);
    $user = $user_name['firstname']." ".$user_name['lastname'];
    $user_first = $user_name['firstname'];
    $user_last = $user_name['lastname'];
    $user_role = $user_name['role'];
    $user_dob = $user_name['dateofbirth'];
    $user_bio = $user_name['biography'];
    $user_study = $user_name['study'];
    $user_language = $user_name['language'];
    $user_mail = $user_name['email'];
    $user_phone = $user_name['phonenumber'];
    $page_subtitle = 'My account on Rooms Overview!';
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }
    /* Choose Template */
    include use_template('account');
}

/* Contact GET */
elseif (new_route('/DDWT18/ddwt18_project/contact/', 'get')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    $user_name = get_name($db, $_SESSION['user_id']);
    $owner_name = owner_name($db, $room_info['owner']);
    $owner = $owner_name['firstname']." ".$owner_name['lastname'];
    $address = $room_info['street']." ".$room_info['house_number'];
    $name = $user_name['firstname']." ".$user_name['lastname'];
    $language = $user_name['language'];
    $study = $user_name['study'];
    $phonenumber = $user_name['phonenumber'];
    $email = $user_name['email'];
    $birthdate = $user_name['dateofbirth'];
    $navigation = get_navigation($template, '0');
    $display_buttons = get_user_id() == $room_info['room_id'];

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }
    /* Choose Template */
    include use_template('contact');
}

/* Contact Post */
elseif (new_route('/DDWT18/ddwt18_project/contact/', 'post')){
    /* Add room to database */
    $feedback = contact_room($db, $_POST);
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));

}


/* Login GET */
elseif (new_route('/DDWT18/ddwt18_project/login/', 'get')){
    /* Check if the user is logged in */
    if ( check_login() ) {
        redirect('/DDWT18/ddwt18_project/myaccount/');
    }

    /* Page info */
    $page_title = 'Login';
    $navigation = get_navigation($template, 0);

    /* Page content */
    $page_subtitle = 'Use your username and password to login';

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']); }

    /* Choose Template */
    include use_template('login');
}

/* Login POST */
elseif (new_route('/DDWT18/ddwt18_project/login/', 'post')){
    /* Login user */
    $feedback = login_user($db, $_POST);
    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/ddwt18_project/login/?error_msg=%s', json_encode($feedback)));
}

/* Log out GET */
elseif (new_route('/DDWT18/ddwt18_project/logout/', 'get')) {
    /* Get error msg from POST route */
    $feedback = logout_user();
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']); }
    redirect(sprintf('/DDWT18/ddwt18_project/?error_msg=%s', json_encode($feedback)));
}

else {
    http_response_code(404);
}





