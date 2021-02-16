<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

//ユーザーごとの購入履歴
function get_histories($db, $user_id){
  //データバインドする
  $sql = "
    SELECT
      histories.order_id,
      histries.created,
      sum(details.price * details.amount) 
    FROM
      histories
    JOIN
      details
    ON
      histories.order_id = details.order_id
    WHERE
      histories.order_id = ?
    ORDER BY
      histories.created
  ";
  
  $params = array($user_id);
  return fetch_query($db, $sql, $params);
}