<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods : PUT');



//initializing our api
include_once('../core/initialize.php');

//instantiate post

$post = new Post($db);

//get raw post data from user
$data=json_decode(file_get_contents("php://input"));

$post->id=$data->id;
$post->title=$data->title;
$post->body=$data->body;
$post->author=$data->author;
$post->category_id = $data->category_id;

//create post
$post->update();

?>