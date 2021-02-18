<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'detail.php';

session_start();
$token = get_csrf_token();

if(is_logined() === false){
    redirect_to(LOGIN_URL);
  }
  
$db = get_db_connect();
$user = get_login_user($db);

//order_idを定義
$order_id = get_post('order_id');
$details = get_details($db, $order_id);

$histories = array();

//購入履歴
include_once VIEW_PATH . 'detail_view.php';