<?php
session_start();
require 'db-connect.php'; // データベースにアクセス

// セッションのデータを消す
unset($_SESSION['account']);

// エラーメッセージの初期化
$error = '';

if (isset($_POST['student_number']) && isset($_POST['password'])) {
    try {
        // データベース接続
        $pdo = new PDO($connect, USER, PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 学籍番号に対応するアカウントを取得
        $sql = $pdo->prepare('SELECT * FROM account WHERE student_number = ?');
        $sql->execute([$_POST['student_number']]);
        $row = $sql->fetch(PDO::FETCH_ASSOC);

        // パスワードの検証
        if ($row && password_verify($_POST['password'], $row['password'])) {
            $_SESSION['account'] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'student_number' => $row['student_number'],
                'password' => $row['password'],
                'account_img' => $row['account_img']
            ];
            header("Location: newSignup.php");
            exit();
        } else {
            $error = "学籍番号またはパスワードが間違っています";
        }
    } catch (PDOException $e) {
        $error = "データベースエラー: " . $e->getMessage();
    }
}
?>

<!-- ここからHTML -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asocompass</title>
    <!-- フォント -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <!-- アイコン -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="login.css">
    <style>
        :root {
            --hiroblue: #0080ff;
            --hatablue: #000080;
            --black: #191E26;
            --body: #78747A;
            --bcground: #F4F6FA;
            --LIKE: #BEE8FF;
        }

        body {
            background-color: var(--bcground);
            font-family: "Noto Sans JP", "Helvetica Neue", "Helvetica", "Hiragino Sans", "Hiragino Kaku Gothic ProN", "Arial", "Yu Gothic", "Meiryo", sans-serif;
            color: var(--black);
            overflow: hidden;
        }

        #animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease;
        }

        #login {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .logo {
            max-width: 120%;
            max-height: 100%;
        }

        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }

        #login {
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .fsize {
            font-size: 24px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .y {
            width: 100%;
            color: #868686;
        }

        .input-field {
            margin-bottom: 10px;
        }

        .container {
            width: 550px;
            padding: 40px;
            margin-top: 80px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .LoginButton {
            width: 100%;
            padding: 10px;
            background-color: var(--hatablue);
            color: #ffffff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .LoginButton:hover {
            background-color: #316ed6;
        }
    </style>
</head>
<body>
    <br>
    <!-- ロゴアニメーション -->
    <div id="animation">
        <img src="../assets/image/loginstart.png" alt="ロゴ" class="logo">
    </div>
    <!-- ログインフォーム -->
    <div id="login">
        <div class="container">
            <form method="post" action="">
                <p class="fsize">Login</p>
                <div class="y">学籍番号とPasswordを入力してください</div>
                <div class="form-floating mb-3">
                    <input type="text" name="student_number" class="form-control" id="student_number" placeholder="pafupafu@tapple.com" required>
                    <label for="student_number">学籍番号</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    <label for="password">Password</label>
                </div>
                <div class="my-3">
                    <a href="newSignup.php">会員登録はこちら</a>
                </div>
                <!-- エラーメッセージ -->
                <?php if (!empty($error)): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <button class="LoginButton">ログイン</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                // ロゴをじんわりとフェードアウト
                const animationDiv = document.getElementById('animation');
                animationDiv.style.opacity = '0';
                // フェードアウトが完了したらロゴを非表示にする
                setTimeout(() => {
                    animationDiv.style.display = 'none';
                    // ログインフォームをじんわりとフェードイン
                    const loginDiv = document.getElementById('login');
                    loginDiv.style.display = 'block';
                    setTimeout(() => {
                        loginDiv.style.opacity = '1';
                        document.body.style.overflow = 'auto';
                    }, 50);
                }, 300);
            }, 1500);
        });
    </script>
    <!-- Custom JavaScript -->
    <script src="login.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>