<?php
$user = [
    'id' => 'SD3E',
    'name' => 'MKtarou',
    'categories' => ['料理', '映画', 'Tiktok'],
    'description' => 'ここに自己紹介が入ります。',
    'hobbies' => 'ここに趣味・特技が入ります。',
    'school' => 'ここに学校情報が入ります。',
    'personality' => 'ここに性格タイプが入ります。',
];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asocompass-profile</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background-color: white;
            width: 300px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
        }
        .profile-img {
            width: 100%;
            height: auto;
        }
        .profile-info {
            padding: 20px;
        }
        .profile-id {
            color: grey;
            font-size: 14px;
            margin: 0;
        }
        .profile-name {
            margin: 10px 0;
            font-size: 24px;
        }
        .profile-category {
            margin: 10px 0;
        }
        .profile-category p {
            margin: 0;
            font-weight: bold;
        }
        .profile-category ul {
            list-style: none;
            padding: 0;
            margin: 5px 0 0;
        }
        .profile-category li {
            margin: 3px 0;
        }
        .profile-details {
            margin: 20px 0;
        }
        .profile-section {
            margin-bottom: 10px;
        }
        .profile-section p:first-child {
            margin: 0;
            font-weight: bold;
        }
        .like-btn {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
            text-align: center;
        }
        .like-btn:hover {
            background-color: #0056b3;
        }
    </style>

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
    <link rel="stylesheet" href="../assets/css/profilea.css">
</head>
<body>
<body>
    <div class="card">
        <button class="close-btn">&times;</button>
        <img src="profile.jpg" alt="プロフィール写真" class="profile-img">
        <div class="profile-info">
            <p class="profile-id"><?php echo htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8'); ?></p>
            <h2 class="profile-name"><?php echo htmlspecialchars($user['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
            <div class="profile-category">
                <p>カテゴリー</p>
                <ul>
                    <?php foreach ($user['categories'] as $category): ?>
                        <li><?php echo htmlspecialchars($category, ENT_QUOTES, 'UTF-8'); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="profile-details">
                <div class="profile-section">
                    <p>自己紹介</p>
                    <p><?php echo htmlspecialchars($user['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="profile-section">
                    <p>趣味・特技</p>
                    <p><?php echo htmlspecialchars($user['hobbies'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="profile-section">
                    <p>学校</p>
                    <p><?php echo htmlspecialchars($user['school'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
                <div class="profile-section">
                    <p>性格タイプ</p>
                    <p><?php echo htmlspecialchars($user['personality'], ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
        </div>
        <button class="like-btn">Like</button>
    </div>

    <script>
        // 「Like」ボタンクリックイベントを処理するスクリプト
        document.querySelector('.like-btn').addEventListener('click', function() {
            alert('MKtarouのプロフィールを「いいね！」しました！');
        });
        // 「閉じる」ボタンクリックイベントを処理するスクリプト
        document.querySelector('.close-btn').addEventListener('click', function() {
            document.querySelector('.card').style.display = 'none';
        });
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
