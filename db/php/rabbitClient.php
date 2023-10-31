<?php

    require_once('../php/dbConnection.php');
    require_once('/~/ek275/git/IT490F23/db/rabbitmqphp_example/path.inc');
    require_once('/~/ek275/git/IT490F23/db/rabbitmqphp_example/get_host_info.inc');
    require_once('/~/ek275/git/IT490F23/db/rabbitmqphp_example/rabbitMQLib.inc');
    

//    $connection = dbConnection();

        $file = fopen("/~/ek275/git/IT490F23/db/logs/log.txt","r");
        $errorArray = [];
        while(! feof($file)){
            array_push($errorArray, fgets($file));
        }

        fclose($file);


        $request = array();
        $request['type'] = "db";  
        $request['error_string'] = $errorArray;
        $returnedValue = createClientForRmq($request);

        $fp = fopen("/~/ek275/git/IT490F23/db/logs/logHistory.txt", "a");
        for($i = 0; $i < count($errorArray); $i++){
            fwrite($fp, $errorArray[$i]);
        }

        file_put_contents("/~/ek275/git/IT490F23/db/logs/log.txt", "");

    function createClientForRmq($request){
        $client = new rabbitMQClient("/~/ek275/git/IT490F23/db/rabbitmqphp_example/rabbitMQ_rmq.ini", "testServer");
       
        if(isset($argv[1])){
            $msg = $argv[1];
        }
        else{
            $msg = "client";
        }
        $response = $client->send_request($request);
        return $response;
    }

?>
