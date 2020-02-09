<?php

namespace App;

class MailBuilder
{
	private $_headers = "";
	private $_to      = "";
	private $_subject = "";
	private $_message = "";

	public function from(string $name, string $mail): MailBuilder
	{
        $this->_headers .= "From: $name<$mail>\n";
        return $this;
    }

	public function replyTo(string $mail): MailBuilder
	{
        $this->_headers .= "Reply-To: $mail\n";
        return $this;
    }

	public function contentType(string $type, string $charset): MailBuilder
	{
        $this->_headers .= "Content-Type: $type; charset=$charset";
        return $this;
    }

	public function to(string $mail): MailBuilder
	{
        $this->_to .= $mail;
        return $this;
    }

	public function subject(string $subject): MailBuilder
	{
        $this->_subject .= $subject;
        return $this;
    }

	public function message(string $message): MailBuilder
	{
        $this->_message .= $message;
        return $this;
    }

	public function send(): bool
	{
		return mail($this->_to, $this->_subject, $this->_message, $this->_headers);
	}

}

?>
