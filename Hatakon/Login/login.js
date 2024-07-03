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
                document.body.style.overflow = 'auto'; // ログイン画面表示後にスクロールを有効にする
            }, 50); // displayがblockになった後にopacityを変更
        }, 300); // フェードアウトのトランジションが完了するのを待つ時間
    }, 1500);
});
