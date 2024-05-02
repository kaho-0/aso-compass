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
        <a class="icon-help" href="#" >
            <span class="material-symbols-outlined">help</span>
        </a>
        <a class="icon-account navbar-contents" href="#">
            <p>Mktarou</p>
            <span class="material-symbols-outlined">account_circle</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="material-symbols-outlined icon-density">density_medium</span>
        </button>
        </div>
        
        <!--sidebar-->
        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel" >
        <div class="offcanvas-body d-flex flex-column h-100">
            <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
                <a href="#" class="material-symbols-outlined icon-nav">grid_view</a>
                <a class="nav-link" href="#">マイページ/会員登録</a>
            </li>
            <li class="nav-item">
                <a href="#" class="material-symbols-outlined icon-nav">account_circle</a>
                <a class="nav-link" href="#">プロフィール編集</a>
            </li>
            <li class="nav-item">
                <a href="#" class="material-symbols-outlined icon-nav">bookmark</a>
                <a class="nav-link" href="#">お気に入り</a>
            </li>
            <li class="nav-item">
                <a href="#" class="material-symbols-outlined icon-nav">category</a>
                <a class="nav-link" href="#">カテゴリー</a>
            </li>
            <li class="nav-item">
                <a href="#" class="material-symbols-outlined icon-nav">notifications_active</a>
                <a class="nav-link" href="#">通知</a>
            </li>
            <li class="nav-item">
                <a href="#" class="material-symbols-outlined icon-nav">help</a>
                <a class="nav-link" href="#">Asocompassとは</a>
            </li>
            <div class="mt-auto d-flex justify-content-end pe-3 pb-3">
                <a class="nav-link nav-login" href="#">
                ログアウト
                </a>
            </div>
        </div>
        </div>
    </div>
</nav>