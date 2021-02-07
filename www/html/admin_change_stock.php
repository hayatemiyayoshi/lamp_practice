<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

//ログインできなかっらログイン画面に戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);

//リクエストページまたは管理者ページでなければログインページに戻る
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//飛んできたitem_id、stockを定義
$item_id = get_post('item_id');
$stock = get_post('stock');

//飛んできたtokenを定義
$token = get_post('token');
//照合に失敗したら在庫の更新をできないようにする
//formから送信されたトークンと保存されているトークンが同じでないなら更新しない
//item_id,stockの変更ができたら完了メッセージ、できない場合はエラー表示
if (is_valid_csrf_token($token) === true){
  if(update_item_stock($db, $item_id, $stock)){
    set_message('在庫数を変更しました。');
  } else {
    set_error('在庫数の変更に失敗しました。');
  }
} else {
  set_error('不正なリクエストです。');
  redirect_to(LOGIN_URL);
}

//管理画面に戻る
redirect_to(ADMIN_URL);