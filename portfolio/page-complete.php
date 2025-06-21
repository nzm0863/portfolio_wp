<?php
$mailto = $_POST[ "email" ];
$subject = "お問い合わせ";
$header = "From:info@nnzzm.com";
$header .= "\n";
$header .= "Bcc:nakamura@nnzzm.com";
$message = "***************************************************" . "\n" . "\n" .
$_POST[ "f_name" ] . " 様、お問い合わせを頂き、誠にありがとうございます。" . "\n" .
"追って担当者よりご連絡させていただきます。" . "\n" . "\n" .
"こちらから送信したメールが迷惑フォルダに振り分けられてしまうケースがございます。" . "\n" .
"3日たっても返信がない場合はパソコンやスマートフォンの設定をご確認の上、恐れ入りますが、再度ご連絡を頂戴できればと存じます。" . "\n" . "\n" .
"***************************************************" . "\n" . "\n" .
"お客様からのお問い合わせを下記内容にて受け付けました" . "\n" . "\n" .
"名前：" . $_POST[ "f_name" ] . "\n" .
"メール：" . $_POST[ "email" ] . "\n" .
"電話番号：" . $_POST[ "tel" ] . "\n" .
"年齢：" . $_POST[ "age" ] . "\n" .
"希望連絡方法：" . $_POST[ "contact_means" ] . "\n" .
"メッセージ：" . "\n" . $_POST[ "comment" ];

mb_internal_encoding( "UTF-8" );

session_start();
// POSTされたトークンを取得
$token = isset($_POST["token"]) ? $_POST["token"] : "";
// セッション変数のトークンを取得
$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";
// セッション変数のトークンを削除
unset($_SESSION["token"]);
// POSTされたトークンとセッション変数のトークンの比較をして一致したら
if ($token != "" && $token == $session_token) {

  //メール送信
  mb_send_mail( $mailto, $subject, $message, $header );
  
  //文言
  $thanks = "お問い合わせありがとうございました。";
  $thanks2 = "ご入力内容を送信しました。<br>3日たっても返信がない場合はパソコンやスマートフォンの設定をご確認の上、恐れ入りますが再度ご連絡を頂戴できればと存じます。";
    
} else {
    
   $thanks = "セッションエラーです。";
   $thanks2 = "";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お問い合わせ</title>
    <link rel="stylesheet" href="./styles/sanitize.css">
    <link rel="stylesheet" href="./styles/comfirm.css">
</head>

<body>
<header>
  <div class="wrapper">
      <h1>お問い合わせフォーム</h1>
  </div>
</header>
        <div class="wrapper">
        <h2 class="mb_20 ta_center text_20"><?php echo $thanks ?></h2>
        <p class="ta_center"><?php echo $thanks2 ?></p>
        <h3 class="home"><a href="https://nnzzm.com/portfolio_wp/">Home</a></h3>
        </div>
</body>

</html>
