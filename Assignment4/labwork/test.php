<?php
$con = new mysqli('localhost','root','','ayush');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sname = $_POST['sname'];
    $smarks = $_POST['smarks'];

    $stmt = $con->prepare("INSERT INTO ayush (name, marks) VALUES (?, ?)");
    $stmt->bind_param("ss", $sname, $smarks);
    $stmt->execute();
}

// Fetch all data
$result = $con->query("SELECT * FROM ayush");
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json');
echo json_encode($data);
?>
