<link rel="stylesheet" href="../assets/css/navbar.css">
<!-- 
navbar section
-->
<nav class="navbar bg-white">
        <div class="container">
          <a class="navbar-brand navbar-contents" href="#">
            <h2 class="logo">Asocompass</h2>
            <span class="material-symbols-outlined icon-explore">explore</span>
          </a>
          <div class="navbar-contents">
            <button class="icon-help">
              <span class="material-symbols-outlined">help</span>
            </button>
            <a class="icon-account navbar-contents" href="#">
              <?php
                $_SESSION['customer']=1;
                $pdo=new PDO($connect,USER,PASS);
                $sql=$pdo->prepare('select * from account where id=?');
                $sql->execute([$_SESSION['customer']]);
                $account = $sql->fetch(PDO::FETCH_ASSOC);

                echo '<p>',$account['name'],'</p>';
                if(isset($account['account_img'])){
                  echo '<img src="../assets/image/account/',$account['account_img'],'" alt="アカウント画像です/プロフィール画像ではない">';
                }
                else{
                  echo '<span class="material-symbols-outlined">account_circle</span>';
                }
              ?>
              <!-- <p>Mktarou</p> -->
              <!-- <img src="../assets/image/account2.png" alt="アカウント画像です/プロフィール画像ではない"> -->
              <!-- <span class="material-symbols-outlined">account_circle</span> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
              <span class="material-symbols-outlined icon-density">density_medium</span>
            </button>
          </div>
          
          <!--sidebar-->
          <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" >
            <div class="offcanvas-body d-flex flex-column h-100">
              <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                <li>
                  <a href="#" class="nav-item">
                    <span class="material-symbols-outlined icon-nav-arrow">arrow_right</span>
                    <span class="material-symbols-outlined icon-nav">account_circle</span>
                    <span class="nav-link">マイページ/会員登録</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="nav-item">
                    <span class="material-symbols-outlined icon-nav-arrow">arrow_right</span>
                    <span class="material-symbols-outlined icon-nav">grid_view</span>
                    <span class="nav-link">プロフィール編集</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="nav-item">
                    <span class="material-symbols-outlined icon-nav-arrow">arrow_right</span>
                    <span class="material-symbols-outlined icon-nav">bookmark</span>
                    <span class="nav-link">コンタクト</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="nav-item">
                    <span class="material-symbols-outlined icon-nav-arrow">arrow_right</span>
                    <span class="material-symbols-outlined icon-nav">category</span>
                    <span class="nav-link">カテゴリー</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="nav-item">
                    <span class="material-symbols-outlined icon-nav-arrow">arrow_right</span>
                    <span class="material-symbols-outlined icon-nav">notifications_active</span>
                    <span class="nav-link">Likes</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="nav-item asocompass-link">
                    <span class="material-symbols-outlined icon-nav-arrow">arrow_right</span>
                    <span class="material-symbols-outlined icon-nav">help</span>
                    <span class="nav-link">Asocompassとは</span>
                  </a>
                </li>
                <div class="mt-auto d-flex justify-content-end pe-3 pb-3">
                  <a class="nav-link nav-logout" href="#">
                    ログアウト
                  </a>
                </div>
                <!-- Logout Confirmation Modal -->
                <div id="logoutModal" class="modal" aria-hidden="true">
                  <div class="modal-content">
                    <h4>本当にログアウトしますか？</h4>
                    <p>ログイン時のみ本サービスはご利用いただけます。</p>
                    <div class="modal-buttons">
                      <button id="confirmLogout" class="btn btn-primary">ログアウト</button>
                      <button id="cancelLogout" class="btn btn-secondary">キャンセル</button>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </nav>

      <!--
        explanation section
      -->
      <section class="explanation">
        <div class="container explanation-custom">
          <div class="d-flex justify-content-center align-items-center position-relative">
            <h1 class="explanation-headline ">Asocompassとは</h1>
            <div class="position-absolute d-flex justify-content-end align-items-center contents-close">
              <button class="icon-close-button"><span class="material-symbols-outlined icon-close">close</span></button>
            </div>
          </div>
          <hr style="height: 2px;">
          <h4 class="text-center lh-lg fw-normal">
            Asocompassは、有意義なつながりを築くためのプラットフォームです！<br>
            麻生の専門学校の中で気の合う誰かを見つけることができます。<br>
            心のままに新たな出会いを見つけましょう。<br>
            私たちはAsocompassを、すべての人が自分らしくありながら<br>
            新しい誰かと楽しく知り合える場所にしたいと思います。<br>
            <br>
            ＊ご利用者の問題行動に関しましては、厳格な処罰を検討いたします。
          </h4>
        </div>
      </section>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
          const helpButton = document.querySelector('.icon-help');
          const closeButton = document.querySelector('.icon-close-button');
          const explanationSection = document.querySelector('.explanation');
          const asocompassLink = document.querySelector('.asocompass-link');
  
          let isAnimating = false; // アニメーション中かどうかを追跡するフラグ
  
          function toggleExplanation() {
              if (isAnimating) return; // アニメーション中は何もしない
  
              isAnimating = true; // アニメーション開始
  
              if (explanationSection.classList.contains('show')) {
                  explanationSection.classList.remove('show');
                  setTimeout(() => {
                      explanationSection.style.display = 'none';
                      isAnimating = false; // アニメーション終了
                  }, 1000); // Explanation section will be hidden after the transition (1s)
              } else {
                  explanationSection.style.display = 'block';
                  setTimeout(() => {
                      explanationSection.classList.add('show');
                      isAnimating = false; // アニメーション終了
                  }, 10); // Delay to ensure the transition occurs
              }
          }
  
          helpButton.addEventListener('click', toggleExplanation);
          closeButton.addEventListener('click', toggleExplanation);
          asocompassLink.addEventListener('click', function(event) {
              event.preventDefault(); // デフォルトのリンク動作を無効化
              toggleExplanation();
          });

          //Logout-Javascript
          const logoutLink = document.querySelector('.nav-logout');
          const modal = document.getElementById('logoutModal');
          const confirmLogoutButton = document.getElementById('confirmLogout');
          const cancelLogoutButton = document.getElementById('cancelLogout');
  
          logoutLink.addEventListener('click', function(event) {
              event.preventDefault();
              modal.style.display = 'block';
          });
  
          confirmLogoutButton.addEventListener('click', function() {
              // ログアウト処理をここに追加
              window.location.href = 'login.php';
          });
  
          cancelLogoutButton.addEventListener('click', function() {
              modal.style.display = 'none';
          });
  
          window.addEventListener('click', function(event) {
              if (event.target == modal) {
                  modal.style.display = 'none';
              }
          });
      });
  </script>