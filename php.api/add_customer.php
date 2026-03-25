<?php
include 'condb.php';

$data = json_decode(file_get_contents("php://input"));

try {
    $stmt = $conn->prepare("INSERT INTO customers (firstName, lastName, phone, username) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $data->firstName,
        $data->lastName,
        $data->phone,
        $data->username
    ]);
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>