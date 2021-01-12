<!DOCTYPE html>
<html lang="ja">
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>サインアップ</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print (STYLESHEET_PATH . 'signup.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/header.php'; ?>
  <div class="container">
    <h1>ユーザー登録</h1>
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
     <!-- ユーザー登録情報確認に飛ばす  -->
    <form method="post" action="signup_process.php" class="signup_form mx-auto">
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
      <div class="form-group">
         <!-- 確認用パスワード -->
        <label for="password_confirmation">パスワード（確認用）: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
      </div>
       <!-- 登録ボタン -->
      <input type="submit" value="登録" class="btn btn-primary">
    </form>
  </div>
</body>
</html>