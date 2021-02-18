<!DOCTYPE html>
<html lang="ja">
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'history.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>
  <div class="container">
    
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

     <!-- 購入履歴があったら -->
    <?php if(count($histories) > 0) {?>
    <table>
      <thead>
        <tr>
          <th>注文番号</th>
          <th>購入日時</th>
          <th>注文の合計金額</th>
        </tr>
      </thead>
      <tbody>
      <?php if(is_admin($user)){ ?>
        <?php foreach ($admin_histories as $admin_history){ ?>
        <tr>
            <!-- 注文番号 -->
            <td><?php print $admin_histories['order_id']; ?></td>
            <!-- 購入日時 -->
            <td><?php print $admin_histories['created']; ?></td> 
            <!-- 合計金額の表示　-->
            <td><?php print(number_format($admin_histories['total_price'])); ?></td>
            <td>
              <!-- 購入明細表示へ -->
              <form method="post" action="detail.php">
                <!-- トークン　-->
                <input type="hidden" name="token" value="<?php print $token ?>">
                <!-- 購入明細表示ボタン -->
                <input type="submit" value="購入明細表示">
                <!-- order_idも飛ばす -->
                <input type="hidden" name="order_id" value="<?php print($admin_histories['order_id']); ?>">
              </form>
            </td>
          </tr>
        <?php } ?>
      <?php }else{ ?>
        <?php foreach($histories as $history) {?>
          <tr>
            <!-- 注文番号 -->
            <td><?php print $history['order_id']; ?></td>
            <!-- 購入日時 -->
            <td><?php print $history['created']; ?></td> 
            <!-- 合計金額の表示　-->
            <td><?php print(number_format($history['total_price'])); ?></td>
            <td>
              <!-- 購入明細表示へ -->
              <form method="post" action="detail.php">
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
      <?php } ?>
      </tbody>
    </table> 
    <?php }else{ ?>
    <p>購入履歴がありません。</p>
    <?php } ?>
  </body>
</html>