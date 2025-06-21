<?php

session_start();
// 二重送信防止用トークンの発行
$token = uniqid('', true);
//トークンをセッション変数にセット
$_SESSION['token'] = $token;

function convert_char( $target ) {
  $target = stripslashes( $target );
  $target = htmlspecialchars( $target, ENT_QUOTES );
  return $target;
}

if (isset($_POST['contact_type']) && is_array($_POST['contact_type'])) {
    $contact_type = implode("、", $_POST["contact_type"]);
}

$f_name = convert_char( $_POST[ "f_name" ] );
$email = convert_char( $_POST[ "email" ] );
$tel = convert_char( $_POST[ "tel" ] );
$age = convert_char( $_POST[ "age" ] );
$contact_means = convert_char( $_POST[ "contact_means" ] );
$comment = convert_char( $_POST[ "comment" ] );

$comment_conv = nl2br( $comment, false );

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
    <form action="page-complete.php" method="post" id="contact_form" class="h-adr">
      <div class="sp100 of_x">
        <table id="contactform_table" class="width81 mb_30">
          <tr>
            <th>名前</th>
            <td><?php echo $f_name; ?></td>
          </tr>
          <tr>
            <th>メール</th>
            <td><?php echo $email; ?></td>
          </tr>
          <tr>
            <th>電話番号</th>
            <td><?php echo $tel; ?></td>
          </tr>
          <tr>
            <th>年齢</th>
            <td><?php echo $age; ?></td>
          </tr>
          <tr>
            <th>希望連絡方法</th>
            <td><?php echo $contact_means; ?></td>
          </tr>
          <tr class="contact-message">
            <th>メッセージ</label></th>
            <td><?php echo $comment_conv; ?></td>
          </tr>
          <tr>
            <td colspan="2"><input type="button" value="戻る" onclick="history.back()"> <input type="submit" name="Submit" value="送信" id="submit" class="form_btn"></td>
          </tr>
        </table>
      </div>
      
        <input type="hidden" name="f_name" value="<?php echo $_POST['f_name']; ?>">
        <input type="hidden" name="email" value="<?php echo $_POST['email']; ?>">
        <input type="hidden" name="tel" value="<?php echo $_POST['tel']; ?>">
        <input type="hidden" name="age" value="<?php echo $_POST['age']; ?>">
        <input type="hidden" name="contact_means" value="<?php echo $_POST['contact_means']; ?>">
        <input type="hidden" name="contact_type" value="<?php echo $contact_type; ?>">
        <input type="hidden" name="comment" value="<?php echo $_POST['comment']; ?>">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
    </form>
  </div>

</body>

</html>
