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

//user_idを定義
$carts = get_user_carts($db, $user['user_id']);

//購入できない場合、エラー表示し、カート画面に戻る
  if(purchase_carts($db, $carts) === false){
    set_error('商品が購入できませんでした。');
    redirect_to(CART_URL);
  }

//合計金額を定義
$total_price = sum_carts($carts);

//tokenを定義
$token = get_post('token');
//照合に失敗したら購入画面に行かないようにする
//formから送信されたトークンと保存されているトークンが同じでないなら飛ばない
//購入完了画面へ
if (is_valid_csrf_token($token) === true){
  include_once '../view/finish_view.php';
} else {
  set_error('不正なリクエストです。');
  redirect_to(LOGIN_URL);
}