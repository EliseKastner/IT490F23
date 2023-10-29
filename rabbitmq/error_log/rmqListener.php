<?php
   
    //Required files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');



    function storeError($error, $fileName){
        $fp = fopen( $fileName . '.txt', "a" );
        for ($i = 0; $i < count($error); $i++){
          fwrite( $fp, $error[$i] );
        }
        return true;
    }


    // Routes the request from server to function
    function requestProcessor($request){
        echo "received request".PHP_EOL;
        echo $request['type'];
        
        // Shows incoming requests
        var_dump($request);
       
        if(!isset($request['type'])){
            return array('message'=>"ERROR: Message type is not supported");
        }
        switch($request['type']){
               
            // Frontend cases   
            case "frontend":
                echo "<br>in Frontend listner: ";
                $response_msg = storeError($request['error_string'], 'frontend_errors');
                break;
               
            // Database cases
            case "db":
                
                echo "<br>In Database listner: ";
                
                $response_msg = storeError($request['error_string'], 'db_errors');
                echo "Result: " . $response_msg;
                break;
       
        }
        echo $response_msg;
        return $response_msg;
    }

    //creating a new server
    $server = new rabbitMQServer('../rabbitmqphp_example/rabbitMQ_rmq.ini', 'testServer');
   
    //processes the request sent by client
    $server->process_requests('requestProcessor');
 
    ?>