<?php

//Mファイル,Vファイルを定義
define('MODEL_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../model/');
define('VIEW_PATH', $_SERVER['DOCUMENT_ROOT'] . '/../view/');

//画像ファイル、cssを定義
define('IMAGE_PATH', '/assets/images/');
define('STYLESHEET_PATH', '/assets/css/');
define('IMAGE_DIR', $_SERVER['DOCUMENT_ROOT'] . '/assets/images/' );

//データベースのユーザー名、パスワードを定義
define('DB_HOST', 'mysql');
define('DB_NAME', 'sample');
define('DB_USER', 'testuser');
define('DB_PASS', 'password');
define('DB_CHARSET', 'utf8');

//modelを定義
define('SIGNUP_URL', '/signup.php');
define('LOGIN_URL', '/login.php');
define('LOGOUT_URL', '/logout.php');
define('HOME_URL', '/index.php');
define('CART_URL', '/cart.php');
define('FINISH_URL', '/finish.php');
define('ADMIN_URL', '/admin.php');
define('HISTORY_URL', '/history.php')
define('DETAIL_URL', '/detail.php')

//正規表現を定義
define('REGEXP_ALPHANUMERIC', '/\A[0-9a-zA-Z]+\z/');
define('REGEXP_POSITIVE_INTEGER', '/\A([1-9][0-9]*|0)\z/');

//文字列の長さを定義
define('USER_NAME_LENGTH_MIN', 6);
define('USER_NAME_LENGTH_MAX', 100);
define('USER_PASSWORD_LENGTH_MIN', 6);
define('USER_PASSWORD_LENGTH_MAX', 100);

//ユーザーのタイプを定義
define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_NORMAL', 2);

//商品名の長さを定義
define('ITEM_NAME_LENGTH_MIN', 1);
define('ITEM_NAME_LENGTH_MAX', 100);

//公開、非公開を定義
define('ITEM_STATUS_OPEN', 1);
define('ITEM_STATUS_CLOSE', 0);

//ステータスの公開非公開を定義
define('PERMITTED_ITEM_STATUSES', array(
  'open' => 1,
  'close' => 0,
));

//画層ファイルのの形式を定義
define('PERMITTED_IMAGE_TYPES', array(
  IMAGETYPE_JPEG => 'jpg',
  IMAGETYPE_PNG => 'png',
));

