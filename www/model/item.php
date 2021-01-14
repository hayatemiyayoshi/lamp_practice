<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// DB利用
//商品一覧データベースから抽出
function get_item($db, $item_id){
  $sql = "
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
    WHERE
      item_id = {$item_id}
  ";

  return fetch_query($db, $sql);
}

//公開している商品の抽出
function get_items($db, $is_open = false){
  $sql = '
    SELECT
      item_id, 
      name,
      stock,
      price,
      image,
      status
    FROM
      items
  ';
  if($is_open === true){
    $sql .= '
      WHERE status = 1
    ';
  }

  return fetch_all_query($db, $sql);
}

//商品一覧の表示
function get_all_items($db){
  return get_items($db);
}

//公開している商品の表示
function get_open_items($db){
  return get_items($db, true);
}

//商品の登録
function regist_item($db, $name, $price, $stock, $status, $image){
  //画像ファイルの取得
  $filename = get_upload_filename($image);
  //商品の情報がない時はエラー
  if(validate_item($name, $price, $stock, $filename, $status) === false){
    return false;
  }
  //商品を登録する
  return regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename);
}

//商品と画像の登録
function regist_item_transaction($db, $name, $price, $stock, $status, $image, $filename){
  //トランザクション開始
  $db->beginTransaction();
  //商品の情報と画像が正しい時に登録
  if(insert_item($db, $name, $price, $stock, $filename, $status) 
    && save_image($image, $filename)){
    $db->commit();
    return true;
  }
  //エラー表示
  $db->rollback();
  return false;
  
}

//商品の追加
function insert_item($db, $name, $price, $stock, $filename, $status){
  //公開、非公開の設定
  $status_value = PERMITTED_ITEM_STATUSES[$status];
  //商品の追加
  $sql = "
    INSERT INTO
      items(
        name,
        price,
        stock,
        image,
        status
      )
    VALUES('{$name}', {$price}, {$stock}, '{$filename}', {$status_value});
  ";

  return execute_query($db, $sql);
}

//ステータスの更新
function update_item_status($db, $item_id, $status){
  $sql = "
    UPDATE
      items
    SET
      status = {$status}
    WHERE
      item_id = {$item_id}
    LIMIT 1
  ";
  
  return execute_query($db, $sql);
}

// エスケープ処理
//在庫数の更新
function update_item_stock($db, $item_id, $stock){
  $sql = "
    UPDATE
      items
    SET
      stock = ?
    WHERE
      item_id = ?
    LIMIT 1
  ";
  
  $params = array($stock, $item_id);
  return execute_query($db, $sql, $params);
}

//商品の削除
function destroy_item($db, $item_id){
  $item = get_item($db, $item_id);
  //商品がなかったらエラー表示
  if($item === false){
    return false;
  }
  //トランザクション開始
  $db->beginTransaction();
  //商品を画像を削除
  if(delete_item($db, $item['item_id'])
    && delete_image($item['image'])){
    $db->commit();
    return true;
  }
  $db->rollback();
  return false;
}

//商品の削除
function delete_item($db, $item_id){
  //商品のitem_idを選択
  $sql = "
    DELETE FROM
      items
    WHERE
      item_id = {$item_id}
    LIMIT 1
  ";
  
  return execute_query($db, $sql);
}


// 非DB
//公開ステータスを１かどうか　１だったらtrue
function is_open($item){
  return $item['status'] === 1;
}

//商品の情報を定義
function validate_item($name, $price, $stock, $filename, $status){
  $is_valid_item_name = is_valid_item_name($name);
  $is_valid_item_price = is_valid_item_price($price);
  $is_valid_item_stock = is_valid_item_stock($stock);
  $is_valid_item_filename = is_valid_item_filename($filename);
  $is_valid_item_status = is_valid_item_status($status);
  //商品の情報表示
  return $is_valid_item_name
    && $is_valid_item_price
    && $is_valid_item_stock
    && $is_valid_item_filename
    && $is_valid_item_status;
}

//
function is_valid_item_name($name){
  $is_valid = true;
  //商品名の定義
  if(is_valid_length($name, ITEM_NAME_LENGTH_MIN, ITEM_NAME_LENGTH_MAX) === false){
    set_error('商品名は'. ITEM_NAME_LENGTH_MIN . '文字以上、' . ITEM_NAME_LENGTH_MAX . '文字以内にしてください。');
    //エラー表示
    $is_valid = false;
  }
  //商品名を表示
  return $is_valid;
}

//金額の定義
function is_valid_item_price($price){
  $is_valid = true;
  if(is_positive_integer($price) === false){
    set_error('価格は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

//在庫数の定義
function is_valid_item_stock($stock){
  $is_valid = true;
  if(is_positive_integer($stock) === false){
    set_error('在庫数は0以上の整数で入力してください。');
    $is_valid = false;
  }
  return $is_valid;
}

//ファイル名の定義
function is_valid_item_filename($filename){
  $is_valid = true;
  if($filename === ''){
    $is_valid = false;
  }
  return $is_valid;
}

//ステータスの定義
function is_valid_item_status($status){
  $is_valid = true;
  if(isset(PERMITTED_ITEM_STATUSES[$status]) === false){
    $is_valid = false;
  }
  return $is_valid;
}