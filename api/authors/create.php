<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/database.php';
	include_once '../../model/Author.php';

	$database = new Database();
	$db = $database->connect();
	
	$authors = new Authors($db);
		
	$data = json_decode(file_get_contents("php://input"));
	$authors->author = $data->author;
	
	if ($authors->create()) {
		echo json_encode(
			array('message' => 'Author Created')
		);
	} else {
		echo json_encode(
			array('message' => 'Author Not Created')
		);
	}
?>