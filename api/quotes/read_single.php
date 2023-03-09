<?php
	header('Content-Type: application/json');
	
	include_once '../../config/database.php';
	include_once '../../model/Quotes.php';
	
	$database = new Database();
	$db = $database->connect();
	
	$quotes = new Quotes($db);
	
	if (isset($_GET['id'])) {
		$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();
		$quotes->read_single();
	
		$quotes_arr = array(
			'id' => $quotes->id,
			'quote' => $quotes->quote,
			'author' => $quotes->author,
			'category' => $quotes->category
		);
	}
	
	if (isset($_GET['author_id'])) {
		$quotes->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
		$quotes_arr = $quotes->read_single();
	}
	
	if (isset($_GET['category_id'])) {
		$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();
		$quotes_arr = $quotes->read_single();
	}
	
	if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
		$quotes->id = isset($_GET['id']) ? $_GET['id'] : die();
		$quotes->read_single();
	}
	
	echo json_encode($quotes_arr);
?>