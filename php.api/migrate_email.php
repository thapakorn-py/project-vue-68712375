<?php
include 'condb.php';

try {
    // Check if email column already exists
    $stmt = $conn->query("SHOW COLUMNS FROM customers LIKE 'email'");
    if ($stmt->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "Email column already exists"]);
        exit;
    }

    // Add email column if it doesn't exist
    $sql = "ALTER TABLE customers ADD COLUMN email VARCHAR(100) NOT NULL DEFAULT '' UNIQUE";
    $conn->exec($sql);
    
    echo json_encode(["success" => true, "message" => "Email column added successfully"]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>
