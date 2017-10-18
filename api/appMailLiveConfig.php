<?php
$container['mailer'] = function ($container) {
	$mailer = new \PHPMailer;
	$mailer->Host = 'localhost';  // your email host, to test I use localhost and check emails using test mail server application (catches all  sent mails)
	$mailer->SMTPAuth = false;                 // I set false for localhost
	$mailer->SMTPSecure = '';              // set blank for localhost
	$mailer->Port = 25;                           // 25 for local host
	$mailer->Username = 'your@email.address';    // I set sender email in my mailer call
	$mailer->Password = 'yourPassword';
	$mailer->isHTML(true);
	return new \Api\Classes\Mail\Mailer($container->view, $mailer);
};
