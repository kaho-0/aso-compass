<?php
session_start();
require 'db-connect.php';

if (isset($_POST['like_button'])) {
    $like_id = $_POST['like_id'];
    $user_id = $_SESSION['user_id']; // Get user ID from the session

    // Connect to the database
    $pdo = new PDO($connect, USER, PASS);

    // Fetch the data from the `like` table
    $stmt = $pdo->prepare('SELECT * FROM `like` WHERE like_id = ?');
    $stmt->execute([$like_id]);
    $like_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($like_data) {
        // Insert the data into `contact` table
        $stmt = $pdo->prepare('INSERT INTO contact (id_a, id_b) VALUES (?, ?)');
        $stmt->execute([$user_id, $like_id]);

        // Delete the data from the `like` table
        $stmt = $pdo->prepare('DELETE FROM `like` WHERE like_id = ?');
        $stmt->execute([$like_id]);

        echo "Data moved successfully!";
    } else {
        echo "No data found for like_id: " . htmlspecialchars($like_id);
    }
}
?>
