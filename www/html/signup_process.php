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
  //照合に失敗したら登録できないようにする
  //formから送信されたトークンと保存されているトークンが同じでないなら登録しない
  if (is_valid_csrf_token($token) === true){
    //ユーザー名、パスワードが条件を満たしていない場合、エラー表示
    $result = regist_user($db, $name, $password, $password_confirmation);
    if( $result=== false){
      set_error('ユーザー登録に失敗しました。');
      redirect_to(SIGNUP_URL);
    }
  } else {
    set_error('不正なリクエストです。');
    redirect_to(LOGIN_URL);
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