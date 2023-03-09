<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: DELETE');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/database.php';
	include_once '../../model/Quotes.php';

	$database = new Database();
	$db = $database->connect();
	
	$quotes = new Quotes($db);
		
	$data = json_decode(file_get_contents("php://input"));
	$quotes->id = $data->id;
	
	if ($quotes->id !== null) {
		if ($quotes->delete()) {
		echo json_encode(
			array('message' => 'Quote Deleted')
		);
	} else {
		echo json_encode(
			array('message' => 'Quote Not Deleted')
		);
	}
} else {
		echo json_encode(
			array('message' => 'Quote Not Found')
		);
	}
?>