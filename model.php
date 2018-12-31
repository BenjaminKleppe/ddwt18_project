<?php
/**
 * Model
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
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
function get_navigation($template, $active_id){
    $navigation_exp = '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div><img src="/DDWT18/ddwt18_project/pictures/interroom.png" alt="Logo" width="200" height="50"/></div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">';
    foreach ($template as $id => $info) {
        if ($id == $active_id){
            $navigation_exp .= '<li class="nav-item active">';
            $navigation_exp .= '<a class="nav-link" href="'.$template[$active_id]['url'].'">'.$template[$active_id]['name'].'</a>';
        }else {
            $navigation_exp .= '<li class="nav-item">';
            $navigation_exp .= '<a class="nav-link" href="'.$template[$id]['url'].'">'.$template[$id]['name'].'</a>';
        }

        $navigation_exp .= '</li>';
    }
    $navigation_exp .= '
    </ul>
    </div>
    </nav>';
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

function get_room_table($rooms, $pdo){
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">Photo</th>
        <th scope="col">Address</th>
        <th scope="col">Squere Metre</th>
        <th scope="col">Price</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach($rooms as $key => $value){
        $table_exp .= '
        <tr>
            <th scope="row"></th>
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

// Get's the information of a single room
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

/* checks postal code */
function PostalCheck($postcode)
{
    $upper = strtoupper($postcode);

    if( preg_match("/^\W*[1-9]{1}[0-9]{3}\W*[a-zA-Z]{2}\W*$/",  $upper)) {
        return $upper;
    } else {
        return false;
    }
}

/* add a room to the database */
function add_room($pdo, $room_info){
    /*check if all fields are set */
    if(
        empty($room_info['street']) or
        empty($room_info['house_number']) or
        empty($room_info['postalcode']) or
        empty($room_info['city']) or
        empty($room_info['type']) or
        empty($room_info['price']) or
        empty($room_info['size']) or
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

    /* Check if postal code is entered correctly */
    if (strlen($room_info['postalcode']) !== 6) {
        return [
            'type' => 'danger',
            'message' => 'The postal code consists of exactly 6 characters (1234AB)'
        ];}
    else {
        if (PostalCheck($room_info['postalcode']) == false ){
            return [
                'type' => 'danger',
                'message' => 'You entered an invalid postal code. Please write it like "1234AB"'
            ];
}
    }

    /* Add room */
    $stmt = $pdo->prepare("INSERT INTO room (street, house_number, postal_code, city, type, price, size, description, tenant, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $room_info['street'],
        $room_info['house_number'],
        $room_info['postalcode'],
        $room_info['city'],
        $room_info['type'],
        $room_info['price'],
        $room_info['size'],
        $room_info['description'],
        $room_info['tenant'],
        get_user_id()
    ]);
    $inserted = $stmt->rowCount();
    if ($inserted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room %s %s added to Series Overview.", $room_info['street'], $room_info['house_number'])
        ];
    }
    else {
        return [
            'type' => 'danger',
            'message' => 'There was an error. The room was not added. Try it again.'
        ];
    }

}

/**
 * Count the number of users listed on Series Overview
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

function get_name($pdo, $user) {
    /* Get series */
    $stmt = $pdo->prepare('SELECT username, password, firstname, lastname, dateofbirth, role, biography, study, language, email, phonenumber FROM user WHERE id = ?');
    $stmt->execute([$user]);
    $user_info = $stmt->fetch();
    return $user_info;
}

/* returns first- and lastname, and birth date from owner */
function owner_name($pdo, $user)
{
    /* Get rooms */
    $stmt = $pdo->prepare('SELECT * FROM user WHERE username = ?');
    $stmt->execute([$user]);
    $user_info = $stmt->fetch();
    return $user_info;
}

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


function check_login()
{
    session_start();
    if (isset($_SESSION['user_id'])) {
        return True;
    } else {
        return False;
    }
}

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
            'message' => 'The username you entered does already exist!'
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


function get_user($pdo, $id)
{
    $stmt = $pdo->prepare('SELECT * FROM user WHERE id = ?');
    $stmt->execute([$id]);
    $user_info = $stmt->fetch();
    return $user_info;
}

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

function get_optin_info($pdo) {
    $stmt = $pdo->prepare('SELECT room.* FROM room,optin WHERE room.room_id = optin.room AND optin.tenant = ?');
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
function get_optin_room_table($rooms, $pdo){
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">Photo</th>
        <th scope="col">Address</th>
        <th scope="col">Squere Metre</th>
        <th scope="col">Price</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach($rooms as $key => $value){
        $table_exp .= '
        <tr>
            <th scope="row"></th>
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
function get_offered_room_table($rooms, $pdo){
    $table_exp = '
    <table class="table table-hover">
    <thead
    <tr>
        <th scope="col">Photo</th>
        <th scope="col">Address</th>
        <th scope="col">Squere Metre</th>
        <th scope="col">Price</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>';
    foreach($rooms as $key => $value){
        $table_exp .= '
        <tr>
            <th scope="row"></th>
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
 * Removes a room with a specific series-ID
 * @param object $pdo db object
 * @param int $room_id id of the to be deleted series
 * @return array
 */
function remove_room($pdo, $room_id){

    /* Get series info */
    $room_info = get_room_info($pdo, $room_id);

    /* Delete Serie */
    $stmt = $pdo->prepare("DELETE FROM room WHERE room_id = ?");
    $stmt->execute([$room_id]);
    $deleted = $stmt->rowCount();
    if ($deleted ==  1) {
        return [
            'type' => 'success',
            'message' => sprintf("Room '%s %s' was removed!", $room_info['street'], $room_info['house_number'])
        ];
    }
    else {
        return [
            'type' => 'warning',
            'message' => 'An error occurred. The series was not removed.'
        ];
    }
}

/**
 * Updates a room in the database using post array
 * @param object $pdo db object
 * @param array $room_info post array
 * @return array
 */
function update_serie($pdo, $room_info){
    /* Check if all fields are set */
    if (
        empty($room_info['street']) or
        empty($room_info['house_number']) or
        empty($room_info['postalcode']) or
        empty($room_info['city']) or
        empty($room_info['type']) or
        empty($room_info['price']) or
        empty($room_info['size']) or
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

    /* Check if postal code is entered correctly */
    if (strlen($room_info['postalcode']) !== 6) {
        return [
            'type' => 'danger',
            'message' => 'The postal code consists of exactly 6 characters (1234AB)'
        ];}
    else {
        if (PostalCheck($room_info['postalcode']) == false ){
            return [
                'type' => 'danger',
                'message' => 'You entered an invalid postal code. Please write it like "1234AB"'
            ];
        }
    }

    /* Get current room name */
    $stmt = $pdo->prepare('SELECT * FROM room WHERE room_id = ?');
    $stmt->execute([$room_info['room_id']]);
    $room = $stmt->fetch();
    $current_name = $room['postal_code'];

    /* Check if room already exists */
    $stmt = $pdo->prepare('SELECT * FROM room WHERE postal_code = ?');
    $stmt->execute([$room_info['postalcode']]);
    $room = $stmt->fetch();
    if ($room_info['postalcode'] == $room['postal_code'] and $room['postal_code'] != $current_name){
        return [
            'type' => 'danger',
            'message' => sprintf("The address of the room cannot be changed. %s %s already exists.", $room_info['street'], $room_info['house_number'])
        ];
    }

    /* Update Serie */
    $stmt = $pdo->prepare("UPDATE room SET street = ?, house_number = ?, postal_code = ?, city = ?, type = ?, price = ?, size = ?, description = ?, tenant = ? WHERE room_id = ?");
    $stmt->execute([
        $room_info['street'],
        $room_info['house_number'],
        $room_info['postalcode'],
        $room_info['city'],
        $room_info['type'],
        $room_info['price'],
        $room_info['size'],
        $room_info['description'],
        $room_info['tenant'],
        $room_info['room_id']
    ]);
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

function upload_photos($pdo, $form_data)
{
    $img = $_FILES['image']['name'];

    try {
        $stmt = $pdo->prepare('INSERT INTO roompics (room_id, imagename) VALUES (?, ?)');
        $stmt->execute([$form_data['room_id'], $img]);
        $inserted = $stmt->rowCount();
    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    if ($inserted == 1) {
        move_uploaded_file($_FILES['image']['tmp_name'], "pictures/$img");
        return [
            'type' => 'success',
            'message' => 'Image has been uploaded to folder'
        ];
    } else {
        return [
            'type' => 'danger',
            'message' => 'Image does not upload to folder'
        ];
    }
}

function displayimage($pdo){
    try {
        $stmt = $pdo->prepare('SELECT * FROM roompics');
        $stmt->execute();
        $roompics = $stmt->fetch();
        $pics = Array();
        while($data = $pics){
            echo "<img height='300' width='300'  src='{$data['imagename']}'>";
        }

    } catch (PDOException $e) {
        return [
            'type' => 'danger',
            'message' => sprintf('There was an error: %s', $e->getMessage())
        ];
    }
    }
function remove_account($pdo, $user_id){

    /* Get series info */
    $user_id = get_user_id();
    $account_info = get_user($pdo, $user_id);

    /* Delete Serie */
    $stmt = $pdo->prepare('DELETE FROM room WHERE room.user_id = ?');
    $stmt->execute([$user_id]);
    $stmt = $pdo->prepare('DELETE FROM user WHERE user.id = ?');
    $stmt->execute([$user_id]);
    $stmt = $pdo->prepare('DELETE FROM optin WHERE optin.tenant = ?');
    $stmt->execute([$user_id]);
    $deleted = $stmt->rowCount();
    if ($deleted ==  1) {
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

