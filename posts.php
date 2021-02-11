<?php
	// Connect to database
	include("db_connect.php");
	$request_method = $_SERVER["REQUEST_METHOD"];

	function getProducts()
	{
		global $conn;
		$query = "SELECT * FROM posts ORDER BY id DESC";
		$response = array();
		$result = mysqli_query($conn, $query);

		$i=0;
		while($row = mysqli_fetch_array($result))
		{
            //INSERT INTO `posts`(`id`, `slug`, `cover`, `highlighted`, `category_id`, `author_id`, 
            //`created_at`, `updated_at`, `used`
			$response[] = $row;

			$response[$i]["id"] = $row["id"];
			$response[$i]["slug"] = $row["slug"];
			$response[$i]["cover"] = $row["cover"];
			$response[$i]["highlighted"] = $row["highlighted"];
			$response[$i]["category_id"] = $row["category_id"];
			$response[$i]["author_id"] = $row["author_id"];
			$response[$i]["created_at"] = $row["created_at"];
			$response[$i]["updated_at"] = $row["updated_at"];
			$response[$i]["used"] = $row["used"];

			$i++;
		}
		
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	function getProduct($id=0)
	{
		global $conn;
		$query = "SELECT * FROM posts";
		if($id != 0)
		{
			$query .= " WHERE id=".$id." LIMIT 1";
		}
		$response = array();
		$result = mysqli_query($conn, $query);

		$i=0;
		while($row = mysqli_fetch_array($result))
		{
			$response[] = $row;

			$response[$i]["id"] = $row["id"];
			$response[$i]["slug"] = $row["slug"];
			$response[$i]["cover"] = $row["cover"];
			$response[$i]["highlighted"] = $row["highlighted"];
			$response[$i]["category_id"] = $row["category_id"];
			$response[$i]["author_id"] = $row["author_id"];
			$response[$i]["created_at"] = $row["created_at"];
			$response[$i]["updated_at"] = $row["updated_at"];
			$response[$i]["used"] = $row["used"];

			$i++;
		}

        header('Content-Type: application/json; charset=UTF-8');
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
?>