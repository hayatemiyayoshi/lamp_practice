<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

session_start();

if(is_logined() === true){
  redirect_to(HOME_URL);
}

//ユーザー名とパスワードを定義
$name = get_post('name');
$password = get_post('password');

$db = get_db_connect();

//ユーザー名とパスワードが存在しない場合、エラー表示し、ログイン画面へ
$user = login_as($db, $name, $password);
if( $user === false){
  set_error('ログインに失敗しました。');
  redirect_to(LOGIN_URL);
}

//管理者の場合は管理ページへ、それ以外は商品一覧ページへ
set_message('ログインしました。');
if ($user['type'] === USER_TYPE_ADMIN){
  redirect_to(ADMIN_URL);
}
redirect_to(HOME_URL);