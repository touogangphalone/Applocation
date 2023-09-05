<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $user_name = $_POST['user_name'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($user_name) || empty($tel) || empty($email) || empty($password)) {
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Username, tel, email, and password are required"]);
    }
    else if (!preg_match('/^[a-zA-Z0-9_-]+$/', $user_name)) {
        http_response_code(401); // Unauthorized
        echo json_encode(["message" => "valid credentials"]);
    } 
    else if (!preg_match('/[0-9]/', $tel)) {
        http_response_code(401); // Unauthorized
        echo json_encode(["message" => "In credentials"]);
    } 
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(401); // Unauthorized
        echo json_encode(["message" => "Invalid dentials"]);
    } 
    
    else if (!isStrongPassword($password)) {
        http_response_code(401); // Unauthorized
        echo json_encode(["message" => "Invalid cre"]);
    } 
    else
     {
        $query = "INSERT INTO land_lord (user_name, tel, email, password)
                  VALUES ('$user_name', '$tel', '$email', '$password')";
        $result = mysqli_query($con, $query);

        if ($result === true) {
            http_response_code(200);
            echo json_encode(["message" => "Registration successful"]);
        } else {
            http_response_code(401); // Unauthorized
            echo json_encode(["message" => "Registration failed"]);
        }
    }
}

function isStrongPassword($password) {
    // Define password requirements
    $minLength = 8;
    $requiresUppercase = true;
    $requiresLowercase = true;
    $requiresDigit = true;
    $requiresSpecialChar = true;
  
    // Check minimum length
    if (strlen($password) < $minLength) {
        return false;
    }
  
    // Check for uppercase character
    if ($requiresUppercase && !preg_match('/[A-Z]/', $password)) {
        return false;
    }
  
    // Check for lowercase character
    if ($requiresLowercase && !preg_match('/[a-z]/', $password)) {
        return false;
    }
  
    // Check for digit
    if ($requiresDigit && !preg_match('/[0-9]/', $password)) {
        return false;
    }
  
    // Check for special character (you can modify this regex as needed)
    if ($requiresSpecialChar && !preg_match('/[^a-zA-Z0-9]/', $password)) {
        return false;
    }
  
    return true; // Password meets all requirements
}

?>
