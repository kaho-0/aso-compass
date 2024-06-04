<?php
session_start(); // セッションの開始
require 'db-connect.php'; // データベース接続
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asocompass</title>

    <!--fontのリンク-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <!--iconのリンク-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <!--Bootstrap5のリンク-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- PHP関連読み込み -->
    <?php require 'navbar.php'; ?> <!-- navbarのリンク -->
    <!--style.cssに書き加えて、cssのファイル名を変更してください-->
    <link rel="stylesheet" href="../assets/css/top.css">
</head>
<body>
      <!--
        Top section
      -->
      <section id="Top">
        <div class="container container-custom">
          <div class="row g-3">
            <div class="section">
              <h1 class="headline">All</h1>
              <hr class="line">
            </div>

            <?php
              $pdo=new PDO($connect,USER,PASS);
              $sql=$pdo->query('select * from users');
              foreach($sql as $row){
                echo '<div class="card-size col-lg-4 col-sm-6 text-center">
                      <div class="account card-effect bg-white rounded-2">
                        <img src="../assets/image/account/',$row['profile_img'],'" alt="">
                        <div class="d-flex justify-content-between">
                          <h5 class="mb-10">Kotarou</h5>
                          <p class="mb-0">SD3E</p>
                        </div>
                        <div class="d-flex justify-content-start">
                          <h6>こんにちは、よろしく！</h6>
                        </div>
                        <button>Like</button>
                      </div>
                    </div>';
              }
            ?>
            <?php
            for($i=1; $i<=7; $i++){
              echo '<div class="card-size col-lg-4 col-sm-6 text-center">
                      <div class="account card-effect bg-white rounded-2">
                        <img src="../assets/image/account/account1.png" alt="">
                        <div class="d-flex justify-content-between">
                          <h5 class="mb-10">Kotarou</h5>
                          <p class="mb-0">SD3E</p>
                        </div>
                        <div class="d-flex justify-content-start">
                          <h6>こんにちは、よろしく！</h6>
                        </div>
                        <button>Like</button>
                      </div>
                    </div>';
            }
            ?>

          </div>
        </div>

      </section>
    <!--Bootstrap5用の scriptなので、bodyの一番下から動かさないでください。-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>