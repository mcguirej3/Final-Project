SELECT *
FROM user
WHERE 
	username = :username AND
	password = :password
	