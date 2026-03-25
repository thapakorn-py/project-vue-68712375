<?php
include 'condb.php';

$data = json_decode(file_get_contents("php://input"));

try {
    $stmt = $conn->prepare("DELETE FROM employees WHERE emp_id = ?");
    $stmt->execute([$data->emp_id]);
    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>