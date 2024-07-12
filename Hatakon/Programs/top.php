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
    <link rel="stylesheet" href="../assets/css/profile.css">
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
              $user_id = $_SESSION['account']['id'];

              //フォームの再リロードを防ぐ
              $token = isset($_POST['token']) ? $_POST['token'] : "";
              $session_token = isset($_SESSION['token']) ? $_SESSION['token'] : "";

              
              //insert section
              if (isset($_POST['like'])){
                $like_id = $_POST['like_id'];

                if($_SESSION['token'] != $like_id) {
                  //相手がLikeしていた時の処理
                  $check_stmt = $pdo->prepare('SELECT COUNT(*) FROM `like` WHERE like_id = ? and id = ?');
                  $check_stmt->execute([$user_id, $like_id]);
                  $like_exists = $check_stmt->fetchColumn() > 0;
  
                  if ( $like_exists ){
                    $stmt = $pdo->prepare('INSERT INTO `contact` (id_a, id_b) VALUES (?, ?)');
                    $stmt->execute([$user_id, $like_id]);
                    $stmt = $pdo->prepare('DELETE from `like` where (id=? and like_id=?) or (id=? and like_id=?)');
                    $stmt->execute([$user_id, $like_id,$like_id,$user_id]);
                  }
                  else{
                    // 自分からのLike重複チェック
                    $stmt = $pdo->prepare('SELECT COUNT(*) FROM `like` WHERE id = ? AND like_id = ?');
                    $stmt->execute([$user_id, $like_id]);
                    $count = $stmt->fetchColumn();

                    if($count == 0){
                      $stmt = $pdo->prepare('INSERT INTO `like` (id, like_id) VALUES (?, ?)');
                      $stmt->execute([$user_id, $like_id]);
                    }
                  }
                }
                $_SESSION['token'] = $like_id;
                // unset($_SESSION['token']);
              }
              else{
                $token = uniqid('', true);
                $_SESSION['token'] = $token;
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
                        SELECT users.*,school_test.sNameID ,school_test.sName,
                                c1.cate_name AS category1_name,
                                c2.cate_name AS category2_name,
                                c3.cate_name AS category3_name
                        FROM users 
                        INNER JOIN school_test ON users.school_name = school_test.sId
                        LEFT JOIN category c1 ON users.category1 = c1.cate_id
                        LEFT JOIN category c2 ON users.category2 = c2.cate_id
                        LEFT JOIN category c3 ON users.category3 = c3.cate_id
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

                            <form method="post" action="top.php" class="likeForm">
                                <input type="hidden" name="like_id" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">
                                <input type="hidden" name="token" value="',$token,'">';
                              if ($liked) {
                                  echo '<button type="submit" name="unlike" class="button-delete">Cancel</button>';
                              } else {
                                  echo '<button type="submit" name="like" class="button-insert">Like</button>';
                              }
                echo        '</form>
                        </div>
                      </div>';

                //model-contents
                echo '<div id="userModal-' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '" class="modal mt-0">';
                            echo '<div class="profile-contents">';
                                echo '<div class="header-profile">';
                                    echo '<div class="d-flex">';
                                      echo '<img src="../assets/image/account/' . htmlspecialchars($row['profile_img'], ENT_QUOTES, 'UTF-8') . '" alt="User Icon" width="320" height="180">';
                                      echo '<div class ="header-tent">';
                                          echo '<div class="username">', (isset($row['nickname']) ? htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8') : ''), '</div>';
                                          echo '<div class="category">
                                                <p class="d-flex align-items-center mb-0"><span class="material-symbols-outlined icon-nav iconp">category</span>カテゴリー</p>
                                                <ul>
                                                <li>',(isset($row['category1_name']) ? htmlspecialchars($row['category1_name'], ENT_QUOTES, 'UTF-8') : ''),'</li>',
                                                '<li>',(isset($row['category2_name']) ? htmlspecialchars($row['category2_name'], ENT_QUOTES, 'UTF-8') : ''),'</li>',
                                                '<li>',(isset($row['category3_name']) ? htmlspecialchars($row['category3_name'], ENT_QUOTES, 'UTF-8') : ''),'</li>',
                                                '</ul>',
                                              '</div>';//category
                                      echo '</div>';//header-tent
                                    echo '</div>';
                                    echo '<span class="material-symbols-outlined" onclick="closeModal(' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . ')">close</span>';
                                echo '</div>'; // .header
                                echo '<div class="content">';
                                  echo '<hr>';
                                  echo '<h2>自己紹介</h2>';
                                  echo '<p class="introduce">', (isset($row['introduce']) ? htmlspecialchars($row['introduce'], ENT_QUOTES, 'UTF-8') : '') ,'</p>';
                                  echo '<hr>';
                                  echo '<h2>趣味・特技</h2>';
                                  echo '<p>', (isset($row['hobby']) ? htmlspecialchars($row['hobby'], ENT_QUOTES, 'UTF-8') : ''), '</p>';
                                  echo '<hr>';
                                  echo '<h2>学校</h2>';
                                  echo '<p>', (isset($row['sName']) ? htmlspecialchars($row['sName'], ENT_QUOTES, 'UTF-8') : ''), '</p>';
                                  echo '<hr>';
                                  echo '<h2>性格タイプ</h2>';
                                  echo '<p>', (isset($row['character_type']) ? htmlspecialchars($row['character_type'], ENT_QUOTES, 'UTF-8') : ''), '</p>';
                                  echo '<hr>';

                                  echo '<div class="plofile-likeForm">';
                                    echo '<form method="post" action="top.php" class="likeForm">
                                            <input type="hidden" name="like_id" value="' . htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8') . '">
                                            <input type="hidden" name="token" value="',$token,'">';
                                          if ($liked) {
                                              echo '<button type="submit" name="unlike" class="button-delete">Cancel</button>';
                                          } else {
                                              echo '<button type="submit" name="like" class="button-insert">Like</button>';
                                          }
                                    echo '</form>';
                                  echo '</div>';        
                                echo '</div>'; // .content
                            echo '</div>'; // .profile-contents
                echo '</div>';
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

        // スクロール位置を保存する関数
        function saveScrollPosition() {
            const scrollPosition = window.scrollY;
            sessionStorage.setItem('scrollPosition', scrollPosition);
        }

        // 保存されたスクロール位置にスクロールする関数
        function restoreScrollPosition() {
            const scrollPosition = sessionStorage.getItem('scrollPosition');
            if (scrollPosition !== null) {
                window.scrollTo(0, scrollPosition);
                sessionStorage.removeItem('scrollPosition');
            }
        }

        // フォーム送信時にスクロール位置を保存する
        document.querySelectorAll('.likeForm').forEach(form => {
            form.addEventListener('submit', function(event) {
                saveScrollPosition();
            });
        });

        // ページ読み込み時にスクロール位置を復元する
        window.addEventListener('load', restoreScrollPosition);
    </script>
    <!--Bootstrap5用の scriptなので、bodyの一番下から動かさないでください。-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>