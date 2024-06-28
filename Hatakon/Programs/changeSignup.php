<?php
session_start();

// セッションがない場合はログインページにリダイレクト
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// データベース接続情報
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// ユーザーID（例：セッションから取得）

// 初期化
$error = '';

// ユーザー情報の取得
$stmt = $pdo->prepare("SELECT * FROM account WHERE id = :id");
$stmt->bindParam(':id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// フォームの処理部分の例
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ファイルのアップロード処理
    if (isset($_FILES['account_img']) && $_FILES['account_img']['error'] === UPLOAD_ERR_OK) {
        $temp_name = $_FILES['account_img']['tmp_name'];
        $upload_dir = '../img/profile/';
        $filename = uniqid() . '_' . basename($_FILES['account_img']['name']);
        $account_img = $upload_dir . $filename;

        // ディレクトリが存在しない場合は作成する
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // 必要に応じてパーミッションを調整する
        }

        // ファイルの保存
        if (!move_uploaded_file($temp_name, $account_img)) {
            $error = "エラー: 画像のアップロードに失敗しました！";
        }
    } elseif (isset($_FILES['account_img']) && $_FILES['account_img']['error'] !== UPLOAD_ERR_NO_FILE) {
        $error = "エラー: 画像のアップロードに失敗しました！";
    } else {
        $account_img = $user['account_img'];
    }

    // フォームデータの取得
    $name = $_POST["name"] ?? $user['name'];
    $student_number = $_POST["student_number"] ?? $user['student_number'];
    $password = $_POST["password"] ?? '';

    // 必須フィールドの検証
    if (empty($name) || empty($student_number)) {
        $error = "エラー: 氏名と学籍番号は必須です！";
    }

    // エラーがない場合にのみデータベースを更新
    if (empty($error)) {
        // パスワードの更新がある場合のみハッシュ化
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE account SET name = :name, student_number = :student_number, password = :password, account_img = :account_img WHERE id = :id");
            $stmt->bindParam(':password', $hashed_password);
        } else {
            $stmt = $pdo->prepare("UPDATE account SET name = :name, student_number = :student_number, account_img = :account_img WHERE id = :id");
        }

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':student_number', $student_number);
        $stmt->bindParam(':account_img', $account_img);
        $stmt->bindParam(':id', $user_id);

        // プリペアドステートメントを実行
        if ($stmt->execute()) {
            // データベースの更新成功
            header("Location: login.php");
            exit();
        } else {
            $error = "エラー: データベースの更新に失敗しました。";
        }
    }
}

// データベース接続のクローズ
$pdo = null;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <title>アカウント登録</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- カスタムCSS -->
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
        }

        .container {
            width: 100%;
            max-width: 550px;
            padding: 30px;
            background-color: #ffffff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 0 auto;
            text-align: center;
        }

        .form-floating {
            margin-bottom: 17px;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: var(--hatablue);
            color: #ffffff;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .LoginButton:hover {
            background-color: #316ed6;
        }

        /* 画像表示 */
        #preview {
            width: 100px;
            height: 100px;
            border: 1px solid #000000;
            border-radius: 10%;
            overflow: hidden;
            margin-bottom: 8px;
        }
        #preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fileUploadBtn {
            display: inline-block;
            padding: 10px 50px;
            background: var(--LIKE);
            color: var(--hatablue);
            cursor: pointer;
            border-radius: 5px;
            margin-top: 40px;
        }
        
        .fileUploadBtn:hover,
        .fileUploadBtn:focus {
            filter: brightness(1.2);
        }

        /* Flexbox for image and button */
        .image-upload-container {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .fileUploadBtn {
                padding: 15px 30px;
            }

            .image-upload-container {
                flex-direction: column;
            }
        }

        .title-H {
            text-align: center;
        }
    </style>
</head>
<body>
<br><br>
<div class="title-H">
    <h2>アカウント情報変更</h2>
</div>
<div class="container">
    <form method="POST" enctype="multipart/form-data" action="changeSignup.php">
        <div class="image-upload-container">
            <div id="preview">
                <img src="<?php echo htmlspecialchars($user['account_img']); ?>" alt="Current Profile Image">
            </div>
            <label class="fileUploadBtn">
                <input type="file" id="fileInput" name="account_img" onchange="previewImage(event)" accept="image/*" style="display: none;">
                写真を選択する
            </label>
        </div>
       
        <div class="form-floating">
            <input type="text" name="name" class="form-control" id="name" placeholder="氏名" value="<?php echo htmlspecialchars($user['name']); ?>">
            <label for="name">氏名</label>
        </div>
        <div class="form-floating">
            <input type="text" name="student_number" class="form-control" id="student_number" placeholder="学籍番号" value="<?php echo htmlspecialchars($user['student_number']); ?>">
            <label for="student_number">学籍番号</label>
        </div>
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            <label for="password">Password</label>
            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
        </div>
        <?php if (!empty($error)) : ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <button class="btn btn-primary" type="submit">更新</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Image Preview">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.querySelector('.toggle-password').addEventListener('click', function (e) {
        const passwordInput = document.querySelector('#password');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            this.classList.remove('fa-eye-slash');
        }
    });
</script>
</body>
</html>

