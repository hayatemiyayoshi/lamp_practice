<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//user_idが一致するユーザー情報の抽出
function get_user($db, $user_id){
  $sql = "
    SELECT
      user_id, 
      name,
      password,
      type
    FROM
      users
    WHERE
      user_id = ?
    LIMIT 1
  ";

  $params = array($user_id);
  return fetch_query($db, $sql, $params);
}

//名前が一致するユーザーの抽出
function get_user_by_name($db, $name){
  $sql = "
    SELECT
      user_id, 
      name,
      password,
      type
    FROM
      users
    WHERE
      name = ?
    LIMIT 1
  ";

  $params = array($name);
  return fetch_query($db, $sql, $params);
}

//ログイン時のユーザーの確認
function login_as($db, $name, $password){
  //ユーザー名が一致するユーザーを$userに代入
  $user = get_user_by_name($db, $name);
  //ユーザー名とパスワードが違ったらエラー表示
  if($user === false || $user['password'] !== $password){
    return false;
  }
  //ログインしていたらユーザー名の表示
  set_session('user_id', $user['user_id']);
  return $user;
}

//
function get_login_user($db){
  $login_user_id = get_session('user_id');

  return get_user($db, $login_user_id);
}

//ユーザー情報の登録
function regist_user($db, $name, $password, $password_confirmation) {
  //ユーザー情報が定義されているのと異なっていたらエラー表示
  if( is_valid_user($name, $password, $password_confirmation) === false){
    return false;
  }
  //ユーザーの登録
  return insert_user($db, $name, $password);
}

//管理者かユーザーかの確認
function is_admin($user){
  return $user['type'] === USER_TYPE_ADMIN;
}

//ユーザー登録時の確認
function is_valid_user($name, $password, $password_confirmation){
  // 短絡評価を避けるため一旦代入。
  $is_valid_user_name = is_valid_user_name($name);
  $is_valid_password = is_valid_password($password, $password_confirmation);
  return $is_valid_user_name && $is_valid_password ;
}

//ユーザー名の定義
function is_valid_user_name($name) {
  $is_valid = true;
  //ユーザー名の文字数定義
  if(is_valid_length($name, USER_NAME_LENGTH_MIN, USER_NAME_LENGTH_MAX) === false){
    set_error('ユーザー名は'. USER_NAME_LENGTH_MIN . '文字以上、' . USER_NAME_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  //ユーザー名の形式定義
  if(is_alphanumeric($name) === false){
    set_error('ユーザー名は半角英数字で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

//パスワードの定義
function is_valid_password($password, $password_confirmation){
  $is_valid = true;
  //パスワードの文字数定義
  if(is_valid_length($password, USER_PASSWORD_LENGTH_MIN, USER_PASSWORD_LENGTH_MAX) === false){
    set_error('パスワードは'. USER_PASSWORD_LENGTH_MIN . '文字以上、' . USER_PASSWORD_LENGTH_MAX . '文字以内にしてください。');
    $is_valid = false;
  }
  //パスワードの形式定義
  if(is_alphanumeric($password) === false){
    set_error('パスワードは半角英数字で入力してください。');
    $is_valid = false;
  }
  //パスワードが確認用と一致しているのかの確認
  if($password !== $password_confirmation){
    set_error('パスワードがパスワード(確認用)と一致しません。');
    $is_valid = false;
  }
  return $is_valid;
}

//ユーザー情報をデータベースに追加する
function insert_user($db, $name, $password){
  $sql = "
    INSERT INTO
      users(name, password)
    VALUES (?, ?);
  ";
  
  $params = array($name, $password);
  return execute_query($db, $sql, $params);
}

