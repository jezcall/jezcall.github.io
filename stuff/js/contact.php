<?php
if (isset ($_POST['contactFF'])) {
  $to = "rijic03@mail.ru;
  $subject = "Отправлен отзыв на сайте ".$_SERVER['HTTP_REFERER'];
  $message = "Имя пользователя: ".$_POST['user_name']."\nФамилия пользователя ".$_POST['user_surname']."\nОтзыв пользователя ".$_POST['user_review']."\n\nАдрес сайта: ".$_SERVER['HTTP_REFERER'];
  
  $boundary = md5(date('r', time()));
  $filesize = '';
  $headers = "MIME-Version: 1.0\r\n";
  $headers .= "From: " . $from . "\r\n";
  $headers .= "Reply-To: " . $from . "\r\n";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
  $message="
Content-Type: multipart/mixed; boundary=\"$boundary\"
  
--$boundary
Content-Type: text/plain; charset=\"utf-8\"
Content-Transfer-Encoding: 7bit
  
$message";
     if(is_uploaded_file($_FILES['fileFF']['tmp_name'])) {
         $attachment = chunk_split(base64_encode(file_get_contents($_FILES['fileFF']['tmp_name'])));
         $filename = $_FILES['fileFF']['name'];
         $filetype = $_FILES['fileFF']['type'];
         $filesize = $_FILES['fileFF']['size'];
         $message.="
  
--$boundary
Content-Type: \"$filetype\"; name=\"$filename\"
Content-Transfer-Encoding: base64
Content-Disposition: attachment; filename=\"$filename\"
  
$attachment";
     }
   $message.="
--$boundary--";
  
  if ($filesize < 10000000) { // проверка на общий размер всех файлов. Многие почтовые сервисы не принимают вложения больше 10 МБ
    mail($to, $subject, $message, $headers);
    echo $_POST['nameFF'].', Ваше сообщение отправлено, спасибо!';
  } else {
    echo 'Извините, письмо не отправлено. Размер всех файлов превышает 10 МБ.';
  }
}