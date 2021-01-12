<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

session_start();

//ログインできたら商品一覧画面へ
if(is_logined() === true){
  redirect_to(HOME_URL);
}

//ログインページへ
include_once VIEW_PATH . 'login_view.php';