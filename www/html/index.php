<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();
$token = get_csrf_token();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

//公開している商品の表示
$items = get_open_items($db);

//新着順が送信されたら
if(get_get('new')){
  $items = new_get_items($db);
//価格の安い順が送信されたら
}else if(get_get('low')){
  $items = low_get_items($db);
//価格の高い順が送信されたら
}else if(get_get('high')){
  $items = high_get_items($db);
}

//tokenを定義
$token = get_post('token');
//照合に失敗したら商品の追加をできないようにする
//formから送信されたトークンと保存されているトークンが同じでないなら追加しない
//カートに追加した場合メッセージ、できない場合はエラー表示
if (is_valid_csrf_token($token) === true){
  if(add_cart($db,$user['user_id'], $item_id)){
    set_message('並び替えました');
  } else {
    set_error('並び替えに失敗しました。');
  }
} else {
  set_error('不正なリクエストです。');
  redirect_to(LOGIN_URL);
}

// if(isset($_GET['new']) === true){

// 価格の安い順が送信されたら
// }else if(isset($_GET['low']) === true){

// 価格の高い順が送信されたら
// }else if(isset($_GET['high']) === true){

// }else{
//   set_error('');
// }
//商品一覧画面へ
include_once VIEW_PATH . 'index_view.php';