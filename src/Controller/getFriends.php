<?php
header('Content-Type: application/json');

require_once("./dbConnect.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userId = $_SESSION['user_id'];

// Prepare the SQL query to fetch friends
$query = "
    SELECT 
        user.userId, 
        user.name, 
        user.profileImage, 
        user.status 
    FROM 
        friendList 
    LEFT JOIN 
        user 
    ON 
        (friendList.friend_id = user.userId) 
    WHERE 
        friendList.user_id = $userId 
    ORDER BY 
        user.name;
";

// Execute the query
$result = mysqli_query($conn, $query);

if (!$result) {
    http_response_code(500);
    echo json_encode(["error" => "Failed to execute SQL query: " . mysqli_error($conn)]);
    exit();
}

$results = [];
while ($row = mysqli_fetch_assoc($result)) {
    $friendId = $row['userId'];

    // Prepare SQL query to fetch the last message
    $messQuery = "
        SELECT * FROM messages 
        WHERE (receive_id = $userId AND send_id = $friendId) 
           OR (receive_id = $friendId AND send_id = $userId) 
        ORDER BY messages.message_id DESC 
        LIMIT 1
    ";

    $messResult = mysqli_query($conn, $messQuery);

    if (!$messResult) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to fetch last message: " . mysqli_error($conn)]);
        exit();
    }

    $message = mysqli_fetch_assoc($messResult);

    // Determine the sender's name
    $sendName = ($message && $message["send_id"] == $friendId) ? $row['name'] : "You";

    // Limit the message to 40 characters
    $messageText = $message ? $message['message'] : 'No messages yet';
    $maxLength = 40;  // Set the maximum character length

    if (strlen($messageText) > $maxLength) {
        $messageText = substr($messageText, 0, $maxLength) . '...';
    }

    // Prepare result with message
    $results[] = [
        'userId' => $row['userId'],
        'name' => $row['name'],
        'profileImage' => $row['profileImage'],
        'status' => $row['status'],
        'lastMessage' => $sendName . " : " . $messageText,  // Store the limited message
    ];

    // Free message result
    mysqli_free_result($messResult);
}

// Free resources
mysqli_free_result($result);
mysqli_close($conn);

// Return the results
echo json_encode($results);
?>