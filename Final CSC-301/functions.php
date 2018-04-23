<?php

function searchGames($term, $database) {
	$term = $term . '%';
	$sql = file_get_contents('sql/getGames.sql');
	$params = array(
		'term' => $term
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$games = $statement->fetchAll(PDO::FETCH_ASSOC);
	return $games;
}




function get($key) {
	if(isset($_GET[$key])) {
		return $_GET[$key];
	}
	
	else {
		return '';
	}
}