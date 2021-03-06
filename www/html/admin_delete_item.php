<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);

if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//item_idが飛んできたら定義
$item_id = get_post('item_id');

$token = get_post('token');
//照合に失敗したら削除をできないようにする
//formから送信されたトークンと保存されているトークンが同じでないなら削除しない
//削除できたら完了メッセージ、できない時はエラー表示
if (is_valid_csrf_token($token) === true){
  if(destroy_item($db, $item_id) === true){
    set_message('商品を削除しました。');
  } else {
    set_error('商品削除に失敗しました。');
  }
} else {
  set_error('不正なリクエストです。');
  redirecut_to(LOGIN_URL);
}


//管理画面に戻る
redirect_to(ADMIN_URL);