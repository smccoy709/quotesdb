<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: PUT');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/database.php';
	include_once '../../model/Category.php';

	$database = new Database();
	$db = $database->connect();
	
	$categories = new Categories($db);
		
	$data = json_decode(file_get_contents("php://input"));
	$categories->id = $data->id;
	$categories->category = $data->category;
	
	var_dump($data);
	
	if ($categories->update()) {
		echo json_encode(
			array('message' => 'Category Updated')
		);
	} else {
		echo json_encode(
			array('message' => 'Category Not Updated')
		);
	}
?>