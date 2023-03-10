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

	if(!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}

	$quotes->id = $data->id;
	$quotes->quote = $data->quote;
	$quotes->author_id = $data->author_id;
	$quotes->category_id = $data->category_id;
	
	if (isset($_GET['id'])) {
		$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();
		$quotes->update();
	
		$quotes_arr = array(
			'id' => $quotes->id,
			'quote' => $quotes->quote,
			'author' => $quotes->author,
			'category' => $quotes->category
		);

		if($quotes->quote !== null) {
			//Change to JSON data
			print_r(json_encode($quotes_arr, JSON_NUMERIC_CHECK));
		} else {
			echo json_encode(
				array('message' => 'No Quotes Found')
			);
		}
	}
	/*if($quotes->update()) {
		echo json_encode(
			array('id'=>$quotes->id, 'quote'=>$quotes->quote, 'author_id'=>$quotes->author_id, 'category_id'=>$quotes->category_id)
		);
	} else if (empty($quotes->quote)) {
		echo json_encode(
			array('message' => 'No Quotes Found')
		);
	}*/
?>