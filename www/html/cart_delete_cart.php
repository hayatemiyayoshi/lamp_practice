<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

//変更するitem_idを定義
$cart_id = get_post('cart_id');

//tokenを定義
$token = get_post('token');
//照合に失敗したら商品の削除をできないようにする
//formから送信されたトークンと保存されているトークンが同じでないなら削除しない
//削除が完了したらメッセージ、できない場合はエラー表示
if (is_valid_csrf_token($token) === true){
  if(delete_cart($db, $cart_id)){
    set_message('カートを削除しました。');
  } else {
    set_error('カートの削除に失敗しました。');
  }
} else {
  set_error('不正なリクエストです。');
  redirect_to(LOGIN_URL);
}

//カート画面に戻る
redirect_to(CART_URL);