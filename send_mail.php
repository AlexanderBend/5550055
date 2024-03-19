<?php
// Файлы phpmailer
require 'php_mailer/PHPMailer.php';
require 'php_mailer/SMTP.php';
require 'php_mailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$email = $_POST['email'];
$text = $_POST['message'];


// Формирование самого письма
$title = "Заголовок письма";
$body = "
<h2>Новое письмо</h2>
<b>Имя:</b> $name<br>
<b>Почта:</b> $email<br><br>
<b>Сообщение:</b><br>$text
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'srv-mail-01'; // SMTP сервера вашей почты
    $mail->Username   = 'a.lapshin@olfonet.by'; // Логин на почте
    $mail->Password   = 'Krada5680'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom($mail, $name); // Адрес самой почты и имя отправителя
    //$mail->setFrom('mail@yandex.ru', 'Имя отправителя'); // Адрес самой почты и имя отправителя


    // Получатель письма
    $mail->addAddress('7395691@gmail.com');  


$mail->isHTML(true);
$mail->Subject = $title;
$mail->Body = $body;    

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "status" => $status]);
echo "<script>window.location.href='../index.php';</script>";