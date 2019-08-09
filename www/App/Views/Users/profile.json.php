<?php
$data = [];
$data['id']					= $this->user->getId();
$data['username']			= $this->user->getUsername();
$data['email']				= $this->user->getEmail();
$data['firstname']			= $this->user->getFirstname();
$data['lastname']			= $this->user->getLastname();
$data['likeNotifications']	= $this->user->getLikeNotifications();

$resp = [
	"data" => $data,
	"status" => 200
];
echo json_encode($resp, JSON_PRETTY_PRINT);
?>
