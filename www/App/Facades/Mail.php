<?php

namespace App\Facades;
use \App\MailBuilder;

class Mail
{
	public static function send(string $to, string $subject, string $message)
	{
		$mail = new MailBuilder();
		$mail->from("Camagru", "matcha@alexandregv.fr")
		->replyTo("matcha@alexandregv.fr")
		->contentType("text/html", "iso-8859-1")
		->to($to)
		->subject($subject)
		->message($message);

        return $mail->send();
    }
}

?>
