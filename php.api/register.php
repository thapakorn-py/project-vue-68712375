<?php
include 'condb.php';

$data = json_decode(file_get_contents("php://input"));

try {
    // Validate email format
    if (!filter_var($data->email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["success" => false, "error" => "Email ไม่ถูกต้อง"]);
        exit;
    }

    // Check if username already exists
    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
    $stmt->execute([$data->username]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "error" => "Username นี้มีผู้ใช้แล้ว"]);
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->execute([$data->email]);
    
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => false, "error" => "Email นี้มีผู้ใช้แล้ว"]);
        exit;
    }

    // Insert new customer account
    $stmt = $conn->prepare("INSERT INTO customers (firstName, lastName, phone, email, username, password) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data->firstName,
        $data->lastName,
        $data->phone,
        $data->email,
        $data->username,
        password_hash($data->password, PASSWORD_DEFAULT)
    ]);
    
    echo json_encode(["success" => true, "message" => "สมัครสมาชิกสำเร็จ"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
