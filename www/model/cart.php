<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//item_idが一致している商品とカート内の商品を抽出する
function get_user_carts($db, $user_id){
  // データバインドする
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
  ";
  return fetch_all_query($db, $sql);
}

//user_idとitem_idが一致している商品を抽出する
function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = {$user_id}
    AND
      items.item_id = {$item_id}
  ";

  return fetch_query($db, $sql);

}

//カート内に商品がなかったら追加し、あったら＋１する
function add_cart($db, $user_id, $item_id ) {
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    return insert_cart($db, $user_id, $item_id);
  }
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}

//カート内に商品を追加する
function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES({$item_id}, {$user_id}, {$amount})
  ";

  return execute_query($db, $sql);
}

//カート内の商品を＋１する
function update_cart_amount($db, $cart_id, $amount){
  $sql = "
    UPDATE
      carts
    SET
      amount = {$amount}
    WHERE
      cart_id = {$cart_id}
    LIMIT 1
  ";
  return execute_query($db, $sql);
}

//商品を削除する
function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = {$cart_id}
    LIMIT 1
  ";

  return execute_query($db, $sql);
}

//商品を購入する
function purchase_carts($db, $carts){
  //$cartsがなかったらエラー
  if(validate_cart_purchase($carts) === false){
    return false;
  }
  
  //データベースに接続できなかったらエラー表示、できたら数量をカウント
  foreach($carts as $cart){
    if(update_item_stock(
        $db, 
        $cart['item_id'], 
        $cart['stock'] - $cart['amount']
      ) === false){
      set_error($cart['name'] . 'の購入に失敗しました。');
    }
  }
  //ユーザーのカートから商品を削除
  delete_user_carts($db, $carts[0]['user_id']);
}

//ユーザーのカートから商品を削除
function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = {$user_id}
  ";

  execute_query($db, $sql);
}

//購入金額の表示
function sum_carts($carts){
  //0に定義
  $total_price = 0;
  //商品の数だけ回す
  foreach($carts as $cart){
    //合計金額の計算
    $total_price += $cart['price'] * $cart['amount'];
  }
  //合計金額を返す
  return $total_price;
}

//
function validate_cart_purchase($carts){
  //カート内の商品が０だったらエラー表示
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  
  //購入関数
  foreach($carts as $cart){
    //非公開はエラー表示
    if(is_open($cart) === false){
      set_error($cart['name'] . 'は現在購入できません。');
    }
    //在庫がなかったらエラー表示
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  //エラーがあったらエラー表示
  if(has_error() === true){
    return false;
  }
  return true;
}

