<?php
	header('Content-Type: application/json');
	
	include_once '../../config/database.php';
	include_once '../../model/Quotes.php';
	
	$database = new Database();
	$db = $database->connect();
	
	$quotes = new Quotes($db);
	
	if ($quotes->quote != null) {
	if (isset($_GET['id'])) {
		$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();
		$quotes->read_single();
	
		$quotes_arr = array(
			'id' => $quotes->id,
			'quote' => $quotes->quote,
			'author' => $quotes->author,
			'category' => $quotes->category
		);
		echo json_encode($quotes_arr);
	} else {
		echo json_encode(
			array('message' => 'quote_id Not Found')
		);
	}
}
	
	if (isset($_GET['author_id'])) {
		$quotes->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
		$quotes_arr = $quotes->read_single();
	}
	
	if (isset($_GET['category_id'])) {
		$quotes->id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
		$quotes_arr = $quotes->read_single();
	}
	
	if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
		$quotes->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
		$quotes->read_single();
	}
	
	echo json_encode($quotes_arr);
?>