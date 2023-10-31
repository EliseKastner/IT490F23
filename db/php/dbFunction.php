<?php

//Required files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    require_once('rabbitMQClient.php');
    require_once('dbConnection.php');



//  This function registers a new user 
    function register($username, $password){
        
        //Makes connection to database
        $connection = dbConnection();
        
        //Generates a salt for the new user
        $salt = randomString(29);
        
        //Hashes password
        $h_password = hashPassword($password, $salt);
        
        //Query for a new user
        $newuser_query = "INSERT INTO Users  VALUES ('$username', '$h_password', '$salt')";
        
        $result = $connection->query($newuser_query);
        
        return true;
    }
