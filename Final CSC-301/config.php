<?php

$user = 'mcguirej3';
$password = '8hedrazA';
$userName = 'admin';
$database = new PDO('mysql:host=localhost;dbname=db_spring18_mcguirej3', $user, $password);

session_start();

function my_autoloader($class) {
    include 'classes/class.' . $class . '.php';
}

spl_autoload_register('my_autoloader');

$current_url = basename($_SERVER['REQUEST_URI']);

if (!isset($_SESSION["userid"]) && $current_url != 'login.php') {
    header("Location: login.php");
}

elseif (isset($_SESSION["userid"])) {
    $user = new user('userid', $database);
}
