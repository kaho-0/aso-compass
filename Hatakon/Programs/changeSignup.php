<?php
session_start();
// セッションからユーザーIDを取得
if (!isset($_SESSION['account']['id'])) {
    // セッションがない場合、ログインページにリダイレクト
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['account']['id'];

// データベース接続情報
require 'db-connect.php';
$pdo = new PDO($connect, USER, PASS);

// 初期化
$error = '';
$success = '';

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
        $upload_dir = '../assets/image/account/';
        $filename = uniqid() . '_' . basename($_FILES['account_img']['name']);
        $account_img = $upload_dir . $filename; 

        // ディレクトリが存在しない場合は作成する
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true); // 必要に応じてパーミッションを調整する
        }

        // ファイルの保存
        if (!move_uploaded_file($temp_name, $account_img)) {
            $error = "エラー: 画像のアップロードに失敗しました！";
            $filename = $user['account_img']; // アップロードに失敗した場合も元の画像を使用
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

    // 学籍番号の重複チェック
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM account WHERE student_number = :student_number AND id != :id");
    $stmt->bindParam(':student_number', $student_number);
    $stmt->bindParam(':id', $user_id);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $error = "エラー: この学籍番号は既に使用されています。";
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
        $stmt->bindParam(':account_img', $filename);
        $stmt->bindParam(':id', $user_id);

        // プリペアドステートメントを実行
        if ($stmt->execute()) {
            // データベースの更新成功
            $success = "更新が成功しました！";
        } else {
            $error = "エラー: データベースの更新に失敗しました。";
        }
    }
}
$pdo = null;
?>
<!--HTML-->
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
    <!-- css -->
    <link rel="stylesheet" href="../assets/css/changeSignup.css">
</head>
<body>
    <!--コンテナ外部-->
<br>
        <div class="title-cnrainer">
            <a href="top.php" class="back-link">← 戻る</a>
        </div>
        <div class="title-H">
            <h2>アカウント情報変更</h2>
        </div>
    <div class="change-container">
        <form method="POST" enctype="multipart/form-data" action="changeSignup.php">
            <div class="image-upload-container">
                <div id="preview">
                    <img src="<?php echo htmlspecialchars('../assets/image/account/' . $user['account_img']); ?>" alt="Current Profile Image">
                </div>
                <label class="fileUploadBtn">
                    <input type="file" id="fileInput" name="account_img" onchange="previewImage(event)" accept="image/*" style="display: none;">写真を選択する
                </label>
            </div>
            <div class="y">氏名・学籍番号は適切なものを入力してください。</div>
            <div class="form-floating">
                <input type="text" name="name" class="form-control" id="name" maxlength="20" placeholder="氏名" value="<?php echo htmlspecialchars($user['name']); ?>">
                <label for="name">氏名</label>
            </div>
            <div class="form-floating">
                <input type="text" name="student_number" class="form-control" maxlength="9" id="student_number" placeholder="学籍番号" value="<?php echo htmlspecialchars($user['student_number']); ?>">
                <label for="student_number">学籍番号</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control" id="password" maxlength="10" placeholder="Password">
                <label for="password">Password</label>
                <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
            </div>
            <!-- メッセージ処理 -->
            <?php if (!empty($error)) : ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <?php if (!empty($success)) : ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>
            <button class="btn btn-primary" type="submit">更新</button>
        </form>
    </div>

    <!--bootstrap-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!--JS-->
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
