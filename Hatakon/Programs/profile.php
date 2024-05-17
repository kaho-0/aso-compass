<?php
 
// （4）input="file"でpost送信された情報の受け取り
if(!empty($_FILES)){
 
// ファイル名を取得
$filename = $_FILES['upload_image']['name'];
 
//move_uploaded_file（第1引数：ファイル名,第2引数：格納後のディレクトリ/ファイル名）
// 第2引数に使う部分
$uploaded_path = 'images_after/'.$filename;
//echo $uploaded_path.'<br>';
 
$result = move_uploaded_file($_FILES['upload_image']['tmp_name'],$uploaded_path);
 
if($result){
  $MSG = 'アップロード成功！ファイル名：'.$filename;
  $img_path = $uploaded_path;
}else{
  $MSG = 'アップロード失敗！エラーコード：'.$_FILES['upload_image']['error'];
}
 
}else{
  $MSG = '画像を選択してください';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>title</title>

    <!--fontのリンク-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Advent+Pro:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&display=swap" rel="stylesheet">
    <!--iconのリンク-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="icon" href="../assets/image/favicon.ico">
    <!--Bootstrap5のリンク-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!--style.cssに書き加えて、cssのファイル名を変更してください-->
    <link rel="stylesheet" href="../assets/css/profile.css">
</head>
<body>
    <h1>アカウント情報</h1>

<section class="form-container">
 
    <p><?php if(!empty($MSG)) echo $MSG;?></p>
     
      <?php if(!empty($img_path)){;?>
     
       <img src="<?php echo $img_path;?>" alt="">
     
      <?php } ;?>
     
      <form action="" method="post" enctype="multipart/form-data">
     
        <input type="file" name="upload_image">
     
        <input type="submit" calss="btn_submit" value="送信">
     
      </form>
    </section>
     
    <section class="img-area">
     
    <?php
    if(!empty($img_path)){  ?>
     <img src="echo <?php $img_path;?>" alt="">
    <?php
    }
    ?>
    </section>
    <p>氏名は本名を、パスワードは半角英数で入力してください。</p>
    <label>
        <span class="textbox-label">氏名</span>
        <input type="text" class="textbox" placeholder=""/>
    </label>
    <br>
    <label>
        <span class="textbox-label">学籍番号</span>
        <input type="text" class="textbox" placeholder=""/>
    </label>
    <br>
    <label>
        <span class="textbox-label">パスワード</span>
        <input type="text" class="textbox" placeholder=""/>
    </label>
     <br>
    <button class="button">登録/更新</button>
</body>
</html>