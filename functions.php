<?php

	require("../../config.php");
	session_start();

	function signUp ($username, $email, $password, $age)	{
		
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		//sqli rida
		$stmt = $mysqli->prepare("INSERT INTO user_sample (username, email, password, age) VALUES (?, ?, ?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $username, $email, $password, $age);
		
		//täida käsku
		if($stmt ->execute() ) {
			
			echo "salvestamine õnnestus";
			
		} else {
			echo "ERROR ". $stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	
		
	function login ($username, $password) {
		
		$error = "";
		
		
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		//sqli rida
		$stmt = $mysqli->prepare("
		SELECT id, username, email, password, created 
		FROM user_sample WHERE username = ?");
		
		echo $mysqli->error;
		
		//asendan küsimärgi s on string (d on komaga arv, i on täisarv)
		$stmt->bind_param("s", $username);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $usernameFromDb, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		//on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//oli sellise emailiga kasutajat
			//password millega kasutaja tahab sisse logida
		$hash = hash("sha512", $password);
		if ($hash == $passwordFromDb) {
			echo "kasutaja logis sisse" .$id;
			
			$_SESSION["userId"] = $id;
			$_SESSION["userName"]= $usernameFromDb;
			$_SESSION["userEmail"] = $emailFromDb;
			
			$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
			
			//määran sessiooni muutujad millele saan ligi teistelt lehtedelt
			header("Location: data.php");
			exit();
			
		} else {
			$error = "vale parool";
			
		}
		
		} else {
			
			//ei leidnud kasutajat selle nimega
			$error = "ei ole sellist kasutajanime";
		}
			
		return $error; 
		
	}	
		
		function saveData ($Username, $bookAuthor, $bookName, $bookGenre) {
		
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_books(username, book_author, book_name, book_genre) VALUES (?, ?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $Username, $bookAuthor, $bookName, $bookGenre);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
		
	}
	
	function getBookData() {
	
		$database = "if16_anusada_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		$stmt = $mysqli->prepare("
		
		SELECT id, username, book_author, book_name, book_genre
		FROM user_books");
		
		echo $mysqli->error;
		
		$stmt->bind_result($id, $username, $book_author, $book_name, $book_genre);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		//tee seda seni, kuni on rida andmeid
		//mis vastab select lausele
		while($stmt->fetch()) {
			
			
		//tekitan objekti
		$i = new StdClass();
		
		$i->id = $id;
		$i->Username = $username;
		$i->bookAuthor = $book_author;
		$i->bookName = $book_name;
		$i->bookGenre = $book_genre;
		
		
		//echo $plate."<br>";
		//igakord massiivi lisan juurde nr märgi
		array_push($result, $i);				
		}
			
		
			
		$stmt->close();
		$mysqli->close();
		
		return $result;
		
	}
		
		
	function cleanInput($input){
		
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		
	return $input;		
		
	}

?>