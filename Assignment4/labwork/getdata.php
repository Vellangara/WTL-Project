<?php
$conn = new mysqli("localhost", "root", "", "ayush");

if ($conn->connect_error) {
    die(json_encode(["exists" => false, "error" => "Connection failed"]));
}

// Case 1: If ID is sent → return one student
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $conn->prepare("SELECT id, name, marks FROM ayush WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $row['exists'] = true;  // 🔹 Mark as exists
        echo json_encode($row);
    } else {
        echo json_encode(["exists" => false]);
    }

    $stmt->close();
} 
// Case 2: No ID → return all ayush
else {
    $stmt = $conn->prepare("SELECT name, marks FROM ayush");
    $stmt->execute();
    $result = $stmt->get_result();
    $arr = [];

    while ($row = $result->fetch_assoc()) {
        $arr[] = $row;
    }

    echo json_encode($arr);
    $stmt->close();
}

$conn->close();
?>