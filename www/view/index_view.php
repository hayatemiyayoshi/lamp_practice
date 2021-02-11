<!DOCTYPE html>
<html lang="ja">
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
    <h1>商品一覧</h1>
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <div class="card-deck">
      <div class="row">
       <!-- 商品の数だけ回す -->
      <?php foreach($items as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
               <!-- 商品名の表示 -->
              <?php print h($item['name']); ?>
            </div>
            <figure class="card-body">
               <!-- 商品画像の表示 -->
              <img class="card-img" src="<?php print(IMAGE_PATH . $item['image']); ?>">
              <figcaption>
                 <!-- 金額の表示 -->
                <?php print(number_format($item['price'])); ?>円
                 <!-- 在庫があったら -->
                <?php if($item['stock'] > 0){ ?>
                   <!-- カートに追加フォームに飛ばす -->
                  <form action="index_add_cart.php" method="post">
                  <input type="hidden" name="token" value="<?php print $token?>">
                     <!-- 追加ボタン -->
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                     <!-- item_idも同時に飛ばす -->
                    <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
                  </form>
                 <!-- 在庫がなかったら -->
                <?php } else { ?>
                   <!-- 売切れ表示 -->
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  
</body>
</html>