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
  $id = $school_name = $school_year = $gender = $birthday = $from_location = $introduce
  = $hobby = $character_type = $profile_img = $category1 = $category2 = $category3 = $nickname = '';
  $pdo = new PDO($connect, USER, PASS);
  if(isset($_SESSION['users'])){
    $profile_img=$_SESSION['users']['profile_img'];
    $nickname=$_SESSION['users']['nickname'];
    $category1=$_SESSION['users']['category1'];
    $category2=$_SESSION['users']['category2'];
    $category3=$_SESSION['users']['category3'];
    $introduce=$_SESSION['users']['introduce'];
    $hoby=$_SESSION['users']['hoby'];
    $school_name=$_SESSION['users']['school_name'];
    $character_type=$_SESSION['users']['character_type'];

    echo '<form action="" method="post">';
    echo '<div class="container">';
    echo '<div class="header">';
    echo '<img src="https://via.placeholder.com/50"
         alt="User Icon" width="344" height="190">';
    echo '<div>';
    echo '<div class="username">';
    echo '<input type="text"  name="kana" class="textbox-001" placeholder=""/ value="', $nickname , '">';
    echo '</div>';
    echo '<div class="category">';
    echo 'どうしよっかな〜';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<div class="content">';
    echo '<h2>自己紹介</h2>';
    echo '<input type="text" name="introduction" class="textbox" placeholder=""/ value="', $introduce , '">';
    echo '<hr>';
    echo '<h2>趣味・特技</h2>';
    echo '<input type="text" name="hobbies" class="textbox" placeholder=""/ value="', $hobby , '">';
    echo '<hr>';
    echo '<h2>学校</h2>';
    echo '<input type="text" name="school" class="textbox" placeholder=""/ value="', $school_name , '">';
    echo '<hr>';
    echo '<h2>性格タイプ</h2>';
    echo '<input type="text" name="personality" class="textbox" placeholder=""/ value="', $character_type , '">';
    echo '<hr>';
    echo '<div class="like-button">';
    echo '<button type="submit">登録・更新</button>';
    echo '</div>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
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

