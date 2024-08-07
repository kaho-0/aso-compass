<?php 
session_start();
require 'db-connect.php'; 
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <link rel="stylesheet" href="../assets/css/Categorycheck.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Page</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <!--iconのリンク-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <!--Bootstrap5のリンク-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<header>
    <?php require 'navbar.php'; ?>
</header>
<body>
<div class="container categorycheck-container">
    <div class="category-title">Categorychoose</div>
<?php
    $pdo = new PDO($connect, USER, PASS);
    $user_id = $_SESSION['account']['id'];

    // ユーザーが選択したカテゴリIDを取得
    $sql = "SELECT category1, category2, category3 FROM users WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $userCategories = $stmt->fetch(PDO::FETCH_ASSOC);

    $userCategoryIds = [];
    if ($userCategories) {
        $userCategoryIds = array_filter([$userCategories['category1'], 
                                         $userCategories['category2'], 
                                         $userCategories['category3']]);
    }

    if (isset($_POST['categorycheck'])) {
    // 取得
        if(isset($_POST['categories'])){
            $selectedCategories = $_POST['categories'];
        } else {
            $selectedCategories = null;
        }
        $category1 = isset($selectedCategories[0]) ? $selectedCategories[0] : null;
        $category2 = isset($selectedCategories[1]) ? $selectedCategories[1] : null;
        $category3 = isset($selectedCategories[2]) ? $selectedCategories[2] : null;

        // 更新処理
        $stmt = $pdo->prepare('UPDATE `users` SET `category1`=?, `category2`=?, `category3`=? WHERE `id`=?');
        $stmt->execute([$category1, $category2, $category3, $user_id]);

    }

    // カテゴリー取得
    $sql = "SELECT cate_id, cate_name, cate_img FROM category";
    $stmt = $pdo->query($sql);
    ?>

    <form action="categorycheck.php" method="POST">
        <div class="grid categorycheck-grid">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $imgSrc = "../assets/image/category/" . $row['cate_img'];
                $isChecked = in_array($row['cate_id'], $userCategoryIds) ? 'checked' : '';
                echo '<div class="grid-item">';
                echo '<img src="' . $imgSrc . '" class="grid-item-img" alt="' . $row['cate_name'] . '">';
                echo '<span>' . $row['cate_name'] . '</span>';
                echo '<input type="checkbox" name="categories[]" value="' . $row['cate_id'] . '" class="checkbox" ' . $isChecked . '>';
                echo '</div>';
            }
        ?>
        </div>
    <div class="button-container">
        <button type="submit" class="check-btn btn btn-primary " name="categorycheck">登録</button>
    </div>
</form></div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.checkbox');
    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.checkbox:checked').length;
            if (checkedCount > 3) {
                checkbox.checked = false;
                alert('選択できるカテゴリは3つまでです。');
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>