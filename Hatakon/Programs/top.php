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
              // データベース接続
              $pdo = new PDO($connect, USER, PASS);
              // セッションユーザーのlike_idを取得
              $user_id = $_SESSION['customer'];

              //insert section
              if (isset($_POST['like'])){
                $like_id = $_POST['like_id'];
                $stmt = $pdo->prepare('INSERT INTO `like` (id, like_id) VALUES (?, ?)');
                $stmt->execute([$user_id, $like_id]);
              }
              // delete section
              if (isset($_POST['unlike'])) {
                $like_id = $_POST['like_id'];
                $stmt = $pdo->prepare('DELETE FROM `like` WHERE id = ? AND like_id = ?');
                $stmt->execute([$user_id, $like_id]);
              }

              // ユーザー情報を取得し、フィルタリング
              $stmt = $pdo->prepare('SELECT like_id FROM `like` WHERE id = ?');
              $stmt->execute([$user_id]);
              $liked_ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

              $stmt = $pdo->prepare('
                        SELECT users.*,school.sNameID 
                        FROM users INNER JOIN school ON users.school_name = school.sId
                        WHERE id != ? AND id NOT IN (
                            SELECT id_b FROM contact WHERE id_a = ?
                            UNION
                            SELECT id_a FROM contact WHERE id_b = ?
                        )
                ');
              $stmt->execute([$user_id, $user_id, $user_id]);
              foreach ($stmt as $row) {
                $liked = in_array($row['id'], $liked_ids);

                echo '<div class="card-size col-lg-4 col-sm-6 text-center">
                        <div class="account card-effect bg-white rounded-2">
                            <div class="mb-auto" onclick="openModal(' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ')">
                              <img src="../assets/image/account/' . htmlspecialchars($row['profile_img'], ENT_QUOTES, 'UTF-8') . '" alt="">
                              <div class="d-flex justify-content-between">
                                  <h5 class="mb-10">',$row['nickname'],'</h5>
                                  <p class="mb-0">',$row['sNameID'],'</p>
                              </div>
                              <div class="d-flex justify-content-start">
                                  <h6>', mb_strimwidth($row['introduce'] , 0, 100,'…') ,'</h6>
                              </div>
                            </div>

                            <form method="post" action="top.php" class="like-form" onsubmit="event.stopPropagation();">
                                <input type="hidden" name="like_id" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">';
                                
                              if ($liked) {
                                  echo '<button type="submit" name="unlike" class="button-delete">Cancel</button>';
                              } else {
                                  echo '<button type="submit" name="like" class="button-insert">Like</button>';
                              }
              echo          '</form>
                        </div>
                      </div>';

                //model-contents
                echo '<div id="userModal-' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeModal(' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ')">&times;</span>
                            <h5 class="modal-title">ユーザー詳細</h5>
                            <div class="modal-body">
                                <h1>カードをここに表示！！！</h1>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" onclick="closeModal(' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ')">閉じる</button>
                            </div>
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
                        <div class="d-flex justify-content-start mb-auto">
                          <h6>こんにちは、よろしく！</h6>
                        </div>
                        <button class="button-insert">Like</button>
                      </div>
                    </div>';
            }
            ?>

          </div>
        </div>

      </section>
      <script>
        function openModal(id) {
            document.getElementById('userModal-' + id).style.display = 'block';
        }

        function closeModal(id) {
            document.getElementById('userModal-' + id).style.display = 'none';
        }
        // モーダルの外側をクリックしたときにモーダルを閉じる
        window.onclick = function(event) {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (event.target == modals[i]) {
                    modals[i].style.display = 'none';
                }
            }
        }
        // likeFormのイベントリスナー
        // document.querySelectorAll('.likeForm').forEach(form => {
        //     form.addEventListener('submit', function(event) {
        //         event.stopPropagation();
        //     });
        // });
    </script>
    <!--Bootstrap5用の scriptなので、bodyの一番下から動かさないでください。-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>