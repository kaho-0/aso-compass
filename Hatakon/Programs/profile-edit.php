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
    <link rel="stylesheet" href="../assets/css/profilemine.css">
</head>
<body>
  <!--?php
    // データベース接続情報
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "asocompass";

    // データベース接続
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 接続確認
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // POSTデータの処理
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $introduction = $_POST['introduction'];
        $hobbies = $_POST['hobbies'];
        $school = $_POST['school'];
        $personality = $_POST['personality'];

        $sql = "UPDATE users SET introduction='$introduction', hobbies='$hobbies', school='$school', personality='$personality' WHERE id=1"; // ユーザーIDを適宜変更

        if ($conn->query($sql) === TRUE) {
            echo "プロフィールが更新されました。";
        } else {
            echo "エラー: " . $sql . "<br>" . $conn->error;
        }
    }

    // ユーザーデータの取得
    $sql = "SELECT * FROM users WHERE id=1"; // ユーザーIDを適宜変更
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
  ?-->

  <div class="container">
      <div class="header">
        <img src="https://via.placeholder.com/50"
         alt="User Icon" width="344" height="190">
          <div>
              <div class="username">Asocompas</div>
              <div class="category">カテゴリ: 料理, 映画, Tiktok</div>
          </div>
      </div>

      <div class="content">
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
              <h2>自己紹介</h2>
              <input type="text" name="introduction" class="textbox" placeholder="ここに自己紹介文を入力してください。" value="<?php echo htmlspecialchars($user['introduction']); ?>"/>

              <hr>

              <h2>趣味・特技</h2>
              <input type="text" name="hobbies" class="textbox" placeholder="ここに趣味・特技の説明を入力してください。" value="<?php echo htmlspecialchars($user['hobbies']); ?>"/>

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
  </div>

  <?php
    $conn->close();
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
