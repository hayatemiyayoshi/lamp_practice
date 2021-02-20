<?php
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//ユーザーごとの購入履歴
function get_histories($db, $user_id){
  //データバインドする
  //sumはasと一緒に使う
  //asの後に名前
  //日付は何もなしだと古い順
  $sql = "
    SELECT
      histories.order_id,
      histories.created,
      sum(details.price * details.amount) as total_price 
    FROM
      histories
    JOIN
      details
    ON
      histories.order_id = details.order_id
    WHERE
      histories.user_id = ?
    GROUP BY
      details.order_id
    ORDER BY
      histories.created DESC
  ";
  
  $params = array($user_id);
  return fetch_all_query($db, $sql, $params);
}

function get_admin_histories($db){
  $sql = "
    SELECT
      histories.order_id,
      histories.created,
      sum(details.price * details.amount) as total_price
    FROM
      histories
    JOIN
      details
    ON
      histories.order_id = details.order_id
    GROUP BY
      details.order_id
    ORDER BY
      histories.created DESC
  ";
     
  return fetch_all_query($db, $sql);
}

function get_history($db, $order_id){
  $sql = "
    SELECT
        histories.order_id,
        histories.created,
        sum(details.price * details.amount) as total_price,
        histories.user_id
      FROM
        histories
      JOIN
        details
      ON
        histories.order_id = details.order_id
      WHERE
        histories.order_id = ?
      GROUP BY
        details.order_id
    ";

    $params = array($order_id);
    return fetch_query($db, $sql, $params);
}