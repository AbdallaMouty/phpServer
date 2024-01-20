<?php
// required headers

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Max-Age: 3600');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With');

// get posted data
$data = json_decode(file_get_contents('php://input'));

// set product property values
$username = $data->username;
$password = base64_encode($data->password);

// prepare the SQL statement
$stmt = $db->prepare('SELECT * FROM users WHERE name = :username AND password = :password');

// bind the username and password parameters
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);

// execute the statement
$result = $stmt->execute();

// fetch the result
$user = $result->fetchArray(PDO::FETCH_ASSOC);

// check if the user exists
if ($user) {
    // the user exists
    echo json_encode(array('status' => 'success', 'message' => 'Login successful'));
} else {
    // the user does not exist
    echo json_encode(array('status' => 'error', 'message' => 'Invalid username or password'));
}
