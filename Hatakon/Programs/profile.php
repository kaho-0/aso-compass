<?php
$user = [
    'id' => 'SD3E',
    'name' => 'Asocompas',
    'categories' => ['料理', '映画', 'Tiktok'],
    'description' => 'ここに自己紹介文を入力してください。',
    'hobbies' => 'ここに趣味・特技の説明を入力してください。',
    'school' => 'ここに学校に関する情報を入力してください。',
    'personality' => 'ここに性格タイプに関する説明を入力してください。',
];
?>
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
  <div class=" profile-contents">
      <div class="header">
        <img src="https://via.placeholder.com/50" alt="User Icon" width="330" height="160">
        <div>
            <div class="username"><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="category">カテゴリ: 
                <?php echo htmlspecialchars(implode(', ', $user['categories']), ENT_QUOTES, 'UTF-8'); ?>
            </div>
        </div>
      </div>

      <div class="content">
          <h2>自己紹介</h2>
          <p><?php echo htmlspecialchars($user['description'], ENT_QUOTES, 'UTF-8'); ?></p>

          <hr>

          <h2>趣味・特技</h2>
          <p><?php echo htmlspecialchars($user['hobbies'], ENT_QUOTES, 'UTF-8'); ?></p>

          <hr>

          <h2>学校</h2>
          <p><?php echo htmlspecialchars($user['school'], ENT_QUOTES, 'UTF-8'); ?></p>

          <hr>

          <h2>性格タイプ</h2>
          <p><?php echo htmlspecialchars($user['personality'], ENT_QUOTES, 'UTF-8'); ?></p>

          <hr>

          <div class="like-button">
              <button id="like-btn">Like</button>
          </div>
      </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('like-btn').addEventListener('click', function() {
            alert('<?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?>のプロフィールを「いいね！」しました！');
        });
    </script>
</body>
</html>

