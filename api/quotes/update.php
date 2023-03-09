<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: PUT');
	header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');
	
	include_once '../../config/database.php';
	include_once '../../model/Quotes.php';

	$database = new Database();
	$db = $database->connect();
	
	$quotes = new Quotes($db);
		
	$data = json_decode(file_get_contents("php://input"));
	$quotes->id = $data->id;
	$quotes->quote = $data->quote;
	$quotes->author_id = $data->author_id;
	$quotes->category_id = $data->category_id;
	
	if ($quotes->update()) {
		echo json_encode(
			array('message' => 'Quote Updated')
		);
	} else {
		echo json_encode(
			array('message' => 'Quote Not Updated')
		);
	}
?>