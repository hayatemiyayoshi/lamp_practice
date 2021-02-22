<!DOCTYPE html>
<html lang="ja">
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>カート</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'cart.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>カート</h1>
  <div class="container">
    
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    
     <!-- カートに商品が入っていたら -->
    <?php if(count($carts) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>購入数</th>
            <th>小計</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
           <!-- カート内の商品の数だけ回す -->
          <?php foreach($carts as $cart){ ?>
          <tr>
             <!-- 商品画像の表示 -->
            <td><img src="<?php print(IMAGE_PATH . $cart['image']);?>" class="item_image"></td>
             <!-- 商品名の表示 -->
            <td><?php print h($cart['name']); ?></td>
             <!-- 金額の表示 -->
            <td><?php print(number_format($cart['price'])); ?>円</td>
             <!-- 数量 -->
            <td>
               <!-- 数量変更時に飛ばす -->
              <form method="post" action="cart_change_amount.php">
              <input type="hidden" name="token" value="<?php print $token ?>">
                 <!-- 現状の数量の表示 -->
                <input type="number" name="amount" value="<?php print($cart['amount']); ?>">
                個
                 <!-- 変更ボタン -->
                <input type="submit" value="変更" class="btn btn-secondary">
                 <!-- cart_idも同時に飛ばす -->
                <input type="hidden" name="cart_id" value="<?php print($cart['cart_id']); ?>">
              </form>
            </td>
             <!-- 合計金額の表示 -->
            <td><?php print(number_format($cart['price'] * $cart['amount'])); ?>円</td>
            <td>
               <!-- 削除を押した時に飛ばす -->
              <form method="post" action="cart_delete_cart.php">
              <input type="hidden" name="token" value="<?php print $token ?>">
                 <!-- 削除ボタン -->
                <input type="submit" value="削除" class="btn btn-danger delete">
                 <!-- cart_idも同時に飛ばす -->
                <input type="hidden" name="cart_id" value="<?php print($cart['cart_id']); ?>">
              </form>

            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
       <!-- 合計金額の表示 -->
      <p class="text-right">合計金額: <?php print number_format($total_price); ?>円</p>
       <!-- 購入画面に飛ばす -->
      <form method="post" action="finish.php">
      <input type="hidden" name="token" value="<?php print $token ?>">
         <!-- 購入ボタン -->
        <input class="btn btn-block btn-primary" type="submit" value="購入する">
      </form>
     <!-- カートに商品がなかったら -->
    <?php } else { ?>
       <!-- メッセージの表示 -->
      <p>カートに商品はありません。</p>
    <?php } ?> 
  </div>
   <!-- 削除の確認 -->
  <script>
    $('.delete').on('click', () => confirm('本当に削除しますか？'))
  </script>
</body>
</html>