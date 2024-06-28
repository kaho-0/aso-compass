<?php session_start(); ?>
<?php require 'db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asocompass-profile</title>

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
    <!--navbarのリンク-->
    <?php require 'navbar.php'; ?>
    <!--style.cssに書き加えて、cssのファイル名を変更してください-->
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <?php
    $stmt = $pdo->prepare('
        SELECT u.*, 
               c1.cate_name AS category1_name,
               c2.cate_name AS category2_name,
               c3.cate_name AS category3_name,
               s.sName AS s_name
        FROM users u
        LEFT JOIN category c1 ON u.category1 = c1.cate_id
        LEFT JOIN category c2 ON u.category2 = c2.cate_id
        LEFT JOIN category c3 ON u.category3 = c3.cate_id
        LEFT JOIN school_test s ON u.school_name = sID
        WHERE u.id = ?
    ');
    $stmt->execute([4]);
    $row = $stmt->fetch();

    if ($row) {
        echo '<div class="profile-contents">';
            echo '<div class="header-profile">';
                echo '<img src="https://via.placeholder.com/50" alt="User Icon" width="320" height="180">';
                echo '<div class ="header-tent">';
                    echo '<div class="username">', (isset($row['nickname']) ? htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8') : ''), '</div>';
                    echo '<div class="category">
                        <p class="d-flex align-items-center mb-0"><span class="material-symbols-outlined icon-nav iconp">category</span>カテゴリー</p>
                        <ul>
                        <li>',(isset($row['category1_name']) ? htmlspecialchars($row['category1_name'], ENT_QUOTES, 'UTF-8') : ''),'</li>',
                        '<li>',(isset($row['category2_name']) ? htmlspecialchars($row['category2_name'], ENT_QUOTES, 'UTF-8') : ''),'</li>',
                        '<li>',(isset($row['category3_name']) ? htmlspecialchars($row['category3_name'], ENT_QUOTES, 'UTF-8') : ''),'</li>',
                        '</ul>',
                    '</div>';
                echo '</div>';
            echo '</div>'; // .header
        echo '<div class="content">';
        echo '<h2>自己紹介</h2>';
        echo '<p>', (isset($row['introduce']) ? htmlspecialchars($row['introduce'], ENT_QUOTES, 'UTF-8') : '') ,'</p>';
        echo '<hr class="profile-hr">';
        echo '<h2>趣味・特技</h2>';
        echo '<p>', (isset($row['hobby']) ? htmlspecialchars($row['hobby'], ENT_QUOTES, 'UTF-8') : ''), '</p>';
        echo '<hr class="profile-hr">';
        echo '<h2>学校</h2>';
        echo '<p>', (isset($row['s_name']) ? htmlspecialchars($row['s_name'], ENT_QUOTES, 'UTF-8') : ''), '</p>';
        echo '<hr class="profile-hr">';
        echo '<h2>性格タイプ</h2>';
        echo '<p>', (isset($row['character_type']) ? htmlspecialchars($row['character_type'], ENT_QUOTES, 'UTF-8') : ''), '</p>';
        echo '<hr class="profile-hr">';
        echo '<div class="like-button">';
        echo '<button id="like-btn">Like</button>';
        echo '</div>'; // .like-button
        echo '</div>'; // .content
        echo '</div>'; // .profile-contents
    } else {
        echo '<p>ユーザーが見つかりません。</p>';
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('like-btn').addEventListener('click', function() {
            alert('<?php echo htmlspecialchars($row['nickname'], ENT_QUOTES, 'UTF-8'); ?>のプロフィールを「いいね！」しました！');
        });
    </script>
</body>
</html>



