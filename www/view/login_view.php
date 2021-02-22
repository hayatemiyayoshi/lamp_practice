<!DOCTYPE html>
<html lang="ja">
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ログイン</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'login.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <div class="container">
    <h1>ログイン</h1>
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
     <!-- ログイン情報の確認に飛ばす -->
    <form method="post" action="login_process.php" class="login_form mx-auto">
    <input type="hidden" name="token" value="<?php print $token ?>">  
      <div class="form-group">
         <!-- ユーザー名 -->
        <label for="name">名前: </label>
        <input type="text" name="name" id="name" class="form-control">
      </div>
      <div class="form-group">
         <!-- パスワード -->
        <label for="password">パスワード: </label>
        <input type="password" name="password" id="password" class="form-control">
      </div>
       <!-- ログインボタン -->
      <input type="submit" value="ログイン" class="btn btn-primary">
    </form>
  </div>
</body>
</html>