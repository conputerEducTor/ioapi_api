<?php 
#<!-- This is protected route. Accessed by only loggged in users -->
include_once '..//auth-file/config/cors.php';
include_once '..//auth-file/config/Database.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

include_once 'config/cors.php';

// get request headers
$authHeader = getallheaders();
if (isset($authHeader['Authorization']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $authHeader['Authorization'];
    $token = explode(" ", $token)[1];

    try {
        $key = "Nirmal Avhad";
        $decoded = JWT::decode($token, $key);

        // Do some actions if token decoded successfully.

        // But for this demo let return decoded data
        http_response_code(200);
        echo json_encode($decoded);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(array('message' => 'Please authenticate'));
    }
} else {
    http_response_code(401);
    echo json_encode(array('message' => 'Please authenticate'));
}