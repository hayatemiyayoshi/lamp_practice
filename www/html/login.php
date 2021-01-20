<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();
$token = get_csrf_token();

//ログインできたら商品一覧画面へ
if(is_logined() === true){
  redirect_to(HOME_URL);
}

//ログインページへ
include_once VIEW_PATH . 'login_view.php';

// seesionで保存されているのは何か
//formから送信されてきたのは何か
//照合する（一致しないといけない）