<style>
    #add {
        color: white;
        background: #337ab7;
        border-radius: 12px;
        box-shadow: 0 4px 4px 0 rgba(0,0,0,0.2), 0 4px 4px 0 rgba(0,0,0,0.19)
    }

    #add.button:hover{
        background: #2e4960;
    }

    .img-key {
        width: 100%;
        height: 80%;
        background-size: cover;
    }

    .img-prof{
        width: 300px;
        background-size: cover;
    }

    .img-tab {
        width: 110px;
        height: 7%;
        background-size: cover;
    }
</style>


<?php
/**
 * Model
 * User: b.kleppe, t.tan, g.danou, l.janssen
 * Date: 15-12-18
 * Time: 15:30
 */
/* Enable error reporting */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Connects to the database using PDO
 * @param string $host database host
 * @param string $db database name
 * @param string $user database user
 * @param string $pass database password
 * @return pdo object
 */
function connect_db($host, $db, $user, $pass){
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        echo sprintf("Failed to connect. %s",$e->getMessage());
    }
    return $pdo;
}

/**
 * Check if the route exist
 * @param string $route_uri URI to be matched
 * @param string $request_type request method
 * @return bool
 *
 */
function new_route($route_uri, $request_type){
    $route_uri_expl = array_filter(explode('/', $route_uri));
    $current_path_expl = array_filter(explode('/',parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    if ($route_uri_expl == $current_path_expl && $_SERVER['REQUEST_METHOD'] == strtoupper($request_type)) {
        return True;
    }
}

/**
 * Creates a new navigation array item using url and active status
 * @param string $url The url of the navigation item
 * @param bool $active Set the navigation item to active or inactive
 * @return array
 */
function na($url, $active){
    return [$url, $active];
}

/**
 * Creates filename to the template
 * @param string $template filename of the template without extension
 * @return string
 */
function use_template($template){
    $template_doc = sprintf("views/%s.php", $template);
    return $template_doc;
}

/**
 * Creates navigation HTML code using given array
 * @param array $navigation Array with as Key the page name and as Value the corresponding url
 * @return string html code that represents the navigation
 */
function get_navigation($template, $active_id, $pdo){
    $navigation_exp = '
    <div class="container-fluid bg-light bg-clearfix" style="height: 70px">
        <nav class="navbar navbar-static-top navbar-expand-lg navbar-light container">
            <a href="/DDWT18/ddwt18_project/"><img src="/DDWT18/ddwt18_project/pictures/interroom.png" alt="Logo" width="230" height="60"/></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">';
    foreach ($template as $id => $info) {
        if ($id == $active_id) {
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="' . $template[$active_id]['url'] . '">' . $template[$active_id]['name'] . '</a>';
        } else {
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="' . $template[$id]['url'] . '">' . $template[$id]['name'] . '</a>';
            $navigation_exp .= '</li>';
        }
    }

    $navigation_exp .= '
                </ul>
            </div>
            <div>
                <ul class=" navbar-right nav navbar-nav">';
    if (isset($_SESSION['user_id'])) {
        if (check_owner($pdo)) {
            $navigation_exp .= '<li class="pr-4"><a id="add" href="/DDWT18/ddwt18_project/add/" class="button"><span class="glyphicon glyphicon-plus"></span> Add room</a></li>';

        }
        $navigation_exp .= '<li><a href = "/DDWT18/ddwt18_project/myaccount/" ><span class="glyphicon glyphicon-user" ></span > My account</a ></li >';
        $navigation_exp .= '<li><a href = "/DDWT18/ddwt18_project/logout/" ><span class="glyphicon glyphicon-log-out" ></span > Log out</a ></li >';

    }else {
        $navigation_exp .= '<li class="dropdown">
                        <a href="/DDWT18/ddwt18_project/login/" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-log-in" ></span > Log In </a>
                        <ul class="dropdown-menu" >
                            <div class="col-lg-12" style="width:300px">
                                <div class="text-center"><h3><b>Log In</b></h3></div>
                                <form id="ajax-login-form" action="/DDWT18/ddwt18_project/login/" method="POST" role="form" autocomplete="off">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="" autocomplete="off">
                                    </div>

                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password" autocomplete="off">
                                    </div>
                                    <div class="checkbox">
                                        <label><input type="checkbox" name="remember"> Remember me</label>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-xs-5 pull-right">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-success" value="Log In">
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="hide" name="token" id="token" value="a465a2791ae0bae853cf4bf485dbe1b6">
                                </form>
                            </div>
                        </ul>
                    </li>';
        $navigation_exp .= '<li><a href="/DDWT18/ddwt18_project/register/" ><span class="glyphicon glyphicon-edit" ></span> Sign Up</a></li>';
    }
    $navigation_exp .= '
            </div>
        </nav>
    </div>';
    return $navigation_exp;
}

/**
 * Pritty Print Array
 * @param $input
 */
function p_print($input){
    echo '<pre>';
    print_r($input);
    echo '</pre>';
}

/**
 * Creats HTML alert code with information about the success or failure
 * @param bool $type True if success, False if failure
 * @param string $message Error/Success message
 * @return string
 */
function get_error($feedback){
    $feedback = json_decode($feedback, True);
    $error_exp = '
        <div class="alert alert-'.$feedback['type'].'" role="alert">
            '.$feedback['message'].'
        </div>';
    return $error_exp;
}

/**
 * Creates a table for the overview page
 * @param $rooms
 * @param $pdo
 * @return table with photo, street + house number, size and prize
 */
function get_room_table($rooms, $pdo){
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col"></th>
        <th scope="col">Address</th>
        <th scope="col">Square Meter</th>
        <th scope="col">Price</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach($rooms as $key => $value){
        $name = get_image($pdo, $rooms[$key]['room_id']);
        $table_exp .= '
        <tr>
            <th scope="row"><img src="/DDWT18/ddwt18_project/pictures/'.$name.'" class="img-tab"/></th>
            <th scope="row">'.$value['street'].' '.$value['house_number'].'</th>
            <th scope="row">'.$value['size'].'m2</th>
            <th scope="row">€'.$value['price'].',-</th>           
            <td><a href="/DDWT18/ddwt18_project/room/?room_id='.$value['room_id'].'" role="button" class="btn btn-primary">More info</a></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Add serie to the database
 * @param object $pdo db object
 * @return array with all the info from table room, so info of all rooms
 */
function get_rooms($pdo){
    $stmt = $pdo->prepare('SELECT * FROM room');
    $stmt->execute();
    $rooms = $stmt->fetchAll();
    $room_exp = Array();
    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $room_exp;
}

/**
 * Get's the information of a single room
 * @param object $pdo db object
 * @param int $room_id id of the room
 * @return array with all the info of a room
 */
function get_room_info($pdo, $room_id){
    $stmt = $pdo->prepare('SELECT * FROM room WHERE room_id = ?');
    $stmt->execute([$room_id]);
    $room_info = $stmt->fetch();
    $room_info_exp = Array();
    /* Create array with htmlspecialchars */
    foreach ($room_info as $key => $value){
        $room_info_exp[$key] = htmlspecialchars($value);
    }
    return $room_info_exp;
}


/**
 * Performs an postal check
 * @param $postcode string from room_info
 * @return $upper the postalcode in upper
 * @return false if the postalcode is not in the right way written
 */
function PostalCheck($postcode)
{
    $upper = strtoupper($postcode);
    if( preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
        return $upper;
    } else {
        return false;
    }
}

/**
 * Add a room to the database
 * @param object $pdo db object
 * @param array $room_info id of the room
 * @return array with all the info of a room
 */
function add_room($pdo, $room_info){
    /*check if all fields are set */
    if(
        empty($room_info['street']) or
        empty($room_info['house_number']) or
        empty($room_info['postal_code']) or
        empty($room_info['city']) or
        empty($room_info['type']) or
        empty($room_info['price']) or
        empty($room_info['size']) or
        empty($room_info['living']) or
        empty($room_info['kitchen']) or
        empty($room_info['bathroom']) or
        empty($room_info['toilet']) or
        empty($room_info['internet']) or
        empty($room_info['mate']) or
        empty($room_info['smoke']) or
        empty($room_info['description']) or
        empty($room_info['tenant'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in!'
        ];
    }
    /* Check data type */
    if (!is_numeric($room_info['price'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field price.'
        ];
    }
    /* Check data type */
    if (!is_numeric($room_info['size'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field size.'
        ];
    }
    /* Add room */
    $stmt = $pdo->prepare("INSERT INTO room (street, house_number, postal_code, city, type, price, size, living, kitchen, bathroom, toilet, internet, mate, smoke, description, tenant, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $room_info['street'],
        $room_info['house_number'],
        $room_info['postal_code'],
        $room_info['city'],
        $room_info['type'],
        $room_info['price'],
        $room_info['size'],
        $room_info['living'],
        $room_info['kitchen'],
        $room_info['bathroom'],
        $room_info['toilet'],
        $room_info['internet'],
        $room_info['mate'],
        $room_info['smoke'],
        $room_info['description'],
        $room_info['tenant'],
        get_user_id()
    ]);
    /* Checks if the values are given correctly to the db */
    $inserted = $stmt->rowCount();
    if ($inserted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room %s %s added to room overview.", $room_info['street'], $room_info['house_number'])
        ];
    }

    /* Gives correct corresponding error code */
    else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The room was not added. Try it again.'
        ];
    }
}

/**
 * Count the number of users listed on room overview
 * @param object $pdo database object
 * @return mixed
 */
function count_users($pdo){
    /* Get rooms */
    $stmt = $pdo->prepare('SELECT * FROM user');
    $stmt->execute();
    $rooms = $stmt->rowCount();
    return $rooms;
}

/**
 * Count the number of rooms listed on room Overview
 * @param object $pdo database object
 * @return mixed
 */
function count_rooms($pdo){
    /* Get rooms */
    $stmt = $pdo->prepare('SELECT * FROM room');
    $stmt->execute();
    $rooms = $stmt->rowCount();
    return $rooms;
}

/**
 * Changes the HTTP Header to a given location
 * @param string $location location to be redirected to
 */
function redirect($location){
    header(sprintf('Location: %s', $location));
    die();
}

/**
 * Get current user id
 * @return bool current user id or False if not logged in
 */
function get_user_id(){
    if (!isset($_SESSION)) {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return False;
        }}
    else{
        if (isset($_SESSION['user_id'])) {
            return $_SESSION['user_id'];
        } else {
            return False;
        }
    }
}

/**
 * Obtains the info of the user
 * @param object $pdo db object
 * @param string $user id of the room
 * @return array with all the info of a user
 */
function get_name($pdo, $user) {
    /* Get rooms */
    $stmt = $pdo->prepare('SELECT username, password, firstname, lastname, dateofbirth, role, biography, study, language, email, phonenumber FROM user WHERE id = ?');
    $stmt->execute([$user]);
    $user_info = $stmt->fetch();
    return $user_info;
}

/**
 * Obtains the info of the image from a room
 * @param object $pdo db object
 * @param int $room_id of the room
 * @return array with the imagename of the room
 */
function get_image($pdo, $room_id)
{
    /* Get image */
    $stmt = $pdo->prepare('SELECT imagename FROM roompics WHERE room_id = ?');
    $stmt->execute([$room_id]);
    $rooms = $stmt->fetch();
    return $rooms['imagename'];
}

/**
 * This function will login the user
 * @param object $pdo db object
 * @param array $form_data data from the form
 * @param int $room_id of the room
 * @return array error message if the user is logged in or not
 */
function login_user($pdo, $form_data)
{
    /* Check if all fields are set */
    if (
        empty($form_data['username']) or
        empty($form_data['password'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should enter a username and password.'
        ];
    }
    /* Check if user exists */
    try {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
        $stmt->execute([$form_data['username']]);
        $user_info = $stmt->fetch();
    } catch (\PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    /* Return error message for wrong username */
    if (empty($user_info)) {
        return [
            'type' => 'danger',
            'message' => 'The username you entered does not exist!'
        ];
    }
    /* Check password */
    if (!password_verify($form_data['password'], $user_info['password'])) {
        return [
            'type' => 'danger',
            'message' => 'The password you entered is incorrect!'
        ];
    } else {
        session_start();
        $_SESSION['user_id'] = $user_info['id'];
        $feedback = [
            'type' => 'success',
            'message' => sprintf('%s, you were logged in successfully!',
                get_name($pdo, $_SESSION['user_id'])['firstname'] . " " . get_name($pdo, $_SESSION['user_id'])['lastname'])
        ];
        redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
            json_encode($feedback)));
    }
}

/**
 * Checks if the user is logged in
 * @return bool True or false if the user is logged in or not
 */
function check_login()
{
    session_start();
    if (isset($_SESSION['user_id'])) {
        return True;
    } else {
        return False;
    }
}

/**
 * Checks if the user is logged in
 * @return array with error message if the user is logged out or not
 */
function logout_user(){
    session_start();
    if (session_destroy()){
        return [
            'type' => 'success',
            'message' => 'You were logged out successfully!'];}
    else{
        return [
            'type' => 'danger',
            'message' => 'You are not logged out!'
        ];
    }
}

/**
 * This function will register a new user
 * @param object $pdo db object
 * @param array $form_data data from the form
 * @return array error message if the user registered or not
 */
function register_user($pdo, $form_data)
{
    /* Check if all fields are set */
    if (
        empty($form_data['username']) or
        empty($form_data['password']) or
        empty($form_data['firstname']) or
        empty($form_data['lastname']) or
        empty($form_data['role']) or
        empty($form_data['dateofbirth']) or
        empty($form_data['study']) or
        empty($form_data['language']) or
        empty($form_data['email']) or
        empty($form_data['phonenumber']) or
        empty($form_data['biography'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should fill in everything.'
        ];
    }
    /* Check if user already exists */
    try {
        $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
        $stmt->execute([$form_data['username']]);
        $user_exists = $stmt->rowCount();
    } catch (\PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    /* Return error message for existing username */
    if (!empty($user_exists)) {
        return [
            'type' => 'danger',
            'message' => 'The username you entered already exists!'
        ];
    }
    /* Hash password */
    $password = password_hash($form_data['password'], PASSWORD_DEFAULT);

    /* Save user to the database */
    try {
        $stmt = $pdo->prepare('INSERT INTO user (username, password, firstname,
lastname, role, dateofbirth, study, language, email, phonenumber, biography) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$form_data['username'], $password, $form_data['firstname'],
            $form_data['lastname'], $form_data['role'], $form_data['dateofbirth'], $form_data['study'],$form_data['language'],$form_data['email'],$form_data['phonenumber'],$form_data['biography']]);
        $user_id = $pdo->lastInsertId();
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    /* Login user and redirect */
    session_start();
    $_SESSION['user_id'] = $user_id;
    $feedback = [
        'type' => 'success',
        'message' => sprintf('%s, your account was successfully
created!', get_name($pdo, $_SESSION['user_id'])['firstname']." ".get_name($pdo, $_SESSION['user_id'])['lastname'])
    ];
    redirect(sprintf('/DDWT18/ddwt18_project/myaccount/?error_msg=%s',
        json_encode($feedback)));
}

/**
 * This function will register a new user
 * @param object $pdo db object
 * @param int $id id from the user
 * @return array with the info from the user
 */
function get_user($pdo, $id)
{
    $stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?');
    $stmt->execute([$id]);
    $user_info = $stmt->fetch();
    return $user_info;
}

/**
 * Allows the user to send an optin message and optin to a room
 * @param object $pdo db object
 * @param array $form_data data from the form
 * @return array error message if the message has been sent or not
 */
function contact_room($pdo, $form_data)
{
    /* Check if all fields are set */
    if (
    empty($form_data['message'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'You should fill in a message.'
        ];
    }
    /* Check if user already exists */
    try {
        $stmt = $pdo->prepare('SELECT tenant FROM optin WHERE room = ? AND tenant = ?');
        $stmt->execute([$form_data['room_id'], get_user_id()]);
        $user_exists = $stmt->rowCount();
    } catch (\PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    /* Return error message for existing username */
    if (!empty($user_exists)) {
        return [
            'type' => 'danger',
            'message' => 'You have already opt-in for this room!'
        ];
    }
    try {
        $stmt = $pdo->prepare('INSERT INTO optin (room, tenant, message) VALUES (?, ?, ?)');
        $stmt->execute([$form_data['room_id'], get_user_id(), $form_data['message']]);
        $inserted = $stmt->rowCount();
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    if ($inserted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Your opt-in has been sent")
        ];
    }
}

/**
 * Obtains the info from an image and prints it in the room
 * @param object $pdo db object
 * @param int $room_id id of the room for the image
 * @return array with the photo's of the room
 */
function get_image_info($pdo, $room_id) {
    $stmt = $pdo->prepare('SELECT imagename FROM roompics WHERE room_id = ?');
    $stmt->execute([$room_id]);
    $rooms = $stmt->fetchAll();
    $room_exp = Array();
    $pictures = Array();
    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key] = htmlspecialchars($user_input);
            $key = $room_exp[$key];
            $pictures[$key] = "<img src='/DDWT18/ddwt18_project/pictures/$key' alt='No photo' class='img-key mySlides'/>";
        }
    }
    return $pictures;
}

/**
 * Obtains the info from a profile image for myaccount
 * @param object $pdo db object
 * @param int $user_id id of the user for the image
 * @return array with the profile image of the user
 */
function get_profile_image_info($pdo, $user_id) {
    $stmt = $pdo->prepare('SELECT image FROM user WHERE id = ?');
    $stmt->execute([$user_id]);
    $rooms = $stmt->fetchAll();
    $room_exp = Array();
    $pictures = Array();
    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key] = htmlspecialchars($user_input);
            $key = $room_exp[$key];
            $pictures[$key] = "<img src='/DDWT18/ddwt18_project/pictures/$key' alt='No profile picture added' class='img-prof center'/>";
        }
    }
    return $pictures;
}

/**
 * Obtains the optin-info from an optin
 * @param object $pdo db object
 * @return array with the info of the optin
 */
function get_optin_info($pdo) {
    $stmt = $pdo->prepare('SELECT optin.tenant, room.room_id, user.firstname, user.lastname, room.street, room.house_number, room.size, room.price, optin.message FROM room,optin, user WHERE room.room_id = optin.room AND optin.tenant = user.id AND optin.tenant = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $rooms = $stmt->fetchAll();
    $room_exp = Array();
    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $room_exp;
}

/**
 * Obtains the optin-info for the user
 * @param object $pdo db object
 * @param int $roomid id of the room for the image
 * @return array with the info of the user
 */
function get_user_optin_info($pdo, $roomid) {
    $stmt = $pdo->prepare('SELECT optin.message, user.firstname, user.lastname, user.id FROM user, optin WHERE optin.tenant = user.id and optin.room = ?');
    $stmt->execute([$roomid]);
    $rooms = $stmt->fetchAll();
    $room_exp = Array();
    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $room_exp;
}

/**
 * Creates a table with info of the user and message
 * @param object $pdo db object
 * @param int $room_id id of the room for the image
 * @return string with the table of the optin
 */
function get_user_optin_room_table($optin, $pdo){
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">User</th>
        <th scope="col">Message</th>
    </tr>
    </thead>
    <tbody>';
    /* Create array with name and message */
    foreach($optin as $key => $value){
        $table_exp .= '
        <tr>
            <th scope="row">'.$value['firstname'].' '.$value['lastname'].'</th>
            <th scope="row">'.$value['message'].'</th>       
            <td><a href="/DDWT18/ddwt18_project/user/?user_id='.$value['id'].'" role="button" class="btn btn-primary">User info</a></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Creates a table with info of the room
 * @param array $rooms with the values from a room
 * @return string with the table of the optin
 */
function get_optin_room_table($rooms){
    $table_exp = '
    <table class="table table-hover">
    <thead>
    <tr>
        <th scope="col">Address</th>
        <th scope="col">Squere Metre</th>
        <th scope="col">Price</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    /* Create array with street + house number, size and price */
    foreach($rooms as $key => $value){
        $table_exp .= '
        <tr>
            <th scope="row">'.$value['street'].' '.$value['house_number'].'</th>
            <th scope="row">'.$value['size'].'m2</th>
            <th scope="row">€'.$value['price'].',-</th>           
            <td><a href="/DDWT18/ddwt18_project/room/?room_id='.$value['room_id'].'" role="button" class="btn btn-primary">More info</a></td>
            <td><form action="/DDWT18/ddwt18_project/optout/" method="POST">
                                <a onclick="return confirm(\'Do you want to delete your opt-in?\')"><button type="submit" class="btn btn-danger">Opt out</button></a>
                        </form></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Obtains the info of the offered rooms from the owner
 * @param object $pdo db object
 * @return array with the info of the offered rooms
 */
function get_offered_info($pdo) {
    $stmt = $pdo->prepare('SELECT * FROM room WHERE user_id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    $rooms = $stmt->fetchAll();
    $room_exp = Array();
    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value){
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $room_exp;
}

/**
 * Creates a table with info of the offered rooms
 * @param array $rooms with the values from a room
 * @param object $pdo db object
 * @return string with the table of the offered rooms
 */
function get_offered_room_table($rooms, $pdo){
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col"></th>
        <th scope="col">Address</th>
        <th scope="col">Squere Metre</th>
        <th scope="col">Price</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    /* Create array with picture, street + house number, size and price */
    foreach($rooms as $key => $value){
        $name = get_image($pdo, $rooms[$key]['room_id']);
        $table_exp .= '
        <tr>
            <th scope="row"><img src="/DDWT18/ddwt18_project/pictures/'.$name.'" class="img-tab"/></th>
            <th scope="row">'.$value['street'].' '.$value['house_number'].'</th>
            <th scope="row">'.$value['size'].'m2</th>
            <th scope="row">€'.$value['price'].',-</th>           
            <td><a href="/DDWT18/ddwt18_project/room/?room_id='.$value['room_id'].'" role="button" class="btn btn-primary">More info</a></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    return $table_exp;
}

/**
 * Removes a room with a specific room-ID
 * @param object $pdo db object
 * @param int $room_id id of the to be deleted rooms
 * @return array
 */
function remove_room($pdo, $room_id){
    /* Get room info */
    $room_info = get_room_info($pdo, $room_id);
    /* Delete room */
    $stmt = $pdo->prepare("DELETE FROM room WHERE room_id = ?");
    $stmt->execute([$room_id]);
    $deleted = $stmt->rowCount();
    /* Checks if the room is deleted from the db */
    if ($deleted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room '%s %s' was removed!", $room_info['street'], $room_info['house_number'])
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The room was not removed.'
        ];
    }
}

/**
 * Remove images with a specific room-ID
 * @param object $pdo db object
 * @param int $room_id id of the to be deleted images
 * @return array
 */
function remove_images($pdo, $room_id){
    /* Delete images */
    $stmt = $pdo->prepare("DELETE FROM roompics WHERE room_id = ?");
    $stmt->execute([$room_id]);
    $deleted = $stmt->rowCount();
    /* Checks if the images are deleted from the db */
    if ($deleted >=  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Images were removed!")
        ];
    }
    /* Else gives the corresponding error message */
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The images were not removed.'
        ];
    }
}

/**
 * Remove images with a specific room-ID
 * @param object $pdo db object
 * @param int $user_id id of the user
 * @return array
 */
function remove_userpic($pdo, $user_id){
    /* Delete images */
    $stmt = $pdo->prepare("UPDATE user SET image = null WHERE id = ?");
    $stmt->execute([$user_id]);
    $deleted = $stmt->rowCount();
    /* Checks if the image is deleted from the db */
    if ($deleted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Profile picture was removed!")
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The profile picture was not removed.'
        ];
    }
}

/**
 * Updates a room in the database using post array
 * @param object $pdo db object
 * @param array $room_info post array
 * @return array with an error message if it is succesfully edited or not
 */
function update_room($pdo, $room_info){
    /* Check if all fields are set */
    if (
        empty($room_info['street']) or
        empty($room_info['house_number']) or
        empty($room_info['postal_code']) or
        empty($room_info['city']) or
        empty($room_info['type']) or
        empty($room_info['price']) or
        empty($room_info['size']) or
        empty($room_info['living']) or
        empty($room_info['kitchen']) or
        empty($room_info['bathroom']) or
        empty($room_info['toilet']) or
        empty($room_info['internet']) or
        empty($room_info['mate']) or
        empty($room_info['smoke']) or
        empty($room_info['description']) or
        empty($room_info['tenant']) or
        empty($room_info['room_id'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }
    /* Check data type */
    if (!is_numeric($room_info['price'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field price.'
        ];
    }
    /* Check data type */
    if (!is_numeric($room_info['size'])) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. You should enter a number in the field size.'
        ];
    }
    /* Get current room name */
    $stmt = $pdo->prepare('SELECT * FROM room WHERE room_id = ?');
    $stmt->execute([$room_info['room_id']]);
    $room = $stmt->fetch();
    $current_name = $room['street'];
    /* Check if room already exists */
    $stmt = $pdo->prepare('SELECT * FROM room WHERE street = ?');
    $stmt->execute([$room_info['street']]);
    $room = $stmt->fetch();
    if ($room_info['street'] == $room['street'] and $room['street'] != $current_name){
        return [
            'type' => 'danger',
            'message' => sprintf("The address of the room cannot be changed. %s %s already exists.", $room_info['street'], $room_info['house_number'])
        ];
    }
    /* Update room */
    $stmt = $pdo->prepare("UPDATE room SET street = ?, house_number = ?, postal_code = ?, city = ?, type = ?, price = ?, size = ?, living = ?, kitchen = ?, bathroom = ?, toilet = ?, internet = ?, mate = ?, smoke = ?, description = ?, tenant = ? WHERE room_id = ?");
    $stmt->execute([
        $room_info['street'],
        $room_info['house_number'],
        $room_info['postal_code'],
        $room_info['city'],
        $room_info['type'],
        $room_info['price'],
        $room_info['size'],
        $room_info['living'],
        $room_info['kitchen'],
        $room_info['bathroom'],
        $room_info['toilet'],
        $room_info['internet'],
        $room_info['mate'],
        $room_info['smoke'],
        $room_info['description'],
        $room_info['tenant'],
        $room_info['room_id']
    ]);
    /* Check if values are given through correctly to the database */
    $updated = $stmt->rowCount();
    if ($updated ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room '%s %s' was edited!", $room_info['street'], $room_info['house_number'])
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'The room was not edited. No changes were detected'
        ];
    }
}
/**
 * Updates a user in the database using post array
 * @param object $pdo db object
 * @param array $user_info post array
 * @return array with the details of the user
 */
function edit_details($pdo, $owner_info){
    /* Check if all fields are set */
    if (
        empty($owner_info['username']) or
        empty($owner_info['password']) or
        empty($owner_info['firstname']) or
        empty($owner_info['lastname']) or
        empty($owner_info['dateofbirth']) or
        empty($owner_info['study']) or
        empty($owner_info['language']) or
        empty($owner_info['email']) or
        empty($owner_info['biography']) or
        empty($owner_info['phonenumber']) or
        empty($owner_info['id'])
    ) {
        return [
            'type' => 'danger',
            'message' => 'There was an error. Not all fields were filled in.'
        ];
    }
    /* Get current user name */
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->execute([$owner_info['username']]);
    $user = $stmt->fetch();
    $current_name = $user['username'];
    /* Check if user already exists */
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->execute([$owner_info['username']]);
    $user = $stmt->fetch();
    if ($owner_info['username'] == $user['username'] and $user['username'] != $current_name){
        return [
            'type' => 'danger',
            'message' => 'The username cannot be changed'
        ];
    }
    /* Hash password */
    $password = password_hash($owner_info['password'], PASSWORD_DEFAULT);
    /* Update user */
    $stmt = $pdo->prepare("UPDATE user SET username = ?, password = ?, firstname = ?, lastname = ?, dateofbirth = ?, study = ?, language = ?, email = ?, biography = ?, phonenumber = ? WHERE id = ?");
    $stmt->execute([
        $owner_info['username'],
        $password,
        $owner_info['firstname'],
        $owner_info['lastname'],
        $owner_info['dateofbirth'],
        $owner_info['study'],
        $owner_info['language'],
        $owner_info['email'],
        $owner_info['biography'],
        $owner_info['phonenumber'],
        $owner_info['id']
    ]);
    /* Check if the data was executed */
    $updated = $stmt->rowCount();
    if ($updated ==  1) {
        return [
            'type' => 'success',
            'message' => 'User details are edited!'
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'The user details are not edited. No changes were detected'
        ];
    }
}

/**
 * Allows the owner to upload photos
 * @param object $pdo db object
 * @param array $form_data data from the form
 * @return array error message if the photo was uploaded or not
 */
function upload_photos($pdo, $form_data) {
    $img = $_FILES['image']['name'];
    try {
        /* try to insert with room_id */
        $stmt = $pdo->prepare('INSERT INTO roompics (room_id, imagename) VALUES (?, ?)');
        $stmt->execute([$form_data['room_id'], $img]);
        $inserted = $stmt->rowCount();
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    /* if added to the database, return succes, else false */
    if ($inserted == 1) {
        move_uploaded_file($_FILES['image']['tmp_name'], "pictures/$img");
        return [
            'type' => 'success',
            'message' => 'Image has been uploaded!'
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'Image has not been uploaded.'
        ];
    }
}

/**
 * Allows the owner to upload a profile photo
 * @param object $pdo db object
 * @param array $form_data data from the form
 * @return array error message if the photo was uploaded or not
 */
function upload_userpic($pdo, $form_data) {
    $img = $_FILES['image']['name'];
    try {
        /* try to insert with room_id */
        $stmt = $pdo->prepare('UPDATE user SET image = ? WHERE id = ? ');
        $stmt->execute([$img, $form_data['user_id']]);
        $inserted = $stmt->rowCount();
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    /* if added to the database, return succes, else false */
    if ($inserted == 1) {
        move_uploaded_file($_FILES['image']['tmp_name'], "pictures/$img");
        return [
            'type' => 'success',
            'message' => 'Image has been uploaded!'
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'Image has not been uploaded.'
        ];
    }
}

/**
 * Allows the user to optout of a room
 * @param object $pdo db object
 * @return array error message if the optin was removed or not
 */
function optout($pdo){
    /* get user info */
    $user_id = get_user_id();
    $stmt = $pdo->prepare('DELETE FROM optin WHERE optin.tenant = ?');
    $stmt->execute([$user_id]);
    $deletedoptin = $stmt->rowCount();
    if ($deletedoptin == 1) {
        return [
            'type' => 'success',
            'message' => 'Your opt-in has been removed!'
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The user was not removed.'
        ];
    }
}

/**
 * Allows the user to delete all the info with his id
 * @param object $pdo db object
 * @return array error message if the user was removed or not
 */
function remove_account($pdo){
    /* Get room info */
    $user_id = get_user_id();
    $account_info = get_user($pdo, $user_id);
    /* Delete room */
    $stmt = $pdo->prepare('DELETE FROM room WHERE room.user_id = ?');
    $stmt->execute([$user_id]);
    $deletedroom = $stmt->rowCount();
    $stmt = $pdo->prepare('DELETE FROM user WHERE user.id = ?');
    $stmt->execute([$user_id]);
    $deleteduser = $stmt->rowCount();
    $stmt = $pdo->prepare('DELETE FROM optin WHERE optin.tenant = ?');
    $stmt->execute([$user_id]);
    $deletedoptin = $stmt->rowCount();
    /* check if the row which is affected is removed, return true or false with corresponding error */
    if ($deletedroom == 1 or $deleteduser == 1 or $deletedoptin == 1) {
        session_destroy();
        return [
            'type' => 'success',
            'message' => sprintf("User '%s' was removed!", $account_info['username'])
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The user was not removed.'
        ];
    }
}

/**
 * Checks if the user is an owner in order to add a room
 * @param object $pdo db object
 * @return bool True or false
 */
function check_owner($pdo){
    /* get user information */
    $user_id = get_user_id();
    /* get role from user */
    $stmt = $pdo->prepare('SELECT role FROM user WHERE id = ?');
    $stmt->execute([$user_id]);
    $array_role = $stmt->fetch();
    $role = $array_role['role'];
    if ($role == 'Owner') {
        return True;
    }
    else {
        return False;
    }
}

/**
 * Checks if the room has images
 * @param object $pdo db object
 * @param  int $room_id id of the room
 * @return bool True or false
 */
function check_image($pdo, $room_id){
    $stmt = $pdo->prepare('SELECT room_id FROM roompics WHERE room_id = ?');
    $stmt->execute([$room_id]);
    $role = $stmt->rowCount();
    if ($role >= 1) {
        return True;
    }
    else {
        return False;
    }
}

/**
 * Checks if the profile has a profile picture
 * @param object $pdo db object
 * @param  int $user_id id of the user
 * @return bool True or false
 */
function check_profile_image($pdo, $user_id){
    $stmt = $pdo->prepare('SELECT image FROM user WHERE id = ?');
    $stmt->execute([$user_id]);
    $array_role = $stmt->fetch();
    $role = $array_role['image'];
    if ($role == null) {
        return False;
    }
    else {
        return True;
    }
}

/**
 * Allows the user to search for specific specifications
 * @param object $pdo db object
 * @param array $room_info with the info from the room
 * @return array with all the info of the specific rooms
 */
function search_room($pdo, $room_info) {
    $stmt = $pdo->prepare("SELECT * FROM room WHERE size >= ? AND price <= ?");
    $stmt->execute(
        [
            $room_info['size'],
            $room_info['price']
        ]);
    $rooms = $stmt->fetchAll();
    $room_exp = Array();
    /* Create array with htmlspecialchars */
    foreach ($rooms as $key => $value) {
        foreach ($value as $user_key => $user_input) {
            $room_exp[$key][$user_key] = htmlspecialchars($user_input);
        }
    }
    return $room_exp;
}

/**
 * If someone searched for rooms, this is the result table
 * @param object $pdo db object
 * @param array $room_info with the info from the room
 * @return string with the result table
 */
function get_result_table($pdo, $room_info) {
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col"></th>
        <th scope="col">Address</th>
        <th scope="col">Square Meter</th>
        <th scope="col">Price</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    /* Create table with image, street + house number, size and price */
    foreach($room_info as $key => $value){
        $name = get_image($pdo, $room_info[$key]['room_id']);
        $table_exp .= '
        <tr>
            <th scope="row"><img src="/DDWT18/ddwt18_project/pictures/'.$name.'" width="100px" height="7%" /></th>
            <th scope="row">'.$value['street'].' '.$value['house_number'].'</th>
            <th scope="row">'.$value['size'].'m2</th>
            <th scope="row">€'.$value['price'].',-</th>           
            <td><a href="/DDWT18/ddwt18_project/room/?room_id='.$value['room_id'].'" role="button" class="btn btn-primary">More info</a></td>
        </tr>
        ';
    }
    $table_exp .= '
    </tbody>
    </table>
    ';
    /* Return formatted table */
    return $table_exp;
}

/**
 * Generate and return a random characters string
 * Useful for generating passwords or hashes.
 * The default string returned is 8 alphanumeric characters string.
 * The type of string returned can be changed with the "type" parameter.
 * Seven types are - by default - available: basic, alpha, alphanum, num, nozero, unique and md5.
 *
 * @param   string  $type    Type of random string.  basic, alpha, alphanum, num, nozero, unique and md5.
 * @param   integer $length  Length of the string to be generated, Default: 8 characters long.
 * @return  string
 */
function random_str($type = 'alphanum', $length = 8)
{
    switch($type)
    {
        case 'basic'    : return mt_rand();
            break;
        case 'alpha'    :
        case 'alphanum' :
        case 'num'      :
        case 'nozero'   :
            $seedings             = array();
            $seedings['alpha']    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $seedings['alphanum'] = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $seedings['num']      = '0123456789';
            $seedings['nozero']   = '123456789';
            $pool = $seedings[$type];
            $str = '';
            for ($i=0; $i < $length; $i++)
            {
                $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
            }
            return $str;
            break;
        case 'unique'   :
        case 'md5'      :
            return md5(uniqid(mt_rand()));
            break;
    }
}

/**
 * Checks if the email of the user is right
 * @param object $pdo db object
 * @param array $username of the user
 * @param array $email of the user
 * @return bool True or false
 */
function checkusermail($pdo, $username, $email) {
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ? AND email = ?');
    $stmt->execute([$username, $email]);
    $users = $stmt->rowCount();
    if ($users == 1) {
        return True;
    }
    else {
        return False;
    }
}

/**
 * Checks if the email of the user is right
 * @param object $pdo db object
 * @param array $username of the user
 * @param string $email of the user
 * @param string $code with the new password
 * @param string $check checks if the email was sent
 * @return array with an error message
 */
function forgetpassword($pdo, $username, $email, $code, $check)
{
    $to = $email;
    $subject = "Password code";
    $txt = "Hello". $username .". Your code is". $code . ". Log in with this code to change your password.";
    mail($to,$subject,$txt);
    /* Put code as password in database */
    $password = password_hash($code, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE user SET password = ? WHERE username = ?");
    $stmt->execute([$password, $username]);
    /* Feedback */
    if ($check){
        return [
            'type' => 'success',
            'message' => 'An email is sent with a code. Log in with this code to change your password.'];}
    else{
        return [
            'type' => 'danger',
            'message' => 'Incorrect username or email.'
        ];
    }
}

/**
 * Obtains the info from the optin
 * @param object $pdo db object
 * @param int $room with the id of the room
 * @param int $user with the id of the user
 * @return bool True or false
 */
function optincheck($user, $room, $pdo) {
    $stmt = $pdo->prepare('SELECT * FROM optin WHERE tenant = ? AND room = ?');
    $stmt->execute([$user, $room]);
    $optin = $stmt->rowCount();
    if ($optin == 1) {
        return True;
    }
    else {
        return False;
    }
}