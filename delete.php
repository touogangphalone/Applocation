<?phpinclude 'config.php';

// Check if the request method is DELETE
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    // Get the username from the query string
    $username = isset($_GET["user_name"]) ? $_GET["user_name"] : null;

    if ($username !== null) {
        // Prepare a SQL query to check if the user with the given username exists
        $checkStmt = $con->prepare("SELECT user_name FROM users WHERE user_name = ?");
        $checkStmt->bind_param("s", $username);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // The user exists, so you can proceed with the delete operation
            $deleteStmt = $con->prepare("DELETE FROM users WHERE user_name = ?");
            $deleteStmt->bind_param("s", $username);

            if ($deleteStmt->execute()) {
                // Respond with a success message
                http_response_code(200); // OK
                echo json_encode(["message" => "User deleted successfully"]);
            } 
            else {
                // Respond with an internal server error
                http_response_code(500); // Internal Server Error
                echo json_encode(["message" => "Failed to delete user"]);
            }
        } 
        else {
            // Respond with a not found error
            http_response_code(404); // Not Found
            echo json_encode(["message" => "User not found"]);
        }

        // Close the statement
        $checkStmt->close();
    }
     else {
        // Respond with a bad request error
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Invalid input"]);
    }
}


else {
    // Respond with a method not allowed error
    http_response_code(405); // Method Not Allowed
    echo json_encode(["message" => "Method not allowed"]);
}
?>
