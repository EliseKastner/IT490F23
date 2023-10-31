<?php

//Required files
    require_once('../rabbitmqphp_example/path.inc');
    require_once('../rabbitmqphp_example/get_host_info.inc');
    require_once('../rabbitmqphp_example/rabbitMQLib.inc');
    require_once('rabbitClient.php');
    require_once('dbConnection.php');

// Login Function
    function doLogin($username, $password){
        
        $connection = dbConnection();
        
        $query = "SELECT * FROM Users WHERE username = '$username'";
        $result = $connection->query($query);
        if($result){
            if($result->num_rows == 0){
                return false;
            }else{
                while ($row = $result->fetch_assoc()){
                    $salt = $row['salt']; 
                    $h_password = hashPassword($password, $salt);
                    if ($row['h_password'] == $h_password){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }
    }

 // Check username availibility function
    function checkUsername($username){
        
        $connection = dbConnection();
        
        //Query to check if the username is taken
        $check_username = "SELECT * FROM Users WHERE username = '$username'";
        $check_result = $connection->query($check_username);
        
        if($check_result){
            if($check_result->num_rows == 0){
                return true;
            }elseif($check_result->num_rows == 1){
                return false;
                }
        }
    }
   
   // Generates random string for salt
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
    
    // Hashes password for storing
    function hashPassword($password, $salt){
            $new_pass = $password . $salt;
             return hash("ek275", $new_pass);
        }
 

// Register function 
    function register($username, $password){
        
        //Makes connection to database
        $connection = dbConnection();
        
        //Generates a salt for the new user
        $salt = randomString(29);
        
        //Hashes password
        $h_password = hashPassword($password, $salt);
        
        //Query for a new user
        $newuser_query = "INSERT INTO Users  VALUES ('$username', $h_password', '$salt')";
        
        $result = $connection->query($newuser_query);
        
        return true;
    }

?>
