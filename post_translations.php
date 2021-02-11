<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getProducts()
	{
		global $conn;
		$query = "SELECT * FROM post_translations ORDER BY id DESC";
		$response = array();
		$result = mysqli_query($conn, $query);

		$i=0;
		while($row = mysqli_fetch_array($result))
		{
			//echo $row["title"]."<br><br>";

            //`post_translations`(`id`, `post_id`, `locale`, `title`, `content`, `contact`)
			//$response[] = $row;

			$response[$i]["id"] = $row["id"];
			$response[$i]["post_id"] = $row["post_id"];
			$response[$i]["locale"] = $row["locale"];
			$response[$i]["title"] = $row["title"];
			$response[$i]["content"] = $row["content"];
			$response[$i]["contact"] = $row["contact"];

			$i++;
		}
		
		header("Content-type: application/json; charset=utf8mb4_unicode_ci");
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getProduct($id=0)
	{
		global $conn;
		$query = "SELECT * FROM post_translations";
		if($id != 0)
		{
			$query .= " WHERE post_id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);

		$i=0;
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
			
			$response[$i]["id"] = $row["id"];
			$response[$i]["post_id"] = $row["post_id"];
			$response[$i]["locale"] = $row["locale"];
			$response[$i]["title"] = $row["title"];
			$response[$i]["content"] = $row["content"];
			$response[$i]["contact"] = $row["contact"];

			$i++;
		}

		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	switch($request_method)
	{
		
		case 'GET':
			// Retrive Products
			if(!empty($_GET["id"]))
			{
				$id=intval($_GET["id"]);
				getProduct($id);
			}
			else
			{
				getProducts();
			}
            break;
            
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	/*********** function apart  */

	function getCountComment($idNews)
	{
		global $conn;
		$query = "SELECT count(*) FROM comments WHERE id_news=".$idNews;
		$response = array();
		$result = mysqli_query($conn, $query);
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;
		}
		
		return $response[0]["count(*)"];
	}

	//create function with an exception
	function checkContant($theVar) 
	{
		if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $theVar))
		{
			throw new Exception("Value must be 1 or below");
		}
		return true;
	}

	function techekForNull($theVar)
	{
		if(is_null($theVar))
		{
			return "the null one";
		}else
		{
			return $theVar;
		}
	}

	function clean($string) {
		$string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
		$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	 
		return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	 }
?>