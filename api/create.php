<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods : POST');


//initializing our api
include_once('../core/initialize.php');

//instantiate post

$post = new Post($db);

//get raw post data from user
$data=json_decode(file_get_contents("php://input"));

$post->title=$data->title;
$post->body=$data->body;
$post->author=$data->author;
$post->category_id = $data->category_id;

//create post
$post->create();
// if($post->create()){
//     $msg = array("message"=>"Post created successfully");
//     echo json_encode($msg);
// }
// else{
//     echo json_encode(array('message'=>'Post not created..'));
// }

?>