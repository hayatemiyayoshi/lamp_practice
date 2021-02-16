<!DOCTYPE html>
<html lang="ja">
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'detail.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入明細</h1>
  <div class="container">
    
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

     <!-- 購入明細 -->
    <table>
      <thead>
        <tr>
          <th>注文番号</th>
          <th>購入日時</th>
          <th>合計金額</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($histories as $history) {?>
        <tr>
          <!-- 注文番号 -->
          <td><?php print $history['order_id']; ?></td>
          <!-- 購入日時 -->
          <td><?php print $history['created']; ?></td> 
          <!-- 合計金額の表示???　-->
          <td><?php print(number_format($history['']); ?></td>
          <td>
            <!-- 購入明細表示へ -->
            <form method="post" action="history.php">
              <!-- トークン　-->
              <input type="hidden" name="token" value="<?php print $token ?>">
              <!-- 購入明細表示ボタン -->
              <input type="submit" value="購入明細表示">
              <!-- order_idも飛ばす -->
              <input type="hidden" name="order_id" value="<?php print($history['order_id']); ?>">
            </form>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table> 
    <?php }else{ ?>
    <p>購入履歴がありません。</p>
    <?php } ?>
    
    <!-- 購入明細 -->
    <table>
      <thead>
        <tr>
          <th>商品名</th>
          <th>価格</th>
          <th>購入数</th>
          <th>小計</th>
        </tr>
      </thead>
      <tbody>
      <!-- 購入履歴を回す -->
      <?php foreach($details as $detail){ ?>
        <tr>
          <!-- 商品名 -->
          <td><?php print h($detail['name']); ?></td>
          <!-- 価格 -->
          <td><?php print ($detail['price']); ?></td>
          <!-- 購入数 -->
          <td><?php print ($detail['amount']); ?></td>
          <!-- 小計 -->
          <td><?php print (number_format($history['']); ?></td>
        </tr>    
      <?php } ?>
      </tbody>
    </table>
  </body>
</html>