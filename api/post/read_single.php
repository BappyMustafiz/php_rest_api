<?php
 // Headers
 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');

 include_once '../../config/Database.php';
 include_once '../../models/Post.php';

 //Instantiate DB & connect
 $database = new Database();
 $db = $database->connect();

 //Instantiate blog post object
 $post = new Post($db);

 //Get id from the url
 $post->id = isset($_GET['id']) ? $_GET['id'] : die();

 //read single method by get post
 $post->read_single();

 //Create array
 $post_arr = array(
 	'id'=>$post->id,
 	'title'=>$post->title,
 	'body'=>$post->body,
 	'author'=>$post->author,
 	'category_id'=>$post->category_id,
 	'category_name'=>$post->category_name
 );

 //Make JSON
 print_r(json_encode($post_arr));