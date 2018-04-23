<?php

include('config.php');
include('functions.php');
$action = $_GET['action'];
$GID = get('G_ID');
$game = null;
$game_genre = array();

if(!empty($GID)) {
	$sql = file_get_contents('sql/getGame.sql');
	$params = array(
		'G_ID' => $GID
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$games = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$game = $games[0];
	
	$sql = file_get_contents('sql/getGameGenres.sql');
	$params = array(
		'G_ID' => $GID
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$game_genre_associative = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	foreach($game_genre_associative as $genre) {
		$game_genre[] = $genre['genreid'];
	}
}

$sql = file_get_contents('sql/getGenre.sql');
$statement = $database->prepare($sql);
$statement->execute();
$genres = $statement->fetchAll(PDO::FETCH_ASSOC); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$GID = $_POST['G_ID'];
	$title = $_POST['title'];
	$price = $_POST['game-price'];
    $dev = $_POST['Dev'];
	
	if($action == 'add') {
		$sql = file_get_contents('sql/insertGame.sql');
		$params = array(
			'G_ID' => $GID,
			'title' => $title,
			'price' => $price,
            'Dev' => $dev
		);
	
		$statement = $database->prepare($sql);
		$statement->execute($params);
		
		
		$sql = file_get_contents('sql/insertGameGenre.sql');
		$statement = $database->prepare($sql);
		
		foreach($game_genre as $genre) {
			$params = array(
				'G_ID' => $GID,
				'genreid' => $genreid
			);
			$statement->execute($params);
		}
	}
	
	elseif ($action == 'edit') {
		$sql = file_get_contents('sql/updateGame.sql');
        $params = array( 
            'G_ID' => $GID,
            'title' => $title,
            'price' => $price,
            'Dev' => $dev
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        $sql = file_get_contents('sql/removeGenre.sql');
        $params = array(
            'G_ID' => $GID
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
        
        //set categories for book
        $sql = file_get_contents('sql/insertGameGenre.sql');
        $statement = $database->prepare($sql);
        
        foreach($game_genre as $genre) {
            $params = array(
                'G_ID' => $GID,
                'genreid' => $genreid
            );
            $statement->execute($params);
        };	
	}
	
    header('location: index.php');
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Manage Game</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">


</head>
<body>
	<div class="page">
		<h1>Edit Game</h1>
		<form action="" method="POST">
    
			<div class="form-element">
				<label>Game ID:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="G_ID" class="textbox" value="<?php echo $game['G_ID'] ?>" />
				<?php else : ?>
					<input readonly type="text" name="G_ID" class="textbox" value="<?php echo $game['G_ID'] ?>" />
				<?php endif; ?>
			</div>

			<div class="form-element">
				<label>Title:</label>
				<input type="text" name="title" class="textbox" value="<?php echo $game['Title'] ?>" />
			</div>

			<div class="form-element">
				<label>Genre:</label>
				<?php foreach($genres as $genre) : ?>
					<?php if(in_array($genre['genreid'], $game_genre)) : ?>
						<input checked class="radio" type="checkbox" name="game-genre[]" value="<?php echo $genre['genreid'] ?>" /><span class="radio-label"><?php echo $genre['Name'] ?></span><br />
					<?php else : ?>
						<input class="radio" type="checkbox" name="game-genre[]" value="<?php echo $genre['genreid'] ?>" /><span class="radio-label"><?php echo $genre['Name'] ?></span><br />
					<?php endif; ?>
				<?php endforeach; ?>               
			</div>

			<div class="form-element">
				<label>Devloper</label>
				<input type="text" name="Dev" class="textbox" value="<?php echo $game['Dev'] ?>" />
			</div>

			<div class="form-element">
				<label>Price:</label>
				<input type="number" step="any" name="game-price" class="textbox" value="<?php echo $game['game-price'] ?>" />
			</div>

			<div class="form-element">
				<input type="submit" class="button" />&nbsp;
				<input type="reset" class="button" />
			</div>
		</form>
	</div>
</body>
</html>