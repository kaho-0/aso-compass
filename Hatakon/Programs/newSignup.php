<?php
// データベース接続情報
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// 初期化
$error = '';

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
    }

    // フォームデータの取得
    $name = $_POST["name"] ?? '';
    $student_number = $_POST["student_number"] ?? '';
    $password = $_POST["password"] ?? '';

    // 必須フィールドの検証
    $requiredFields = array($name, $student_number, $password);
    if (in_array("", $requiredFields)) {
        $error = "エラー: 入力していないところがあります！";
    }

    // エラーがない場合にのみデータベースに挿入
    if (empty($error)) {
        // ユーザー名が重複していないか確認
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM account WHERE student_number = :student_number");
        $stmt->bindParam(':student_number', $student_number);
        $stmt->execute();

        if ($stmt->fetchColumn() == 0) {
            // パスワードのハッシュ化
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // データベースへの挿入処理
            $stmt = $pdo->prepare("INSERT INTO account (name, student_number, password, account_img) VALUES (:name, :student_number, :password, :account_img)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':student_number', $student_number);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':account_img', $account_img);

            // プリペアドステートメントを実行
            if ($stmt->execute()) {
                // データベースへの挿入成功
                header("Location: login.php");
                exit();
            } else {
                $error = "エラー: データベースへの挿入に失敗しました。";
            }
        } else {
            $error = "エラー: 同じ学籍番号が既に存在します。";
        }
    }
}

// データベース接続のクローズ
$pdo = null;
?>


<!-- ここからHTML -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <h2>アカウント情報</h2>
    </div>
    <div class="container">
        <form method="POST" enctype="multipart/form-data" action="newSignup.php">
            <div class="image-upload-container">
                <div id="preview"></div>
                <label class="fileUploadBtn">
                    <input type="file" id="fileInput" name="account_img" onchange="previewImage(event)" accept="image/*" style="display: none;">
                    写真を選択する
                </label>
            </div>
            <div class="form-floating">
                <input type="text" name="name" class="form-control" id="name" placeholder="氏名" maxlength="20">
                <label for="name">氏名</label>
            </div>
            <div class="form-floating">
                <input type="text" name="student_number" class="form-control" id="student_number" placeholder="学籍番号" maxlength="10">
                <label for="student_number">学籍番号</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <!-- エラーメッセージ表示 -->
            <?php if (!empty($error)) : ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            
            <button class="btn btn-primary" type="submit">登録</button>
        </form>
    </div>
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- 画像プレビュー用スクリプト -->
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
    </script>
</body>
</html>
