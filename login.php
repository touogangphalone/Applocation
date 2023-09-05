<?php
include 'config.php';

$validUsername = 'user_name'; // Set a valid username
$validPassword = 'password'; // Set a valid password

 
 // Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request body
    $jsonData = file_get_contents('php://input');

    // Decode the JSON data to an associative array
    $data = json_decode($jsonData, true);

    // Check if the 'username' and 'password' fields are present
    if (isset($data['username']) && isset($data['password'])) {
        $username = $data['username'];
        $password = $data['password'];

        // Perform any necessary validation or processing with the username and password
   
        // Check if the provided credentials match the valid ones
        if ($username == $validUsername && $password == $validPassword) {
            http_response_code(200); // OK
            echo json_encode(["message" => "Login successful"]);
        }
         else if (empty($username) || empty($password)) {
            http_response_code(405); // Method Not Allowed
            echo json_encode(["message" => "Username and password cannot be empty"]);
        } 
    }
    else {
        http_response_code(401); // Unauthorized
        echo json_encode(["message" => "Credentials do not exist"]);
    }

    }

else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed"]);
}

?>
