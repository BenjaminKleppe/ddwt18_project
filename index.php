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

);

/* Home page */
if (new_route('/DDWT18/ddwt18_project/', 'get')) {
    /* Page info */
    $page_title = 'InterRooms';
    $display_right_nav = get_user_id();
    $navigation = get_navigation($template, '1');
    /* always use template 'footer' */
    $footer = use_template('footer');

    /* Get Number of rooms and users */
    $nbr_rooms = count_rooms($db);
    $nbr_users = count_users($db);

    /* Page content */
    $page_subtitle = 'Rooms, especially for internationals.';
    $page_content = 'This platform is establishing a connection between international students, so that they can live together.';
    include use_template('main');
}

/* Overview page */
if (new_route('/DDWT18/ddwt18_project/overview/', 'get')) {
    /* Page info */
    $page_title = 'Overview';
    $display_right_nav = get_user_id();
    $navigation = get_navigation($template, '2');

    /* Page content */
    $page_subtitle = 'The overview of all rooms available';
    $left_content = get_room_table(get_rooms($db), $db);
    $display_buttons = get_user_id();
    /* always use template 'footer' */
    $footer = use_template('footer');
    $form_action = '/DDWT18/ddwt18_project/results/';
    $submit_btn = "Search";

    /* Get Number of rooms and users */
    $nbr_rooms = count_rooms($db);
    $nbr_users = count_users($db);

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('overview');
}

/* Add room get postal code check */
elseif (new_route('/DDWT18/ddwt18_project/add/', 'get')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/ddwt18_project/login/');
    }
    /* Check if the role is owner */
    if (!check_owner($db)) {
        redirect('/DDWT18/ddwt18_project/myaccount/');
    }

    /* Page info */
    $page_title = 'Add Room';
    $navigation = get_navigation($template, '4');

    /* Page content */
    $page_subtitle = 'Search a new roommate';
    $page_content = 'Fill in the address of your room.';
    $submit_btn = "Check address";
    $form_action = '/DDWT18/ddwt18_project/add2/';

    /* always use template 'footer' */
    $footer = use_template('footer');

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    include use_template('address');
}

/* Add room get after postal code validation */
elseif (new_route('/DDWT18/ddwt18_project/add2/', 'post')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/ddwt18_project/login/');
    }
    /* Check if the role is owner */
    if (!check_owner($db)) {
        redirect('/DDWT18/ddwt18_project/myaccount/');
    }

    /* Postcode API in order to check postcode */
    $postal_code = $_POST['postal_code'];
    $number = $_POST['house_number'];
    $postal_code = str_replace(' ', '', $postal_code);
    $number = str_replace(' ', '', $number);
    $postal_code = strtoupper($postal_code);
    // De headers worden altijd meegestuurd als array
    $headers = array();
    $headers[] = 'X-Api-Key: qKctaMbHlAa04rhML2ZJI8ywYCuWXrUS9P7eev37';
    // De URL naar de API call
    $url = 'https://api.postcodeapi.nu/v2/addresses/?postcode=' . $postal_code . '&number=' . $number;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    // Indien de server geen TLS ondersteunt kun je met
    // onderstaande optie een onveilige verbinding forceren.
    // Meestal is dit probleem te herkennen aan een lege response.
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // De ruwe JSON response
    $response = curl_exec($curl);
    // Gebruik json_decode() om de response naar een PHP array te converteren
    $data = json_decode($response);
    $addressdata = $data->_embedded->addresses[0];
    if ($addressdata)   {
        $city = $addressdata->city->label;
        $street = $addressdata->street;
        $return_data[]= array("city"=>$city,"street"=>$street);
        curl_close($curl);
    }
    else {
        $feedback = [
            'type' => 'success',
            'message' => 'The address you entered is not valid!'
        ];
        redirect('/DDWT18/ddwt18_project/add/');
    }


    /* Page info */
    $page_title = 'Add Room';
    $navigation = get_navigation($template, '4');

    /* Page content */
    $page_subtitle = 'Search a new roommate';
    $page_content = 'Fill in the details of your room.';
    $submit_btn = "Add room";
    $form_action = '/DDWT18/ddwt18_project/add/';
    /* always use template 'footer' */
    $footer = use_template('footer');

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }
    include use_template('new');
}


/* Search room GET */
elseif (new_route('/DDWT18/ddwt18_project/search/', 'get')) {
    /* Check if logged in */
    if (!check_login()) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    /* Page info */
    $page_title = 'Search room';
    $navigation = get_navigation($template, '3');

    /* Page content */
    $page_subtitle = 'Search a room';
    $page_content = 'Fill in what you are looking for.';
    $submit_btn = "Search room";
    $form_action = '/DDWT18/ddwt18_project/results/';
    /* always use template 'footer' */
    $footer = use_template('footer');

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    include use_template('search');
}

/* Add room POST */
elseif (new_route('/DDWT18/ddwt18_project/add/', 'post')) {

    /* Add room to database */
    $feedback = add_room($db, $_POST);
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18/ddwt18_project/add/?error_msg=%s',
        json_encode($feedback)));
}

/* Search room POST */
if (new_route('/DDWT18/ddwt18_project/results/', 'post')) {
    /* Page info */
    $page_title = 'Overview';
    $display_right_nav = get_user_id();
    $navigation = get_navigation($template, '2');

    /* Page content */
    $page_subtitle = 'The overview of all rooms available';
    $page_content = 'On this page you will find all available rooms for internationals.';
    $left_content = get_result_table($db, search_room($db, $_POST));
    $display_buttons = get_user_id();
    /* always use template 'footer' */
    $footer = use_template('footer');
    $form_action = '/DDWT18/ddwt18_project/results/';
    $submit_btn = "Search";

    /* Get Number of rooms and users */
    $nbr_rooms = count_rooms($db);
    $nbr_users = count_users($db);

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']);
    }

    /* Choose Template */
    include use_template('overview');
}

/* Single room */
elseif (new_route('/DDWT18/ddwt18_project/room/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }
    /* Get rooms from db */
    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    $optincheck = optincheck($_SESSION['user_id'], $room_id, $db);
    $owner_info = get_name($db, $room_info['user_id']);
    $display_buttons = get_user_id() == $room_info['user_id'];
    $disp_buttons = get_user_id() != $room_info['user_id'];

    /* Page info */
    $page_title = sprintf("%s %s", $room_info['street'], $room_info['house_number']);
    $navigation = get_navigation($template, '2');

    /* Page content */
    $added_by = $owner_info['firstname']." ".$owner_info['lastname'];
    $page_subtitle = sprintf("Information about %s %s", $room_info['street'], $room_info['house_number']);
    $description = $room_info['description'];
    $type = $room_info['type'];
    $size = $room_info['size'];
    $price = $room_info['price'];
    $tenant = $room_info['tenant'];
    $living = $room_info['living'];
    $kitchen = $room_info['kitchen'];
    $bathroom = $room_info['bathroom'];
    $toilet = $room_info['toilet'];
    $internet = $room_info['internet'];
    $mate = $room_info['mate'];
    $smoke = $room_info['smoke'];
    $address = sprintf("%s %s", $room_info['postal_code'], $room_info['city']);
    $profilepicture = get_profile_image_info($db, $room_info['user_id']);
    $birthdate = $owner_info['dateofbirth'];
    $language = $owner_info['language'];
    $phonenumber = $owner_info['phonenumber'];
    $email = $owner_info['email'];
    $owner = $room_info['user_id'];
    $ownerlink = "/DDWT18/ddwt18_project/user/?user_id=$owner";
    $address_variable = sprintf("%s %s, %s", $room_info['street'], $room_info['house_number'], $room_info['city']);
    $optinusers = get_user_optin_room_table(get_user_optin_info($db, $room_id), $db);
    $imagename = get_image_info($db, $room_id);
    $checkimage = check_image($db, $room_id);
    $checktenant = check_tenant($db);

    /* always use template 'footer' */
    $right_column = use_template('owner_card');
    $footer = use_template('footer');

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }

    /* Choose Template */
    include use_template('room');
}

elseif (new_route('/DDWT18/ddwt18_project/roompics/', 'post')) {
    /* Upload images of the room */
    $feedback = upload_photos($db, $_POST);
    $room_id = $_POST['room_id'];

        /* Redirect to homepage */;
    redirect(sprintf('/DDWT18/ddwt18_project/overview/?error_msg=%s',
        json_encode($feedback)));
}


/* Register GET */
elseif (new_route('/DDWT18/ddwt18_project/register/', 'get')){
    /* Check if the user is logged in */
    if ( check_login() ) {
        redirect('/DDWT18/ddwt18_project/myaccount/');
    }
    /* Page info */
    $form_action = "/DDWT18/ddwt18_project/register/";
    $page_title = 'Register';
    $submit_btn = "Register now";
    $navigation = get_navigation($template, 5);

    /* always use template 'footer' */
    $footer = use_template('footer');

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
elseif (new_route('/DDWT18/ddwt18_project/myaccount/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }
    /* Page info */
    $page_title = 'My Account';
    $navigation = get_navigation($template, 5);
    $page_subtitle = 'Your account details on InterRooms';
    /* Page content */
    $user = $_SESSION['user_id'];
    $display_buttons = get_user_id() == $_SESSION['user_id'];
    $user_name = get_name($db, $_SESSION['user_id']);
    $usern = $user_name['firstname']." ".$user_name['lastname'];
    $user_first = $user_name['firstname'];
    $user_last = $user_name['lastname'];
    $imagename = get_profile_image_info($db, $user);
    $offeredrooms = get_offered_room_table(get_offered_info($db), $db);
    $optinrooms = get_optin_room_table(get_optin_info($db), $db);
    $name = $user_name['firstname']." ".$user_name['lastname'];
    $user_role = $user_name['role'];
    $user_dob = $user_name['dateofbirth'];
    $user_bio = $user_name['biography'];
    $user_study = $user_name['study'];
    $user_language = $user_name['language'];
    $user_mail = $user_name['email'];
    $user_phone = $user_name['phonenumber'];
    $checkprofileimage = check_profile_image($db, $user);
    /* always use template 'footer' */
    $footer = use_template('footer');
    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }
    /* Choose Template */
    include use_template('account');
}

elseif (new_route('/DDWT18/ddwt18_project/userpic/', 'post')) {
    /* Upload images of the room */
    $feedback = upload_userpic($db, $_POST);
    $user_id = $_POST['user_id'];

    /* Redirect to homepage */;
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));
}

/* Remove account */
elseif (new_route('/DDWT18/ddwt18_project/removeaccount/', 'post')){
    /* Remove account in database */
    $user_id = $_POST['user_id'];
    $feedback = remove_account($db);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/ddwt18_project/overview/?error_msg=%s',
        json_encode($feedback)));

    /* Choose Template */
    include use_template('main');
}

/* Contact GET */
elseif (new_route('/DDWT18/ddwt18_project/contact/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    $user_name = get_name($db, $_SESSION['user_id']);
    $owner_name = get_name($db, $room_info['user_id']);
    $owner = $owner_name['firstname']." ".$owner_name['lastname'];
    $address = $room_info['street']." ".$room_info['house_number'];
    $name = $user_name['firstname']." ".$user_name['lastname'];
    $user_role = $user_name['role'];
    $user_dob = $user_name['dateofbirth'];
    $user_bio = $user_name['biography'];
    $user_study = $user_name['study'];
    $user_language = $user_name['language'];
    $user_mail = $user_name['email'];
    $user_phone = $user_name['phonenumber'];
    $navigation = get_navigation($template, '0');
    $display_buttons = get_user_id() == $room_info['room_id'];
    /* always use template 'footer' */
    $footer = use_template('footer');


    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }
    /* Choose Template */
    include use_template('contact');
}

/* Contact Post */
elseif (new_route('/DDWT18/ddwt18_project/contact/', 'post')){
    /* Add room to database */
    $room_id = $_POST['room'];
    $room_info = get_room_info($db, $room_id);
    $feedback = contact_room($db, $_POST);
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));
}

/* Optout Post */
elseif (new_route('/DDWT18/ddwt18_project/optout/', 'post')){
    /* Add room to database */
    $feedback = optout($db);
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));
}

/* User GET */
elseif (new_route('/DDWT18/ddwt18_project/user/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }
    $user = $_GET['user_id'];
    $user_name = get_name($db, $_GET['user_id']);
    $imagename = get_profile_image_info($db, $user);
    $display_buttons = get_user_id() == $_GET['user_id'];
    $name = $user_name['firstname']." ".$user_name['lastname'];
    $user_role = $user_name['role'];
    $user_dob = $user_name['dateofbirth'];
    $user_bio = $user_name['biography'];
    $user_study = $user_name['study'];
    $user_language = $user_name['language'];
    $user_mail = $user_name['email'];
    $user_phone = $user_name['phonenumber'];

    $page_title = "User info";
    $navigation = get_navigation($template, '0');
    /* always use template 'footer' */
    $footer = use_template('footer');


    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) { $error_msg = get_error($_GET['error_msg']); }
    /* Choose Template */
    include use_template('user');
}

/* Remove room */
elseif (new_route('/DDWT18/ddwt18_project/remove/', 'post')){
    /* Remove room in database */
    $room_id = $_POST['room_id'];
    $feedback = remove_room($db, $room_id);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/ddwt18_project/overview/?error_msg=%s',
        json_encode($feedback)));

    /* Choose Template */
    include use_template('main');
}

/* Remove room images */
elseif (new_route('/DDWT18/ddwt18_project/removeimages/', 'post')){
    /* Remove room in database */
    $room_id = $_POST['room_id'];
    $feedback = remove_images($db, $room_id);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/ddwt18_project/overview/?error_msg=%s',
        json_encode($feedback)));

    /* Choose Template */
    include use_template('main');
}

/* Remove profile picture */
elseif (new_route('/DDWT18/ddwt18_project/removeuserpic/', 'post')) {
    /* Remove room in database */
    $user_id = $_POST['user_id'];
    $feedback = remove_userpic($db, $user_id);

    /* Redirect to homepage */
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));

    /* Choose Template */
    include use_template('main');
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
    /* always use template 'footer' */
    $footer = use_template('footer');

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
    redirect(sprintf('/DDWT18/ddwt18_project/login/?error_msg=%s',
        json_encode($feedback)));
}

/* Log out GET */
elseif (new_route('/DDWT18/ddwt18_project/logout/', 'get')) {
    /* Get error msg from POST route */
    $feedback = logout_user();
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']); }
    redirect(sprintf('/DDWT18/ddwt18_project/?error_msg=%s', json_encode($feedback)));
}

/* Edit room GET */
elseif (new_route('/DDWT18/ddwt18_project/edit/', 'get')) {
    /* Check if logged in */
    $user_id = get_user_id();

    /* Get room info from db */
    $room_id = $_GET['room_id'];
    $room_info = get_room_info($db, $room_id);
    if ($room_info['user_id'] != $user_id) {
        redirect('/DDWT18/ddwt18_project/overview/');
    }

    /* Page info */
    $page_title = 'Edit room';
    $navigation = get_navigation($template, '3');

    /* Page content */
    $page_subtitle = sprintf("Edit %s %s", $room_info['street'], $room_info['house_number']);
    $page_content = 'Edit the room below.';
    $submit_btn = "Edit room";
    $form_action = '/DDWT18/ddwt18_project/edit/';
    /* always use template 'footer' */
    $footer = use_template('footer');

    /* Get error msg from POST route */
    if ( isset($_GET['error_msg']) ) {
        $error_msg = get_error($_GET['error_msg']); }

    /* Choose Template */
    include use_template('new');
}

/* Edit room POST */
elseif (new_route('/DDWT18/ddwt18_project/edit/', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    /* Edit room to database */
    $feedback = update_room($db, $_POST);
    $room_id = $_POST['room_id'];
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18/ddwt18_project/room/?room_id='.$room_id.'/?error_msg=%s',
        json_encode($feedback)));

    /* Choose Template */
    include use_template('room');
}


/* Edit details myaccount GET */
elseif (new_route('/DDWT18/ddwt18_project/editdet/', 'get')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    $form_action = "/DDWT18/ddwt18_project/editdet/";
    $owner_info = get_name($db, get_user_id());
    $navigation = get_navigation($template, '4');
    $page_title = 'Edit details';
    $page_subtitle = 'You can edit your details of your myaccount here';
    $submit_btn = "Edit account";
    /* always use template 'footer' */
    $footer = use_template('footer');

    /* Choose Template */
    include use_template('register');
}

/* Edit details myaccount POST */
elseif (new_route('/DDWT18/ddwt18_project/editdet/', 'post')) {
    /* Check if logged in */
    if ( !check_login() ) {
        redirect('/DDWT18/ddwt18_project/login/');
    }

    /* Edit details to database */
    $feedback = edit_details($db, $_POST);
    $user_id = $_POST['id'];
    /* Redirect to room GET route */
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));

    /* Choose Template */
    include use_template('register');
}

elseif (new_route('/DDWT18/ddwt18_project/forgetpassword/', 'get')) {
    $form_action = '/DDWT18/ddwt18_project/forgetpassword/';
    include use_template('forgetpassword');
}

elseif (new_route('/DDWT18/ddwt18_project/forgetpassword/', 'post')) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $code = random_str('alphanum', 8);
    $checkusermail = checkusermail($db, $username, $email);
    $feedback = forgetpassword($db, $username, $email, $code, $checkusermail);
    redirect(sprintf('/DDWT18/ddwt18_project/login/?error_msg=%s',
        json_encode($feedback)));
    redirect('/DDWT18/ddwt18_project/login/');
}


else {
    http_response_code(404);
}



