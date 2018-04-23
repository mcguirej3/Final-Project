<?php 

class user {
    protected $userID;
    protected $userName;
    protected $database;
    
    function __construct($userID, $database) {
       $sql = file_get_contents('sql/getUser.sql');
	   $params = array(
           'userid' => $_SESSION["userid"]
	    );
	   $statement = $database->prepare($sql);
	   $statement->execute($params);
	   $users = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	   $user = $users[0];
        
       $this->$userID = $userID;
       $userName =  $user;
	   }
}