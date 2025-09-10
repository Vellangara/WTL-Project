<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "ayush");
if ($conn->connect_error) {
    echo json_encode(["status"=>"error", "message"=>"DB connection failed"]);
    exit;
}

// If checking ID (POST with only id)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && !isset($_POST['name'])) {
    $id = intval($_POST['id']);
    $result = $conn->query("SELECT id, name, marks FROM ayush WHERE id=$id");
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            "exists"=>true,
            "id"=>$row['id'],
            "name"=>$row['name'],
            "marks"=>$row['marks']
        ]);
    } else {
        echo json_encode(["exists"=>false]);
    }
    $conn->close();
    exit;
}

// UPDATE student (POST with id, name, marks)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['name'], $_POST['marks'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $marks = intval($_POST['marks']);

    $stmt = $conn->prepare("UPDATE ayush SET name=?, marks=? WHERE id=?");
    $stmt->bind_param("sii", $name, $marks, $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status"=>"ok", "message"=>"Updated successfully!"]);
    } else {
        echo json_encode(["status"=>"ok", "message"=>"No changes made!"]);
    }
    $stmt->close();
    $conn->close();
    exit;
}

echo json_encode(["status"=>"error", "message"=>"Invalid request"]);
$conn->close();
?>
