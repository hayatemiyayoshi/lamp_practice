 <!-- DOCTYPE宣言 -->
<!DOCTYPE html>
 <!-- 日本語 -->
<html lang="ja">
 <!-- ヘッダー -->
<head>
   <!-- ビューの読み込み -->
  <?php include VIEW_PATH . 'templates/head.php'; ?>
   <!-- タイトル -->
  <title>商品管理</title>
   <!-- cssの読み込み -->
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'admin.css'); ?>">
</head>
<body>
   <!-- ビューの読み込み -->
  <?php 
  include VIEW_PATH . 'templates/header_logined.php'; 
  ?>

  <div class="container">
     <!-- 見出し -->
    <h1>商品管理</h1>
     <!-- ビューの読み込み -->
    <?php include VIEW_PATH . 'templates/messages.php'; ?>
    
     <!-- 商品追加フォーム -->
    <form 
      method="post"
      action="admin_insert_item.php" 
      enctype="multipart/form-data"
      class="add_item_form col-md-6">
      <div class="form-group">
         <!-- 名前の記入 -->
        <label for="name">名前: </label>
        <input class="form-control" type="text" name="name" id="name">
      </div>
      <div class="form-group">
         <!-- 価格の記入 -->
        <label for="price">価格: </label>
        <input class="form-control" type="number" name="price" id="price">
      </div>
      <div class="form-group">
         <!-- 在庫数の記入 -->
        <label for="stock">在庫数: </label>
        <input class="form-control" type="number" name="stock" id="stock">
      </div>
      <div class="form-group">
         <!-- 画像の登録 -->
        <label for="image">商品画像: </label>
        <input type="file" name="image" id="image">
      </div>
      <div class="form-group">
         <!-- ステータスの選択 -->
        <label for="status">ステータス: </label>
        <select class="form-control" name="status" id="status">
          <option value="open">公開</option>
          <option value="close">非公開</option>
        </select>
      </div>
       <!-- 商品追加ボタン -->
      <input type="submit" value="商品追加" class="btn btn-primary">
    </form>

     <!-- 商品が１つでもあったら表を表示 -->
    <?php if(count($items) > 0){ ?>
      <table class="table table-bordered text-center">
        <thead class="thead-light">
          <tr>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
           <!-- 商品の数だけ回す -->
          <?php foreach($items as $item){ ?>
           
          <!-- 三項演算子 　?の前true or false(条件文) trueだったら:の前を実行 falseは:のあとを実行 -->
          <tr class="<?php print h(is_open($item) ? '' : 'close_item'); ?>">
             <!-- 画像の表示 -->
            <td><img src="<?php print h(IMAGE_PATH . $item['image']);?>" class="item_image"></td>
             <!-- 商品名の表示 -->
            <td><?php print h($item['name']); ?></td>
             <!-- 金額の表示 -->
            <td><?php print (number_format($item['price'])); ?>円</td>
             <!-- 在庫数の表示 -->
            <td>
               <!-- 在庫数変更を飛ばす -->
              <form method="post" action="admin_change_stock.php">
                <div class="form-group">
                  <!-- sqlインジェクション確認のためあえてtext -->
                   <!-- 在庫数の表示 -->
                  <input  type="text" name="stock" value="<?php print($item['stock']); ?>">
                  個
                </div>
                 <!-- 変更ボタン -->
                <input type="submit" value="変更" class="btn btn-secondary">
                 <!-- item_idを同時に飛ばす -->
                <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
              </form>
            </td>
            <td>
               <!-- ステータスの変更を飛ばす -->
              <form method="post" action="admin_change_status.php" class="operation">
                 <!-- 公開だったら非公開に変更する -->
                <?php if(is_open($item) === true){ ?>
                  <input type="submit" value="公開 → 非公開" class="btn btn-secondary">
                  <input type="hidden" name="changes_to" value="close">
                 <!-- 非公開だったら公開に変更する -->
                <?php } else { ?>
                  <input type="submit" value="非公開 → 公開" class="btn btn-secondary">
                  <input type="hidden" name="changes_to" value="open">
                <?php } ?>
                 <!-- item_idも同時に飛ばす -->
                <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
              </form>
              
               <!-- 商品の削除 -->
              <form method="post" action="admin_delete_item.php">
                 <!-- 削除ボタン -->
                <input type="submit" value="削除" class="btn btn-danger delete">
                 <!-- item_idを同時に飛ばす -->
                <input type="hidden" name="item_id" value="<?php print($item['item_id']); ?>">
              </form>

            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
       <!-- 商品がなかったらメッセージ -->
    <?php } else { ?>
      <p>商品はありません。</p>
    <?php } ?> 
  </div>
   <!-- 削除の確認 -->
  <script>
    $('.delete').on('click', () => confirm('本当に削除しますか？'))
  </script>
</body>
</html>