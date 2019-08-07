<?php
$data = [];
foreach ($this->posts as $posts)
{
	$post = [];
	$post['id'] = $posts->getId();
	$post['creator_id'] = $posts->getCreator_id();
	$post['description'] = $posts->getDescription();
	$post['createdAt'] = $posts->getCreatedAt();
	$data[] = $post;
}

$resp = [
	"data" => $data,
	"status" => 200
];
echo json_encode($resp, JSON_PRETTY_PRINT);
?>
