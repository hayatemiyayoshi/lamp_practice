<?php

function dd($var){
  var_dump($var);
  exit();
}

//$urlに飛ばす
function redirect_to($url){
  header('Location: ' . $url);
  exit;
}

//$GETで$nameが飛ばされたら$_GET[$name]を返す関数get_getを作成
function get_get($name){
  if(isset($_GET[$name]) === true){
    return $_GET[$name];
  };
  return '';
}

//＄POSTで$nameが飛ばされたら$_POST[$name]を返す関数get_postを作成
function get_post($name){
  if(isset($_POST[$name]) === true){
    return $_POST[$name];
  };
  return '';
}

//$_FILESで$nameが飛ばされたら$_FILES[$name]返す関数get_fileを作成
function get_file($name){
  if(isset($_FILES[$name]) === true){
    return $_FILES[$name];
  };
  return array();
}

//$_SESSIONで$nameが飛ばされたら$_SESSION[$name]返す関数get_sessionを作成
function get_session($name){
  if(isset($_SESSION[$name]) === true){
    return $_SESSION[$name];
  };
  return '';
}

//$valueを$_SESSION[$name]に定義する関数set_sessionを作成
function set_session($name, $value){
  $_SESSION[$name] = $value;
}

//$errorを$_SESSION['__errors'][]に定義する関数set_errorを作成
function set_error($error){
  $_SESSION['__errors'][] = $error;
}

//$errorsが存在しなかったら何も返さない。存在した場合には$errorsにget_session('__errors')を代入
function get_errors(){
  $errors = get_session('__errors');
  if($errors === ''){
    return array();
  }
  set_session('__errors',  array());
  return $errors;
}
//$_SESSION['__errors']が存在し、$_SESSION['__errors']が０でないことを返す関数has_error()を定義する
function has_error(){
  return isset($_SESSION['__errors']) && count($_SESSION['__errors']) !== 0;
}

//$_SESSION['__message'][]を$messageに代入する関数set_messageを定義する
function set_message($message){
  $_SESSION['__messages'][] = $message;
}

//get_session('__message')が空白の場合何も返さず、それ以外の場合は$messageに代入し、$messageを返す
function get_messages(){
  $messages = get_session('__messages');
  if($messages === ''){
    return array();
  }
  set_session('__messages',  array());
  return $messages;
}

//ログインしているのかの確認
function is_logined(){
  return get_session('user_id') !== '';
}

//ファイルが飛んで来なかったらエラー、飛んできたらファイル名を作成
function get_upload_filename($file){
  if(is_valid_upload_image($file) === false){
    return '';
  }
  $mimetype = exif_imagetype($file['tmp_name']);
  $ext = PERMITTED_IMAGE_TYPES[$mimetype];
  return get_random_string() . '.' . $ext;
}

//ランダム文字数（長い）　先頭の２０文字を返す
function get_random_string($length = 20){
  return substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, $length);
}

//
function save_image($image, $filename){
  return move_uploaded_file($image['tmp_name'], IMAGE_DIR . $filename);
}

function delete_image($filename){
  if(file_exists(IMAGE_DIR . $filename) === true){
    unlink(IMAGE_DIR . $filename);
    return true;
  }
  return false;
  
}



function is_valid_length($string, $minimum_length, $maximum_length = PHP_INT_MAX){
  $length = mb_strlen($string);
  return ($minimum_length <= $length) && ($length <= $maximum_length);
}

function is_alphanumeric($string){
  return is_valid_format($string, REGEXP_ALPHANUMERIC);
}

function is_positive_integer($string){
  return is_valid_format($string, REGEXP_POSITIVE_INTEGER);
}

function is_valid_format($string, $format){
  return preg_match($format, $string) === 1;
}

//POSTで飛ばされたファイルが存在すしないならエラーを表示、ファイル形式が間違っていたならエラー表示
function is_valid_upload_image($image){
  if(is_uploaded_file($image['tmp_name']) === false){
    set_error('ファイル形式が不正です。');
    return false;
  }
  $mimetype = exif_imagetype($image['tmp_name']);
  if( isset(PERMITTED_IMAGE_TYPES[$mimetype]) === false ){
    set_error('ファイル形式は' . implode('、', PERMITTED_IMAGE_TYPES) . 'のみ利用可能です。');
    return false;
  }
  return true;
}

//エスケープ処理関数
function h($str) {

  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}