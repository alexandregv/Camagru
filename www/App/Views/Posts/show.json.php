<?php
$data['id']			 = $this->post->getId();
$data['creator_id']  = $this->post->getCreator_id();
$data['description'] = $this->post->getDescription();
$data['createdAt']   = $this->post->getCreatedAt();

$resp = [
	"data" => $data,
	"status" => 200
];
echo json_encode($resp, JSON_PRETTY_PRINT);
?>
