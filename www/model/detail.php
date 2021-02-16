<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//ユーザーごとの購入詳細
function get_details($db, $order_id){
  //データバインドする
  $sql = "
    SELECT
      items.name,
      details.price,
      details.amount,
      sum(details.price * details.amount)
    FROM
      details
    JOIN
      items
    ON
      details.item_id = items.item_id
    WHERE
      details.order_id = ?
  ";

  $params = array($order_id);
  return fetch_query($db, $sql, $params);
}