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
if(get_get('order') === 'new'){
  $items = new_get_items($db, true);
//価格の安い順が送信されたら
}else if(get_get('order') === 'low'){
  $items = low_get_items($db, true);
//価格の高い順が送信されたら
}else if(get_get('order') === 'high'){
  $items = high_get_items($db, true);
}

//商品一覧画面へ
include_once VIEW_PATH . 'index_view.php';