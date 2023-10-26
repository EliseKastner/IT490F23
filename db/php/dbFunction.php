<?php

//Required files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    require_once('rabbitMQClient.php');
    require_once('dbConnection.php');

//Login function
    function doLogin($username, $passwd){
        
        $connection = dbConnection();
        
        $query = "SELECT * FROM Users WHERE username = '$username'";
        $result = $connection->query($query);
        if($result){
            if($result->num_rows == 0){
                return false;
            }else{
                while ($row = $result->fetch_assoc()){
                    $salt = $row['salt']; 
                    $password = hashPassword($passwd, $salt);
                    if ($row['password'] == $password){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }

//  Registration function 
    function register($username, $passwd){
        
        //Makes connection to database
        $connection = dbConnection();
        
        //Generates a salt for the new user
        $salt = randomString(29);
        
        //Hashes password
        $password = hashPassword($passwd, $salt);
        
        //Query for a new user
        $newuser_query = "INSERT INTO Users VALUES ('$username', '$password', '$salt')";
        
        $result = $connection->query($newuser_query);
        
        return true;
    }


//Hash function
    function hashPassword($passwd, $salt){
            $new_pass = $passwd . $salt;
             return hash("sha256", $new_pass);
        }

//Random string salt function
   function randomString($length) {
            $randstr = '';
            srand((double) microtime(TRUE) * 1000000);

            $chars = array(
                'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'p',
                'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '1', '2', '3', '4', '5',
                '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
                'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

            for ($rand = 0; $rand <= $length; $rand++) {
                $random = rand(0, count($chars) - 1);
                $randstr .= $chars[$random];
            }
            return $randstr;
   }


