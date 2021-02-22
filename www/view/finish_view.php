<!DOCTYPE html>
<html lang="ja">
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>ご購入ありがとうございました！</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>ご購入ありがとうございました！</h1>

  <div class="container">
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
     <!-- カートに商品が入っていたら  -->
    <?php if(count($carts) > 0){ ?>
      <table class="table table-bordered">
        <thead class="thead-light">
          <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>購入数</th>
            <th>小計</th>
          </tr>
        </thead>
        <tbody>
           <!-- カート内の商品の数まで回す -->
          <?php foreach($carts as $cart){ ?>
          <tr>
             <!-- 商品画像の表示 -->
            <td><img src="<?php print(IMAGE_PATH . $cart['image']);?>" class="item_image"></td>
             <!-- 商品名の表示 -->
            <td><?php print h($cart['name']); ?></td>
             <!-- 金額の表示 -->
            <td><?php print(number_format($cart['price'])); ?>円</td>
             <!-- 在庫数の表示 -->
            <td>
                <?php print($cart['amount']); ?>個
            </td>
             <!-- 現段階の合計金額の表示 -->
            <td><?php print(number_format($cart['price'] * $cart['amount'])); ?>円</td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
       <!-- 合計金額の表示 -->
      <p class="text-right">合計金額: <?php print number_format($total_price); ?>円</p>
     <!-- カート内に商品がなかったら -->
    <?php } else { ?>
      <p>カートに商品はありません。</p>
    <?php } ?> 
  </div>
</body>
</html>