<?php session_start(); ?>
<?php require 'db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asocompass-profile-edit</title>

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
    <link rel="stylesheet" href="../assets/css/profile-edit.css">
</head>
<body>
  <?php
    if ($user) {
    $nickname = $user['nickname'];
    $category1 = $user['category1'];
    $category2 = $user['category2'];
    $category3 = $user['category3'];
    $introduce = $user['introduce'];
    $hobby = $user['hobby'];
    $school_name = $user['school_name'];
    $character_type = $user['character_type'];
 
        echo '<form action="" method="POST">';
        echo '<div class="container">';
        echo '<div class="header">';
       
        // プロフィール画像の表示（存在しない場合はデフォルトの画像を表示）
        if (isset($user['profile_img']) && !empty($user['profile_img'])) {
            echo '<img src="../assets/image/account/' . htmlspecialchars($user['profile_img'], ENT_QUOTES, 'UTF-8') . '" alt="アカウントの画像" width="344" height="190">';
        } else {
            echo '<img src="https://via.placeholder.com/50" alt="User Icon" width="344" height="190">';
        }
       
        // 名前
        echo '<div class="username">';
        echo '<input type="text" name="kana" class="textbox-001" placeholder="" value="' . htmlspecialchars($user['nickname'], ENT_QUOTES, 'UTF-8') . '">';
        echo '</div>';
 
        //　カテゴリー
        echo '<div class="category">';
        echo '<a href="#">category選択</a>';
        echo '</div>';
        echo '</div>'; // .header
       
        // プロフィール
        echo '<div class="content">';
        echo '<h2>自己紹介</h2>';
        echo '<input type="text" name="introduction" class="textbox" placeholder="" value="' . (isset($user['introduce']) ? htmlspecialchars($user['introduce'], ENT_QUOTES, 'UTF-8') : '') . '">';
        echo '<hr>';
        echo '<h2>趣味・特技</h2>';
        echo '<input type="text" name="hobbies" class="textbox" placeholder="" value="' . (isset($user['hobby']) ? htmlspecialchars($user['hobby'], ENT_QUOTES, 'UTF-8') : '') . '">';
        echo '<hr>';
        echo '<h2>学校</h2>';
        echo '<input type="text" name="school" class="textbox" placeholder="" value="' . (isset($user['school_name']) ? htmlspecialchars($user['school_name'], ENT_QUOTES, 'UTF-8') : '')  . '">';
        echo '<hr>';
        echo '<h2>性格タイプ</h2>';
        echo '<input type="text" name="personality" class="textbox" placeholder="" value="' . (isset($user['character_type']) ? htmlspecialchars($user['character_type'], ENT_QUOTES, 'UTF-8') : '')  . '">';
        echo '<hr>';
        echo '<div class="like-button">';
        echo '<button type="submit">登録・更新</button>';
        echo '</div>';
       
        echo '</div>'; // .content
        echo '</div>'; // .container
        echo '</form>'; // formの終了
    } else {
        echo "ユーザーが見つかりませんでした。";
    }
  ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
  
  <!-- <div class="container">
      <div class="header">
         <img src="https://via.placeholder.com/50"
         alt="User Icon" width="344" height="190">
          <div>
              <div class="username">Asocompas</div> -->
              <!-- <div class="category">カテゴリ: 料理, 映画, Tiktok</div>
          </div>
      </div>

      <div class="content">
         
              <h2>自己紹介</h2>
              <input type="text" name="introduction" class="textbox" placeholder="ここに自己紹介文を入力してください。" value="<?php echo htmlspecialchars($users['introduction']); ?>"/>

              <hr>

              <h2>趣味・特技</h2>
              <input type="text" name="hobbies" class="textbox" placeholder="ここに趣味・特技の説明を入力してください。" value="<?php echo htmlspecialchars($users['hobbies']); ?>"/>

              <hr>

              <h2>学校</h2>
              <input type="text" name="school" class="textbox" placeholder="ここに学校に関する情報を入力してください。" value="<?php echo htmlspecialchars($user['school']); ?>"/>

              <hr>

              <h2>性格タイプ</h2>
              <input type="text" name="personality" class="textbox" placeholder="ここに性格タイプに関する説明を入力してください。" value="<?php echo htmlspecialchars($user['personality']); ?>"/>

              <hr>

              <div class="like-button">
                  <button type="submit">登録・更新</button>
              </div>
          </form>
      </div>
  </div> --> 

