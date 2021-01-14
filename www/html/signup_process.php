<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';

//セッション開始
session_start();

//ログインしていない場合はログインページへ
if(is_logined() === true){
  redirect_to(HOME_URL);
}

//ユーザー名、パスワード、確認用パスワードを定義
$name = get_post('name');
$password = get_post('password');
$password_confirmation = get_post('password_confirmation');

//PDOを取得
$db = get_db_connect();


try{
  //ユーザー名、パスワードが条件を満たしていない場合、エラー表示
  $result = regist_user($db, $name, $password, $password_confirmation);
  if( $result=== false){
    set_error('ユーザー登録に失敗しました。');
    redirect_to(SIGNUP_URL);
  }
  //エラー表示
}catch(PDOException $e){
  set_error('ユーザー登録に失敗しました。');
  redirect_to(SIGNUP_URL);
}

//登録できた場合、商品一覧画面へ
set_message('ユーザー登録が完了しました。');
login_as($db, $name, $password);
redirect_to(HOME_URL);