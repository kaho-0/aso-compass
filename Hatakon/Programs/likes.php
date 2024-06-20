<?php 
session_start();
require 'db-connect.php'; 

// Check if user ID exists in the session
if (!isset($_SESSION['user_id'])) {
    // Generate a unique user ID
    $_SESSION['user_id'] = uniqid('user_', true);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Likes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <!--iconのリンク-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <!--Bootstrap5のリンク-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--navbarのリンク-->
    <?php require 'navbar.php'; ?>
    <!--style.cssに書き加えて、cssのファイル名を変更してください-->
    <link rel="stylesheet" href="../assets/css/likes.css">
</head>
<body>
    <div class="row">
        <h1><div class="likes-text">Likes</div></h1>
        <div class="slider-contents">
            <?php
                $pdo = new PDO($connect, USER, PASS);
                $sql = $pdo->query('SELECT * FROM `like` 
                                    INNER JOIN users ON `like`.like_id = users.id
                                    INNER JOIN school ON users.school_name = school.sId');
                foreach ($sql as $row) {
                    echo '<div class="card-size col-lg-4 col-sm-6 text-center">
                          <div class="account card-effect bg-white rounded-2">
                            <img src="../assets/image/account/' . $row['profile_img'] . '" alt="">
                            <div class="d-flex justify-content-between">
                              <h5 class="mb-10">' . $row['nickname'] . '</h5>
                              <p class="mb-0">' . $row['sNameID'] . '</p>
                            </div>
                            <div class="d-flex justify-content-start">
                              <h6>' . mb_strimwidth($row['introduce'], 0, 144, '…') . '</h6>
                            </div>
                            <form method="post" action="like-action.php">
                            <input type="hidden" name="like_id" value="' . $row['like_id'] . '">
                            <button type="submit" name="like_button">Like</button>
                            </form>
                          </div>
                        </div>';    
                }
            ?>
        </div>
        <div class="line-container"></div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="../assets/js/likes.js"></script>
</body>
</html>
