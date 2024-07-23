<?php
ob_start();
session_start(); ?>
<?php require 'db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プロフィール編集</title>

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
// データベース接続
$pdo = new PDO($connect, USER, PASS);
// ユーザーIDをセッションから取得
$user_id = $_SESSION['account']['id'];

// ユーザーデータをデータベースから取得 check
$stmt = $pdo->prepare('
SELECT *
FROM users 
LEFT JOIN school ON users.school_name = school.schoolId
LEFT JOIN department ON users.school_department = department.departmentId
LEFT JOIN major ON users.school_major = major.majorId
LEFT JOIN course ON users.school_course = course.courseId
WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// 学校データをデータベースから取得 check
$school_stmt = $pdo->query('SELECT * FROM school');
$school_stmt->execute();
$schools = $school_stmt->fetchAll(PDO::FETCH_ASSOC);
// 学科データをデータベースから取得 check
$department_stmt = $pdo->query('SELECT * FROM department');
$department_stmt->execute();
$departments = $department_stmt->fetchAll(PDO::FETCH_ASSOC);
// 専攻データをデータベースから取得 check
$major_stmt = $pdo->query('SELECT * FROM major');
$major_stmt->execute();
$majors = $major_stmt->fetchAll(PDO::FETCH_ASSOC);
// 専攻データをデータベースから取得 check
$course_stmt = $pdo->query('SELECT * FROM course');
$course_stmt->execute();
$courses = $course_stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profile_img = $user['profile_img']; // デフォルトでは既存の画像を保持

    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
        $temp_name = $_FILES['profile_img']['tmp_name'];
        $upload_dir = '../assets/image/profile/';
        $filename = uniqid() . '_' . basename($_FILES['profile_img']['name']);
        $profile_img = $filename;
    
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        if (move_uploaded_file($temp_name,$upload_dir . $profile_img)){
        } else {
            $error = "エラー: 画像のアップロードに失敗しました！";
            $profile_img = $user['profile_img']; // アップロードに失敗した場合は元の画像を保持
        }
    } elseif (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] !== UPLOAD_ERR_NO_FILE) {
        $error = "エラー: 画像のアップロードに失敗しました！";
    }
    
        


    // 登録処理 check
    if (isset($_POST['add'])){
        $id = $user_id;
        $stmt = $pdo->prepare('
        INSERT INTO `users`(`id`, `school_name`,`school_department`,`school_major`,`school_course`,
        `introduce`, `hobby`, `character_type`,`profile_img`, `nickname`) 
        VALUES (?,?,?,?,?,?,?,?,?,?)');
        $stmt->execute([
            $id,
            $_POST['school'],
            $_POST['department'],
            $_POST['major'],
            $_POST['course'],
            $_POST['introduce'],
            $_POST['hobby'],
            $_POST['character_type'],
            $profile_img,
            $_POST['nickname']]);
    }
        
    // 更新処理 check
    if (isset($_POST['update'])) {
        $id = $user_id;
        $stmt = $pdo->prepare('
        UPDATE `users` SET 
        `school_name`=?,`school_department`=?,`school_major`=?,`school_course`=?,
        `introduce`=?,`hobby`=?,`character_type`=?,`nickname`=?,`profile_img`=? WHERE id = ?');
        $stmt->execute([
            $_POST['school'],
            $_POST['department'],
            $_POST['major'],
            $_POST['course'],
            $_POST['introduce'],
            $_POST['hobby'],
            $_POST['character_type'],
            $_POST['nickname'],
            $profile_img,
            $id]);
    }
    
        // リダイレクトして変更を反映
        header('Location: profile-edit.php');
        exit;
}

$id = $school_name = $school_department = $school_major = $school_course = $school_year = $introduce = $hobby 
 = $character_type = $profile_img = $nickname = '';


    $nickname = $user['nickname'] ?? '';
    $school_name = $user['school_name'] ?? '';
    $school_department = $user['school_department'] ?? '';
    $school_major = $user['school_major'] ?? '';
    $school_course= $user['school_course'] ?? '';
    $character_type = $user['character_type'] ?? '';
    $hobby = $user['hobby'] ?? '';
    $introduce = $user['introduce'] ?? '';
    $img = $user['profile_img'] ?? '';

        echo '<form action="profile-edit.php" enctype="multipart/form-data" method="POST">';
        echo '<div class="container-profile">';
        echo '<div class="header">';
        
        // プロフィール画像の表示（存在しない場合はデフォルトの画像を表示）
        echo '<div class="profile-img-container">';
        echo '<label for="profile_img_input">';
        if (isset($user['profile_img']) && !empty($user['profile_img'])) {
        echo '<img id="profile_img" src="../assets/image/profile/' . htmlspecialchars($user['profile_img'], ENT_QUOTES, 'UTF-8') . '" alt="アカウントの画像" width="344" height="190">';
    } else {
            echo '<img id="profile_img" src="https://via.placeholder.com/50" alt="User Icon" width="344" height="190">';
        }       
        echo '<input type="file" id="fileInput" name="profile_img" onchange="previewImage(event)" accept="image/*" style="display: none;">';
        echo '</label>';
        echo '</div>';
        
        // 名前
        echo '<div class="username">';
        echo '<input type="text" name="nickname" class="textbox-001" placeholder="" value="' . htmlspecialchars($nickname, ENT_QUOTES, 'UTF-8') . '" required>';
        echo '<div class="category">';
        echo '<a class="category" href="categorycheck.php">カテゴリー選択</a>';
        echo '</div>';
        echo '</div>';

        //　カテゴリー
        // echo '<div class="category">';
        // echo '<a href="#">カテゴリー選択</a>';
        // echo '</div>';
        echo '</div>'; // .header
        
        // プロフィール　＊学校名をセレクトボックス
        echo '<div class="content">';
        echo '<h2>自己紹介</h2>';
        echo '<textarea name="introduce" class="textbox" placeholder="">' . (isset($user['introduce']) ? htmlspecialchars($user['introduce'], ENT_QUOTES, 'UTF-8') : '') . '</textarea>';
        echo '<hr>';
        echo '<h2>趣味・特技</h2>';
        echo '<input type="text" name="hobby" class="textbox" placeholder="" value="' . (isset($user['hobby']) ? htmlspecialchars($user['hobby'], ENT_QUOTES, 'UTF-8') : '') . '">';
        echo '<hr>';

        // 学校選択
        echo '<h2>学校</h2>';
        echo '<select id="school" name="school" class="textbox">';
        foreach ($schools as $school) {
            $selected = ($school['schoolId'] == $school_name) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($school['schoolId'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($school['sName'], ENT_QUOTES, 'UTF-8') . '</option>';
        } 
        echo '</select>';

        // 学科選択
        echo '<h2>学科</h2>';
        echo '<select id="department" name="department" class="textbox" required>';
            echo '<option value="">選択してください。</option>';
        foreach ($departments as $department) {
            $selected = ($department['departmentId'] == $school_department) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($department['departmentId'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($department['sDepartment'], ENT_QUOTES, 'UTF-8') . '</option>';
        }
        echo '</select>';
        
        // 専攻選択
        echo '<h2>専攻</h2>';
        echo '<select id="major" name="major" class="textbox">';
            echo '<option value="">選択してください。</option>';
        foreach ($majors as $major) {
            $selected = ($major['majorId'] == $school_major) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($major['majorId'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($major['sMajor'], ENT_QUOTES, 'UTF-8') . '</option>';
        }
        echo '</select>';


        // コース選択
        echo '<h2>コース</h2>';
        echo '<select id="course" name="course" class="textbox">';
            echo '<option value="">選択してください。</option>';
        foreach ($courses as $course) {
            $selected = ($course['courseId'] == $school_course) ? 'selected' : '';
            echo '<option value="' . htmlspecialchars($course['courseId'], ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($course['sCourse'], ENT_QUOTES, 'UTF-8') . '</option>';
        }
        echo '</select>';
        echo '<hr>';

        echo '<h2>性格タイプ</h2>';
        echo '<input type="text" name="character_type" placeholder="MBTIなど、自分の性格について簡単に記入してください。" class="textbox" placeholder="" value="' . (isset($user['character_type']) ? htmlspecialchars($user['character_type'], ENT_QUOTES, 'UTF-8') : '')  . '">';

        echo '<div class="like-button">';
        if ($user) {
            echo '<button type="submit" name="update">更新</button>';
        } else {
            echo '<button type="submit" name="add">追加</button>';
        }
        echo '</div>';
        
        
        echo '</div>'; // .content
        echo '</div>'; // .container
        echo '</form>'; // formの終了

  ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const departments = <?= json_encode($departments) ?>;
    const majors = <?= json_encode($majors) ?>;
    const courses = <?= json_encode($courses) ?>;

    const schoolSelect = document.getElementById('school');
    const departmentSelect = document.getElementById('department');
    const majorSelect = document.getElementById('major');
    const courseSelect = document.getElementById('course');

    // 初期状態で選択ボックスを更新する
    updateDepartments();
    updateMajors();
    updateCourses();

    schoolSelect.addEventListener('change', function () {
        updateDepartments();
        updateMajors();
        updateCourses();
    });

    departmentSelect.addEventListener('change', function () {
        updateMajors();
        updateCourses();
    });

    majorSelect.addEventListener('change', function () {
        updateCourses();
    });

    function updateDepartments() {
        const schoolId = schoolSelect.value;
        departmentSelect.innerHTML = '<option value="">選択してください。</option>';
        majorSelect.innerHTML = '<option value="">選択してください。</option>';
        courseSelect.innerHTML = '<option value="">選択してください。</option>';
        departments.forEach(department => {
            if (department.schoolId == schoolId) {
                departmentSelect.innerHTML += `<option value="${department.departmentId}" ${department.departmentId == <?= json_encode($school_department) ?> ? 'selected' : ''}>${department.sDepartment}</option>`;
            }
        });
    }

    function updateMajors() {
        const departmentId = departmentSelect.value;
        majorSelect.innerHTML = '<option value="">選択してください。</option>';
        courseSelect.innerHTML = '<option value="">選択してください。</option>';
        majors.forEach(major => {
            if (major.departmentId == departmentId) {
                majorSelect.innerHTML += `<option value="${major.majorId}" ${major.majorId == <?= json_encode($school_major) ?> ? 'selected' : ''}>${major.sMajor}</option>`;
            }
        });
    }

    function updateCourses() {
        const majorId = majorSelect.value;
        courseSelect.innerHTML = '<option value="">選択してください。</option>';
        courses.forEach(course => {
            if (course.majorId == majorId) {
                courseSelect.innerHTML += `<option value="${course.courseId}" ${course.courseId == <?= json_encode($school_course) ?> ? 'selected' : ''}>${course.sCourse}</option>`;
            }
        });
    }
    
    // プロフィール画像のクリックイベントを追加
    const profileImg = document.getElementById('profile_img');
    const fileInput = document.getElementById('fileInput');

    profileImg.addEventListener('click', function () {
        fileInput.click();
    });

});

function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('profile_img');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

</script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

<?php
ob_end_flush(); // 出力バッファをフラッシュして送信
?>