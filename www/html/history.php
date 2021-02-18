<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'history.php';

session_start();
$token = get_csrf_token();

if(is_logined() === false){
    redirect_to(LOGIN_URL);
  }
  
$db = get_db_connect();
$user = get_login_user($db);

//user_idを定義
$histories = get_histories($db, $user['user_id']);
$admin_histories = get_admin_histories($db);

$order_id = get_post('order_id');

//購入履歴
include_once VIEW_PATH . 'history_view.php';

