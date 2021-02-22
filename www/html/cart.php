<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';

session_start();
$token = get_csrf_token();

//ログインできなかったらログイン画面に戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

//データベースを定義
$db = get_db_connect();
$user = get_login_user($db);

//カートに入る商品を定義
$carts = get_user_carts($db, $user['user_id']);

//合計金額を定義
$total_price = sum_carts($carts);

//カート画面に飛ぶ
include_once VIEW_PATH . 'cart_view.php';