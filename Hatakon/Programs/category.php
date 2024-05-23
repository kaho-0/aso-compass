<?php require 'db-connect.php'; ?>
<?php require 'header.php'; ?>

<div class="container mt-5">
    <?php
    try {
        // データベースから項目一覧を取得
        $stmt = $pdo->query('SELECT * FROM game');
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if ($items) {
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>ID</th><th>名前</th><th>ジャンル</th></tr></thead><tbody>';
            foreach ($items as $item) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($item['title_id']) . '</td>';
                echo '<td>' . htmlspecialchars($item['title']) . '</td>';
                echo '<td>' . htmlspecialchars($item['sell']) . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        } else {
            echo '<p>項目がありません。</p>';
        }
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">データベースエラー: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
    ?>
</div>

<?php require 'footer.php'; ?>
