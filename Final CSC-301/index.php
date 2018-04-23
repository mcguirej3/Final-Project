<?php

include('config.php');
include('functions.php');


$term = get('search-term');

$games = searchGames($term, $database);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Games</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="page">
		<h1>Video Games</h1>
		<form method="GET">
			<input type="text" name="search-term" placeholder="Search..." />
			<input type="submit" />
		</form>
		<?php foreach($games as $game) : ?>
			<p>
				Title: <?php echo $game['Title']; ?><br />
				Developer: <?php echo $game['Dev']; ?> <br />
				Price: $<?php echo $game['game-price']; ?> <br />
				<a href="form.php?action=edit&G_ID=<?php echo $game['G_ID'] ?>">Edit Game</a><br />
			</p>
		<?php endforeach; ?>
		
        <p>Currently accessed by <?php echo $userName ?>. </p>
		
		<p>
			<a href="logout.php">Logout</a>
		</p>
	</div>
</body>
</html>