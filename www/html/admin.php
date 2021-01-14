<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

//セッションの開始
session_start();

//ログインできなかったらログイン画面に戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

//PDOを取得
$db = get_db_connect();

//PDOを利用してログインユーザーのデータを取得
$user = get_login_user($db);

//リクエストページ、管理者ページでない場合ログイン画面に戻る
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//商品管理画面に飛ぶ
$items = get_all_items($db);
//ビューの読み込み
include_once VIEW_PATH . '/admin_view.php';
