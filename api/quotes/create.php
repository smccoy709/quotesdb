<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: POST');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/database.php';
	include_once '../../model/Quotes.php';

	$database = new Database();
	$db = $database->connect();
	
	$quotes = new Quotes($db);
		
	$data = json_decode(file_get_contents("php://input"));
	$quotes->quote = $data->quote;

	if ($quotes->author_id !== null) {
		echo json_encode(
			$quotes->author_id = $data->author_id;
			if ($quotes->create()) {
				echo json_encode(
					array('message' => 'Quote Created')
				);
			} else {
				echo json_encode(
					array('message' => 'Quote Not Created')
				);
			}
		} else {
			echo json_encode(
				array('message' => 'category_id Not Found')
		);
	}
	
	$quotes->category_id = $data->category_id;
	
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