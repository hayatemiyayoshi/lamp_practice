<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

//セッションの開始
session_start();
//セッション変数を削除
$_SESSION = array();
//sessionに関する設定を取得
$params = session_get_cookie_params();
//セッションに利用しているクッキーの有効期限を過去にすることで無効化
setcookie(session_name(), '', time() - 42000,
  $params["path"], 
  $params["domain"],
  $params["secure"], 
  $params["httponly"]
);
//セッションIDを無効化
session_destroy();
//ログインページへ
redirect_to(LOGIN_URL);

