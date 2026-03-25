<?php
include 'condb.php';

$data = json_decode(file_get_contents("php://input"));

try {
    // Get the next emp_id
    $stmt = $conn->prepare("SELECT MAX(CAST(SUBSTRING(emp_id, 4) AS UNSIGNED)) as max_id FROM employees");
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $next_id = ($result['max_id'] ?? 0) + 1;
    $emp_id = 'EMP' . str_pad($next_id, 3, '0', STR_PAD_LEFT);
    
    // Insert new employee
    $stmt = $conn->prepare("INSERT INTO employees (emp_id, full_name, department, salary) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $emp_id,
        $data->full_name,
        $data->department,
        $data->salary
    ]);
    echo json_encode(["success" => true, "emp_id" => $emp_id]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>