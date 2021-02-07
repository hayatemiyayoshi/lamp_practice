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

//変更するitem_id,数量を定義
$cart_id = get_post('cart_id');
$amount = get_post('amount');

//tokenを定義
$token = get_post('token');
//照合に失敗したら購入数の更新をできないようにする
//formから送信されたトークンと保存されているトークンが同じでないなら更新しない
//変更できたら完了メッセージ、できない場合はエラー表示
if (is_valid_csrf_token($token) === true){
  if(update_cart_amount($db, $cart_id, $amount)){
    set_message('購入数を更新しました。');
  } else {
    set_error('購入数の更新に失敗しました。');
  }
} else {
  set_error('不正なリクエストです。');
  redirect_to(LOGIN_URL);
}

//カート画面に戻る
redirect_to(CART_URL);