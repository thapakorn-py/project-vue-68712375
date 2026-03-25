<?php
include 'condb.php';

$data = json_decode(file_get_contents("php://input"));

try {
    // Find user by username
    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
    $stmt->execute([$data->username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        echo json_encode(["success" => false, "error" => "Username ไม่พบ"]);
        exit;
    }
    
    // Verify password
    if (!password_verify($data->password, $user['password'])) {
        echo json_encode(["success" => false, "error" => "Password ไม่ถูกต้อง"]);
        exit;
    }
    
    // Remove password from user data before returning
    unset($user['password']);
    
    // Create a simple token (in production use JWT)
    $token = bin2hex(random_bytes(32));
    
    echo json_encode([
        "success" => true,
        "token" => $token,
        "user" => $user,
        "message" => "เข้าสู่ระบบสำเร็จ"
    ]);
    
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
