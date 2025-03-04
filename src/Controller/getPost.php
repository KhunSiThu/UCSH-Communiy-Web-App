<?php
header("Content-Type: application/json");

require_once("./dbConnect.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];

    $stmt = $conn->prepare("SELECT caption FROM posts WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();

    if ($post) {
        echo json_encode(["success" => true, "caption" => $post["caption"]]);
    } else {
        echo json_encode(["success" => false, "message" => "Post not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
