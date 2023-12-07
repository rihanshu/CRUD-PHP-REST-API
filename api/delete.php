<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods : DELETE');



//initializing our api
include_once('../core/initialize.php');

//instantiate post

$post = new Post($db);

//get raw post data from user
$data=json_decode(file_get_contents("php://input"));

$post->id=$data->id;

//create post
$post->delete();


?>