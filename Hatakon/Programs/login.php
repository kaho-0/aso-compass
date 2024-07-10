<?php
session_start();
require 'db-connect.php';
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
            header("Location: top.php");
            exit();
        } else {
            $error = "学籍番号またはパスワードが間違っています";
        }
    } catch (PDOException $e) {
        $error = "データベースエラー: " . $e->getMessage();
    }
}
?>

<!--HTML-->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asocompass</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/login.css">
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
<!--JS-->
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