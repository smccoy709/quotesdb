<?php	
	class Quotes{
		private $conn;
		private $table = 'quotes';
		
		public $id;
		public $quote;
		public $author;
		public $category;
		public $authorid;
		public $categoryid;
		
		public function __construct($db) {
			$this->conn = $db;
		}
		
		// Read all quotes
		
		public function display_quotes() {
			$query = 'SELECT
				quotes.id,
				quotes.quote,
				authors.author,
				categories.category
			FROM
				' . $this->table . '
			INNER JOIN
				authors
			ON
				quotes.author_id = authors.id
			INNER JOIN
				categories
			ON
				quotes.category_id = categories.id
			ORDER BY
				id';
				
			$stmt = $this->conn->prepare($query);
			$stmt->execute();
			return $stmt;
		}
		
		// Read single author
		
		public function read_single() {
			if (isset($_GET['id'])) {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.id = :id
				LIMIT 1';
			
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':id', $this->id);
				$stmt->execute();
				
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if (is_array($row)) {
					$this->id = $row['id'];
					$this->quote = $row['quote'];
					$this->author = $row['author'];
					$this->category = $row['category'];
				}
			}
			
			if (isset($_GET['authorid']) && isset($_GET['categoryid'])) {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.author_id = :authorid
				AND
					quotes.category_id = :categoryid
				ORDER BY quotes.id';
			
				$this->authorid = $_GET['authorid'];
				$this->categoryid = $_GET['categoryid'];
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':authorid', $this->authorid);
				$stmt->bindParam(':categoryid', $this->categoryid);
				$stmt->execute();
			
				$quotes = [];
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					
					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}
				
				return $quotes;
			} else if (isset($_GET['authorid'])) {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.author_id = :id
				ORDER BY quotes.id';
			
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':id', $this->id);
				$stmt->execute();
			
				$quotes = [];
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
					
					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}
				
				return $quotes;
			} else {
				$query = 'SELECT
					quotes.id,
					quotes.quote,
					authors.author,
					categories.category
				FROM
					' . $this->table . '
				INNER JOIN
					authors
				ON
					quotes.author_id = authors.id
				INNER JOIN
					categories
				ON
					quotes.category_id = categories.id
				WHERE
					quotes.category_id = :id
				ORDER BY quotes.id';
			
				$stmt = $this->conn->prepare($query);
				$stmt->bindParam(':id', $this->id);
				$stmt->execute();
			
				$quotes = [];
				
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);
				
					$quotes[] = [
						'id' => $id,
						'quote' => $quote,
						'author' => $author,
						'category' => $category
					];
				}
				
				return $quotes;
			}
		}
		
		// Create author
		
		public function create() {
			$query = 'INSERT INTO ' .
				$this->table . '(quote, author_id, category_id)
			VALUES(
				 :quote, :authorid, :categoryid)';
				
			$stmt = $this->conn->prepare($query);
			$this->quote = htmlspecialchars(strip_tags($this->quote));
			$this->authorid = htmlspecialchars(strip_tags($this->authorid));
			$this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
			$stmt->bindParam(':quote', $this->quote);
			$stmt->bindParam(':authorid', $this->authorid);
			$stmt->bindParam(':categoryid', $this->categoryid);
			
			if ($stmt->execute()) {
				return true;
			}
			
			printf("Error: %s.\n", $stmt->error);
			return false;
		}
		
		// Update author
		
		public function update() {
			$query = 'UPDATE ' .
				$this->table . '
			SET
				quote = :quote,
				author_id = :authorid,
				category_id = :categoryid
			WHERE
				id = :id';
				
			$stmt = $this->conn->prepare($query);
			$this->quote = htmlspecialchars(strip_tags($this->quote));
			$this->authorid = htmlspecialchars(strip_tags($this->authorid));
			$this->categoryid = htmlspecialchars(strip_tags($this->categoryid));
			$this->id = htmlspecialchars(strip_tags($this->id));
			$stmt->bindParam(':quote', $this->quote);
			$stmt->bindParam(':authorid', $this->authorid);
			$stmt->bindParam(':categoryid', $this->categoryid);
			$stmt->bindParam(':id', $this->id);
			
			if ($stmt->execute()) {
				return true;
			}
			
			printf("Error: %s.\n", $stmt->error);
			return false;
			
			echo $query;
		}
		
		// Delete author
		
		public function delete() {
			$query = 'DELETE FROM ' .
				$this->table .
			' WHERE id = :id';
			
			$stmt = $this->conn->prepare($query);
			
			$this->id = htmlspecialchars(strip_tags($this->id));
			
			$stmt->bindParam(':id', $this->id);
			
			if ($stmt->execute()) {
				return true;
			}
			
			printf("Error: %s.\n", $stmt->error);
			return false;
		}
	}
	
	if (isset($_GET['id'])) {
		include_once 'read_single.php';
	} else if (isset($_GET['authorid'])) {
		include_once 'read_single.php';
	} else if (isset($_GET['categoryid'])) {
		include_once 'read_single.php';
	} else if (isset($_GET['authorid']) && isset($_GET['categoryid'])) {
		include_once 'read_single.php';
	} else {
		include_once 'read.php';
	}
?>