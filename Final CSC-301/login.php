<?php

include('config.php');
include('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$sql = file_get_contents('sql/attemptLogin.sql');
	$params = array(
		'username' => $username,
		'password' => $password
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	if(!empty($users)) {
		$user = $users[0];
		$_SESSION['userid'] = $user['userid'];	
        $_SESSION['name'] = $username['username'];
		header('location: index.php');
        die();
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Login</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/style.css">

</head>
<body>
	<div class="page">
		<h1>Login</h1>
		<form method="POST">
			<input type="text" name="username" placeholder="Username" />
			<input type="password" name="password" placeholder="Password" />
			<input type="submit" value="Log In" />
		</form>
	</div>
</body>
</html>