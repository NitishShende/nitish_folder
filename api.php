<?php
include 'db.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['error' => 'Unauthorized']));
}

$user_id = $_SESSION['user_id'];

// Get Transactions
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $result = $conn->query("SELECT * FROM transactions WHERE user_id = $user_id ORDER BY id DESC");
    echo json_encode($result->fetch_all(MYSQLI_ASSOC));
}

// Add Transaction
// api.php ke andar insertion logic aisa hona chahiye:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['delete'])) {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $amount = $_POST['amount'];
    $desc = $_POST['desc'];
    $type = $_POST['type'];
    $cat = $_POST['cat'];

    $sql = "INSERT INTO transactions (user_id, type, amount, description, category, date) 
            VALUES ('$user_id', '$type', '$amount', '$desc', '$cat', '$date')";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
    exit();
}

// Delete Transaction
// api.php ke delete section mein ye add karein
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $user_id = $_SESSION['user_id'];
    if ($id === 'all') {
        $sql = "DELETE FROM transactions WHERE user_id = $user_id";
    } else {
        $sql = "DELETE FROM transactions WHERE id = $id AND user_id = $user_id";
    }
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
    exit();
}
?>