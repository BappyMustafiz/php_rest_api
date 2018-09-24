<?php
 // Headers
 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');

 include_once '../../config/Database.php';
 include_once '../../models/Category.php';

 //Instantiate DB & connect
 $database = new Database();
 $db = $database->connect();

 //Instantiate category object
 $category = new Category($db);

 // Category query
 $result = $category->read();

 // Get row count
 $num = $result->rowCount();

 // Check if any posts
 if($num > 0){
 	//Post array
 	$cats_arr = array();
 	$cats_arr['data'] = array();

 	while($row = $result->fetch(PDO::FETCH_ASSOC)){
 		extract($row);

 		$cat_item = array(
 			'id'=>$id,
 			'name'=>$name
 		);

		// push to JSON
		array_push($cats_arr['data'], $cat_item); 		
 	}

 	//Turn to JSON & output
 	echo json_encode($cats_arr);
 } else {
 	//No category
 	echo json_decode(
 		array('message'=>'No Category Found')
 	);
 }