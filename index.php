<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon"href="favicon.ico">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>pusherApiTest</title>
</head>
<body>
 <form action="" method="POST">
  <p> Введите cluster </p>
  <input type="text" name="cluster" value="<?php if (isset($_POST['cluster'])) echo $_POST['cluster'] ?>">
  <p> Введите app_id </p>
  <input type="text" name="app_id" value="<?php if (isset($_POST['app_id'])) echo $_POST['app_id'] ?>">
  <p> Введите key </p>
  <input type="text" name="key" value="<?php if (isset($_POST['key'])) echo $_POST['key'] ?>">
  <p> Введите secret </p>
  <input type="text" name="secret" value="<?php if (isset($_POST['secret'])) echo $_POST['secret'] ?>">
  <p> Введите название события </p>
  <input type="text" name="event" value="<?php if (isset($_POST['event'])) echo $_POST['event'] ?>">
  <p> Введите название канала </p>
  <input type="text" name="channels" value="<?php if (isset($_POST['channels'])) echo $_POST['channels'] ?>">
  <p> Введите сообщение </p>
  <input type="text" name="data" value="<?php if (isset($_POST['data'])) echo $_POST['data'] ?>">
  <p>
    <select name="choice">
      <option value="1">Создать запрос с отправкой</option>
      <option value="2">Создать запрос без отправки</option>
    </select>
  </p>
  <input type="submit" name="formS" value="Выполнить">

</form>
<?php
if(!empty($_POST ["cluster"])){    $cluster = $_POST ["cluster"];
if(!empty($_POST ["app_id"])){     $app_id = $_POST ["app_id"];
if(!empty($_POST ["key"])){        $key = $_POST ["key"];
if(!empty($_POST ["secret"])){     $secret = $_POST ["secret"];
if(!empty($_POST ["event"])){      $event = $_POST ["event"];
if(!empty($_POST ["channels"])){   $channels = $_POST ["channels"];
if(!empty($_POST ["data"])){       $data = $_POST ["data"];
if(!empty($_POST ["choice"])){     $choice = $_POST ["choice"];}

$body = '{"name":"'.$event.'","channels":["'.$channels.'"],"data":"'.$data.'"}';
$auth_timestamp = time();
$auth_version = '1.0';
$body_md5 = md5($body);
$string_to_sign =
"POST\n/apps/" . $app_id .
"/events\nauth_key=" . $key .
"&auth_timestamp=". $auth_timestamp .
"&auth_version=" . $auth_version .
"&body_md5=" . $body_md5;

$auth_signature = hash_hmac('sha256', $string_to_sign, $secret);
if($choice == 1){
  $opts = array('http' =>
    array(
      'method'  => 'POST',
      'header'  => "Content-Type: application/json\r\n",
      'content' => $body,
    )
  );
  $context  = stream_context_create($opts);
  $url = 'http://api-'.$cluster.
  '.pusher.com/apps/'.$app_id.
  '/events?auth_key='.$key.
  '&auth_timestamp='.$auth_timestamp.
  '&auth_version=1.0&body_md5='.$body_md5.
  '&auth_signature='.$auth_signature;
  $result = file_get_contents($url, false, $context);
}

echo '<br>';
echo '<b>POST</b>';
echo '<br>';
echo 'url '.'http://api-'.$cluster.'.pusher.com/apps/'.$app_id.'/events';
echo '<br>';
echo '<b>Params</b>';
echo '<br>';
echo 'auth_key '.$key;
echo '<br>';
echo 'auth_timestamp '.$auth_timestamp;
echo '<br>';
echo 'auth_version '.$auth_version;
echo '<br>';
echo 'body_md5 '.$body_md5;
echo '<br>';
echo 'auth_signature '.$auth_signature;
echo '<br>';
echo '<b>Headers</b>';
echo '<br>';
echo 'Content-Type application/json';
echo '<br>';
echo '<b>Body</b>';
echo '<br>';
echo $body;
}}}}}}}
?>
</body>
</html>
