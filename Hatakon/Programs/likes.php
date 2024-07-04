<?php 
session_start();
require 'db-connect.php'; 
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
                $user_id = $_SESSION['customer'];
                $sql = $pdo->prepare('SELECT `like`.*, users.*,school_test.*
                                      FROM `like`
                                      INNER JOIN users ON `like`.id = users.id
                                      INNER JOIN school_test ON users.school_name = school_test.sId
                                      WHERE `like`.like_id = ?;
                                  ');
                $sql->execute([$user_id]);                  
                if (isset($_POST['like_button'])){
                  $like_id = $_POST['like_id'];
                  $stmt = $pdo->prepare('INSERT INTO `contact` (id_a, id_b) VALUES (?, ?)');
                  $stmt->execute([$user_id, $like_id]);
                  $stmt = $pdo->prepare('DELETE from `like` where (id=? and like_id=?) or (id=? and like_id=?)');
                  $stmt->execute([$user_id, $like_id,$like_id,$user_id]);
                  
                }                  
                foreach ($sql as $row) {
                    echo '<div class="card-size col-lg-4 col-sm-6 text-center">
                          <div class="account card-effect bg-white rounded-2">
                            <img src="../assets/image/account/' . $row['profile_img'] . '" alt="">
                            <div class="d-flex justify-content-between">
                              <h5 class="mb-10">' . $row['nickname'] . '</h5>
                              <p class="mb-0">' . $row['sNameID'] . '</p>
                            </div>
                            <div class="d-flex justify-content-start mb-auto">
                              <h6>' . mb_strimwidth($row['introduce'], 0, 144, '…') . '</h6>
                            </div>
                            <form method="post" action="likes.php" class="like-form" onsubmit="event.stopPropagation();">
                            <input type="hidden" name="like_id" value="' . $row['id'] . '">
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
