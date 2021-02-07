<header>
  <nav class="navbar navbar-expand-sm navbar-light bg-light">
     <!-- 商品一覧画面へのリンク -->
    <a class="navbar-brand" href="<?php print(HOME_URL);?>">Market</a>
    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#headerNav" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="ナビゲーションの切替">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="headerNav">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
           <!-- カートへのリンク -->
          <a class="nav-link" href="<?php print(CART_URL);?>">カート</a>
        </li>
        <li class="nav-item">
           <!-- ログアウトへのリンク -->
          <a class="nav-link" href="<?php print(LOGOUT_URL);?>">ログアウト</a>
        </li>
         <!-- 管理者がログインしたら -->
        <?php if(is_admin($user)){ ?>
          <li class="nav-item">
             <!-- 商品管理へのリンク -->
            <a class="nav-link" href="<?php print(ADMIN_URL);?>">管理</a>
          </li>
        <?php } ?>
      </ul>
    </div>
  </nav>
  <!-- ユーザー名の表示 -->
  <p>ようこそ、<?php print($user['name']); ?>さん。</p>
</header>