<?php

    // Requires files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    require_once('rabbitMQClient.php');

    //  Starting sessions 
    //   session_start();
    

    // Function to secure session
    function gateway(){
        if (!$_SESSION["logged"]){
            header("Location: ../html/loginRegisterPage.html");
        }
    }

    // Sends login request to RabbitMQ
    function login($username, $password){
        
        $request = array();
        
        $request['type'] = "Login";
        $request['username'] = $username;
        $request['password'] = $password;

        $returnedValue = createClientForDb($request);
        
        if($returnedValue == 1){
            $_SESSION["username"] = $username;
            $_SESSION["logged"] = true;
        }else{
            session_destroy();
        }
       
        return $returnedValue;
    }

    //  Send registration requests to RabbitMQ
    function register($username, $password){
        
        $request = array();
        
        $request['type'] = "Register";
        $request['username'] = $username;
        $request['password'] = $password;

        $returnedValue = createClientForDb($request);

        return $returnedValue;
    }

    // Checks if username already exists
    function usernameVerification($username){
        
        $request = array();
        
        $request['type'] = "CheckUsername";
        $request['username'] = $username;

        $returnedValue = createClientForDb($request);

        return $returnedValue;
    } 

?>
