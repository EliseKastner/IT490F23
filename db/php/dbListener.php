<?php 

    //Required files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    require_once('dbFunctions.php');

    
    //Routes Request
    function requestProcessor($request){
        echo "received request".PHP_EOL;
        echo $request['type'];
        var_dump($request);
        
        if(!isset($request['type'])){
            return array('message'=>"ERROR: Message type is not supported");
        }
        switch($request['type']){
                
            //Login & Authentication request    
            case "Login":
                echo "<br>in login";
                $response_msg = doLogin($request['username'],$request['password']);
                break;

            //User registration
            case "Register":
                echo "<br>in register";
                $response_msg = register($request['username'], $request['password']);
                break;
                        }
        echo $response_msg;
        return $response_msg;
    }

    //creating a new server
    $server = new rabbitMQServer('../rabbitmqphp_example/rabbitMQ_db.ini', 'testServer');
    
    //processes the request sent by client
    $server->process_requests('requestProcessor');
   

?>
