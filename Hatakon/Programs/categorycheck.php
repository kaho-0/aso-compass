<?php require 'db-connect.php'; ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Page</title>
    <link rel="stylesheet" href="../assets/css/Categorycheck.css">
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
<body>
<?php require 'navbar.php'; ?>
<div class="container">
    <div class="category-title">Categorychoose</div>
    <form action="next-page.php" method="POST">
    <div class="grid">
    <?php
        try {
            $pdo = new PDO($connect, USER, PASS);
            $sql = "SELECT cate_id, cate_name, cate_img FROM category";
            $stmt = $pdo->query($sql);

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $imgSrc = "../assets/image/" . $row['cate_img'];
                echo '<div class="grid-item">';
                echo '<img src="' . $imgSrc . '" class="grid-item-img" alt="' . $row['cate_name'] . '">';
                echo '<span>' . $row['cate_name'] . '</span>';
                echo '<input type="checkbox" name="categories[]" value="' . $row['cate_id'] . '" class="checkbox">';
                echo '</div>';
            }
        } catch (PDOException $e) {
            echo '接続に失敗しました: ' . $e->getMessage();
        }
    ?>
    </div>
    <div class="button-container">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>
</div>
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