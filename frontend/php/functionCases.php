<?php
    
    //Required files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    require_once('rabbitMQClient.php');

    // Includes functions
    include("functions.php");
    
    
    // Starts session
    session_start();

  

    //  Variable for type
    $type = $_GET["type"];

    //  Switch case for different requests
    switch ($type) {
            
        case "Login":                      
            
            $username = $_GET["username"];
            $password = $_GET["password"];
            
            $response = login($username, $password);
            echo $response;
            break;
            
        case "RegisterNewUser":
            
            $username = $_GET["username"];
            $password = $_GET["password"];
            
            $response = register($username, $password);
            echo $response;
            break;
            
        case "UsernameVerification":
            
            $username = $_GET["username"];
            
            $response = usernameVerification($username);
            echo $response;
	    break;
	
	default:

	    return "This is the default case.";
}

?>

