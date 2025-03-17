<?php
header("Access-Control-Allow-Origin: *");  // Allow requests from any origin
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(200);
    exit();
}

// Read JSON data from request body
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON data received."]);
    exit();
}

// Extract values safely
$name = isset($data["Name"]) ? trim($data["Name"]) : "";
$phone = isset($data["Phone"]) ? trim($data["Phone"]) : "";
$email = isset($data["Mail"]) ? trim($data["Mail"]) : "";
$event = isset($data["Events"]) ? trim($data["Events"]) : "";
$location = isset($data["Location"]) ? trim($data["Location"]) : "";
$date = isset($data["Date"]) ? trim($data["Date"]) : "";
$time = isset($data["Time"]) ? trim($data["Time"]) : "";

// Validate required fields
if (empty($email) || empty($location)) {
    echo json_encode(["status" => "error", "message" => "Location and Email are required."]);
    exit();
}

// SUCCESS RESPONSE (replace with actual DB insert if needed)
echo json_encode([
    "status" => "success",
    "message" => "Data received successfully.",
    "data" => $data
]);
?>
