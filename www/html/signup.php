<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';

//セッション開始
session_start();

//ログインチェックし、していない場合はログインページへ
if(is_logined() === true){
  redirect_to(HOME_URL);
}

//ビューの読み込み
include_once VIEW_PATH . 'signup_view.php';



