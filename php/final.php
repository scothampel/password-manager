<?php
    $alpha = [
        "abcdefghijklmnopqrstuvwxyz",
        "ABCDEFGHIJKLMNOPQRSTUVWXYZ",
        "1234567890",
        "!@#$%^&*()-_"
    ];
    
    $constant = "jjwha71763y#Y&9!&*";
    
    if(isset($_POST["service"]) && isset($_POST["pass"]) && isset($_POST["length"])){
        #Set general variables
        $service = $_POST["service"];
        $pass = $_POST["pass"];
        $length = $_POST["length"];
        $cost = 10;
        
        if(!is_int($length) && ($length < 0 || $length > 16)){
            return false;
        }
        
        #Generate hashed salt and master pasword hash
        $salt = hash("sha512", $service.$constant);
        $salt = sprintf("$2a$%02d$", $cost) . $salt;
        $options = [
            "cost" => $cost,
            "salt" => $salt
        ];
        $hash = password_hash($pass, PASSWORD_DEFAULT, $options);
        
        #Remove algorithim and salt from master password hash
        $sub = substr($hash, 29);
        #Get characters of hash used for password generation based on desired length (Looks really complicated because of the need to calculate the correct number of chars to skip)
        $result = "";
        $index = 0;
        for($i = 0; $i < $length; $i++){
            $result .= substr($sub, $index, 1);
            if($i < (strlen($sub) - $length) % ($length - 1)){
                $index += floor((strlen($sub) - $length) / ($length - 1)) + 2;
            }
            else{
                $index += floor((strlen($sub) - $length) / ($length - 1)) + 1;
            }
        }
        
        #Populate array with ascii values of characters used for password generation
        $ascii = [];
        for($i = 0; $i < strlen($result); $i++){
            $ascii[] = ord(substr($result, $i, 1));
        }
        
        #Determine which alphabet to use for each character based on remainder of ascii value / 4 (4 alphabets)
        $mod = [];
        foreach($ascii as $val){
            $mod[] = $val % 4;
        }
        
        #Generate password
        $fin = "";
        for($i = 0; $i < count($ascii); $i++){
            $fin .= substr($alpha[$mod[$i]], $ascii[$i] % strlen($alpha[$mod[$i]]), 1);
        }
        
        #Return password to AJAX call
        echo $fin;
    }
?>