<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../config/database.php';
	include_once 'index.php';

	$database = new Database();
	$db = $database->connect();
	
	$quotes = new Quotes($db);
		
	$data = json_decode(file_get_contents("php://input"));
	$quotes->quote = $data->quote;
	$quotes->authorid = $data->authorid;
	$quotes->categoryid = $data->categoryid;
	
	if ($quotes->create()) {
		echo json_encode(
			array('message' => 'Quote Created')
		);
	} else {
		echo json_encode(
			array('message' => 'Quote Not Created')
		);
	}
?>