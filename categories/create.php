<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../config/database.php';
	include_once 'index.php';

	$database = new Database();
	$db = $database->connect();
	
	$categories = new Categories($db);
		
	$data = json_decode(file_get_contents("php://input"));
	$categories->category = $data->category;
	
	if ($categories->create()) {
		echo json_encode(
			array('message' => 'Category Created')
		);
	} else {
		echo json_encode(
			array('message' => 'Category Not Created')
		);
	}
?>