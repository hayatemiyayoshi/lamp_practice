<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';

session_start();

//ログインできなかったらログイン画面に戻る
if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);

//リクエストページ、管理者ページでない場合ログイン画面に戻る
if(is_admin($user) === false){
  redirect_to(LOGIN_URL);
}

//変更するitem_id,ステータスが飛んできたら定義
$item_id = get_post('item_id');
$changes_to = get_post('changes_to');

//openの場合はcloseにcloseの場合はopenに変更、それ以外はエラー表示
if($changes_to === 'open'){
  update_item_status($db, $item_id, ITEM_STATUS_OPEN);
  set_message('ステータスを変更しました。');
}else if($changes_to === 'close'){
  update_item_status($db, $item_id, ITEM_STATUS_CLOSE);
  set_message('ステータスを変更しました。');
}else {
  set_error('不正なリクエストです。');
}


redirect_to(ADMIN_URL);